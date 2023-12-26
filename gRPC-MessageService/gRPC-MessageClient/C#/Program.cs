using System.Diagnostics;
using Grpc.Core;
using Grpc.Net.Client;
using MessageServiceClient;

// The port number must match the port of the gRPC server.
using var channel = GrpcChannel.ForAddress("http://localhost:6061");
var client = new MessageService.MessageServiceClient(channel);

// Get user information from the console and create user
int? userID = null;
string? username = null;
do {
    Console.Write("Enter your user ID: ");
    int.TryParse(Console.ReadLine(), out int userid);
    userID = userid;

    Console.Write("Enter your username: ");
    username = Console.ReadLine();
} while (userID == null || username == null);
var user = new User { UserID=(int)userID, UserName=username };

Console.WriteLine("");
 
// open a stream and listen to incomming messages in a seperate thread
var stream = client.openMessageStream(user);
var cancelStreamToken = new CancellationTokenSource();
var listenToIncommingMessages = Task.Run(async () => {
    try {
        while (await stream.ResponseStream.MoveNext(cancelStreamToken.Token))
        {
            var message = stream.ResponseStream.Current;
            if (message.Status != MessageServiceClient.Status.Ok) {
                Console.ForegroundColor = ConsoleColor.Yellow;
                Console.WriteLine($"Debug: {message.Message}");
                Console.ForegroundColor = ConsoleColor.White;
            }
            else {
                Console.ForegroundColor = ConsoleColor.Cyan;
                Console.WriteLine($"{message.Sender.UserName}: {message.Message}");
                Console.ForegroundColor = ConsoleColor.White;
            }
        }
    }
    catch (RpcException){
        Console.ForegroundColor = ConsoleColor.Yellow;
        Console.WriteLine($"Client closed the connection");
        Console.ForegroundColor = ConsoleColor.White;
    }
});

// ask to sent messages to a user with id
while (true) {
    Console.WriteLine("Press any key to sent a message, press 'e' to exit");
    if (Console.ReadKey().Key == ConsoleKey.E) break;

    int? id = null;
    do {
        Console.WriteLine("");
        Console.Write("Enter the ID of the receiver: ");
        string? value = Console.ReadLine();
        if (value != null) id = int.Parse(value);
    } while (id == null);

    string? messageString = null;
    do {
        Console.WriteLine("");
        Console.Write("Enter the message you want to sent: ");
        messageString = Console.ReadLine();
    } while (messageString == null);

    client.sendMessageToUser( new ClientMessage {
        SendingUser = user,
        ReceivingUser = new User { UserID = (int)id },
        Message = messageString
    });
}

// close the stream, then wait until all last messages have been received
cancelStreamToken.Cancel();
await listenToIncommingMessages;

// Shut down connection
channel.ShutdownAsync().Wait();

Console.WriteLine("Press any key to exit...");
Console.ReadKey();