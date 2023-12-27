
const { ClientMessage, User } = require('./generated/protobuf_pb.js');
const { MessageServiceClient } = require('./generated/protobuf_grpc_web_pb.js');

var grpcMessageClient = {}; 

grpcMessageClient.openMessageStream = function (serverURL, senderID, username, onDataCallback, onEndCallback, onErrorCallback) {

    var client = new MessageServiceClient(serverURL)

    var sendingUser = new User();
    sendingUser.setUserid(senderID);
    sendingUser.setUsername(username);

    var stream = client.openMessageStream(sendingUser);

    stream.on('data', onDataCallback);
    stream.on('end', onEndCallback);
    stream.on('error', onErrorCallback);
}

grpcMessageClient.sendMessageToUser = function (serverURL, senderID, username, receiverID, messageText) {

    var client = new MessageServiceClient(serverURL)

    var sendingUser = new User();
    sendingUser.setUserid(senderID);
    sendingUser.setUsername(username);

    var receivingUser = new User();
    receivingUser.setUserid(receiverID);

    var message = new ClientMessage();
    message.setMessage(messageText);
    message.setSendinguser(sendingUser);
    message.setReceivinguser(receivingUser);

    client.sendMessageToUser(message);
}

module.exports = grpcMessageClient;
