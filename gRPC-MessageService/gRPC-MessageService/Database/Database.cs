using Microsoft.Data.Sqlite;

namespace Database;

class DatabaseHandler
{
    private string databaseLocation = "Data Source=Database/database.db";

    public void InsertMessage(MessageInfo messageInfo)
    {
        using (var connection = new SqliteConnection(databaseLocation))
        {
            connection.Open();

            using (var command = connection.CreateCommand())
            {
                command.CommandText = @"
                    INSERT INTO Messages (MessageText, SenderId, senderUsername, ReceiverId, ReceiverUsername) 
                    VALUES (@messageText, @senderId, @senderUsername, @receiverId, @receiverUsername)
                ";
                command.Parameters.AddWithValue("@messageText", messageInfo.MessageText);
                command.Parameters.AddWithValue("@senderId", messageInfo.Sender.UserID);
                command.Parameters.AddWithValue("@senderUsername", messageInfo.Sender.Username);
                command.Parameters.AddWithValue("@receiverId", messageInfo.Receiver.UserID);
                command.Parameters.AddWithValue("@receiverUsername", messageInfo.Receiver.Username);

                command.ExecuteNonQuery();
            }

            connection.Close();
        }
    }

    public List<MessageInfo> GetMessagesByReceiver(int receiverId)
    {
        List<MessageInfo> messages = new List<MessageInfo>();

        using (var connection = new SqliteConnection(databaseLocation))
        {
            connection.Open();

            // Retrieve messages with a specific receiver
            using (var command = connection.CreateCommand())
            {
                command.CommandText = "SELECT * FROM Messages WHERE ReceiverId = @receiverId";
                command.Parameters.AddWithValue("@receiverId", receiverId);

                messages = MessagesCommandToList(command);
            }

            connection.Close();
        }

        return messages;
    }

    public List<MessageInfo> GetMessagesBySender(int senderId)
    {
        List<MessageInfo> messages = new List<MessageInfo>();

        using (var connection = new SqliteConnection(databaseLocation))
        {
            connection.Open();

            // Retrieve messages with a specific sender
            using (var command = connection.CreateCommand())
            {
                command.CommandText = "SELECT * FROM Messages WHERE SenderId = @senderId";
                command.Parameters.AddWithValue("@senderId", senderId);

                messages = MessagesCommandToList(command);
            }

            connection.Close();
        }

        return messages;
    }

    public List<MessageInfo> GetMessagesBySenderAndReceiver(int senderId, int receiverId)
    {
        List<MessageInfo> messages = new List<MessageInfo>();

        using (var connection = new SqliteConnection(databaseLocation))
        {
            connection.Open();

            // Retrieve messages with a specific sender and receiver
            using (var command = connection.CreateCommand())
            {
                command.CommandText = "SELECT * FROM Messages WHERE SenderId = @senderId AND ReceiverId = @receiverId";
                command.Parameters.AddWithValue("@senderId", senderId);
                command.Parameters.AddWithValue("@receiverId", receiverId);

                messages = MessagesCommandToList(command);
            }

            connection.Close();
        }

        return messages;
    }

    private List<MessageInfo> MessagesCommandToList(SqliteCommand command) {

        List<MessageInfo> messages = new List<MessageInfo>();

        using (var reader = command.ExecuteReader())
        {
            while (reader.Read())
            {
                messages.Add(new MessageInfo
                {
                    MessageText = reader.GetString(reader.GetOrdinal("MessageText")),
                    Sender = new UserInfo {
                        UserID = reader.GetInt32(reader.GetOrdinal("SenderId")),
                        Username = reader.GetString(reader.GetOrdinal("SenderUsername"))
                    },
                    Receiver = new UserInfo {
                        UserID = reader.GetInt32(reader.GetOrdinal("ReceiverId")),
                        Username = reader.GetString(reader.GetOrdinal("ReceiverUsername"))
                    },
                    TimeOfSend = reader.GetDateTime(reader.GetOrdinal("Timestamp"))
                });
            }
        }

        return messages;
    }
}