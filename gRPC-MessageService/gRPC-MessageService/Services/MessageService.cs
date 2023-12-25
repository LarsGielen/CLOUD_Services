using Grpc.Core;
using System.Collections.Concurrent;
using Database;
using Google.Protobuf.WellKnownTypes;

namespace MessageServiceServer.Services;

public class MessageServiceImplementation : MessageService.MessageServiceBase
{
    // needs to be static becouse each client call gets its own MessageServiceImplementation
    private static readonly ConcurrentDictionary<int, UserInfo> connectedClients = new ConcurrentDictionary<int, UserInfo>();

    public override Task<StatusResponse> sendMessageToUser(ClientMessage message, ServerCallContext context)
    {
        // add message to database
        DatabaseHandler db = new DatabaseHandler();
        db.InsertMessage(new MessageInfo {
            MessageText = message.Message,
            Sender = new UserInfo   { UserID = message.SendingUser.UserID, Username = message.SendingUser.UserName},
            Receiver = new UserInfo { UserID = message.ReceivingUser.UserID, Username = message.ReceivingUser.UserName}
        });

        // check if both users have an open stream
        if (!connectedClients.ContainsKey(message.SendingUser.UserID)) {
            return Task.FromResult(new StatusResponse
            {
                Status = Status.Warning,
                Message = "Client needs to have an open stream to sent messages"
            });
        }

        if (!connectedClients.ContainsKey(message.ReceivingUser.UserID)) {
            // receiving user is not connected
            return Task.FromResult(new StatusResponse
            {
                Status = Status.Debug,
                Message = "Dit moet nog veranderd worden"
            });
        }

        // get receiving user
        if (!connectedClients.TryGetValue(message.ReceivingUser.UserID, out UserInfo receiverInfo)) {
            // Should not happen
            return Task.FromResult(new StatusResponse
            {
                Status = Status.Error,
                Message = "Cant load receiving client"
            });
        }

        receiverInfo.Stream.WriteAsync( new StreamMessage {
            Status = Status.Ok,
            Message = message.Message,
            Sender = message.SendingUser,
            Timestamp = Timestamp.FromDateTime(DateTime.Now)
        });

        return Task.FromResult(new StatusResponse
        {
            Status = Status.Ok,
            Message = "Message sent successfully"
        });
    }

    public override async Task openMessageStream(User user, IServerStreamWriter<StreamMessage> responseStream, ServerCallContext context)
    {
        // Try to save the connection
        bool saveSucces = connectedClients.TryAdd(user.UserID, new UserInfo {
            UserID = user.UserID,
            Username = user.UserName,
            Stream = responseStream
        });

        if (saveSucces == false) {
            // The user already has an open stream

            // close the new stream
            await responseStream.WriteAsync( new StreamMessage {
                Status = Status.Warning, 
                Message = "Client already has an open stream",
                Sender = new User { UserID = -1, UserName = "Server"},
                Timestamp = Timestamp.FromDateTime(DateTime.Now)
            });

            return;
        }

        Console.ForegroundColor = ConsoleColor.Yellow;
        Console.WriteLine($"Client {user.UserName} has connected", ConsoleColor.Yellow);
        Console.ForegroundColor = ConsoleColor.White;

        // open the stream
        await responseStream.WriteAsync( new StreamMessage { 
            Status = Status.Debug,
            Message = "Stream has been is opened",
            Sender = new User { UserID = -1, UserName = "Server"},
            Timestamp = Timestamp.FromDateTimeOffset(DateTimeOffset.Now)
        });

        Console.ForegroundColor = ConsoleColor.Yellow;
        Console.WriteLine($"Client {user.UserName} has opened a stream", ConsoleColor.Yellow);
        Console.ForegroundColor = ConsoleColor.White;

        // send all stored messages
        var storedMessages = new DatabaseHandler().GetMessagesByReceiver(user.UserID);
        storedMessages.ForEach ( async messageInfo => {
            await responseStream.WriteAsync( new StreamMessage {
                Status = Status.Ok,
                Message = messageInfo.MessageText,
                Sender = new User { UserID = messageInfo.Sender.UserID, UserName = messageInfo.Sender.Username},
                Timestamp = Timestamp.FromDateTimeOffset(messageInfo.TimeOfSend)
            });
        });

        // Keep the stream open until a cancellation is requested
        while (!context.CancellationToken.IsCancellationRequested) {
            await Task.Delay(100); // check every 100ms
        }

        // Cancellation was requested, remove the client
        if (!connectedClients.TryRemove(user.UserID, out var _)) {
            // removal has failed (should not happen)
            return;
        }

        Console.ForegroundColor = ConsoleColor.Yellow;
        Console.WriteLine($"Client {user.UserName} has disconnected");
        Console.ForegroundColor = ConsoleColor.White;
    }
}
