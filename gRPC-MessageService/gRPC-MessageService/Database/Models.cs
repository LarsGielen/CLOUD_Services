using Grpc.Core;
using MessageServiceServer;

namespace Database;

struct MessageInfo {
    public UserInfo Sender;
    public UserInfo Receiver;
    public string MessageText;
    public DateTimeOffset TimeOfSend;
}

struct UserInfo {
    public int UserID;
    public string Username;
    public IServerStreamWriter<StreamMessage> Stream;
}