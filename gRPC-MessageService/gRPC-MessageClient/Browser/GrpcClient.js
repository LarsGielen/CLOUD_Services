
const { ClientMessage, User } = require('./protobuf_pb.js');
const { MessageServiceClient } = require('./protobuf_grpc_web_pb.js');

/**
 * GrpcClient class represents a gRPC client for interacting with the MessageService.
 * @class
 */
class GrpcMessageClient {

    /**
     * Creates an instance of GrpcClient.
     * @param {string} serverUrl - The URL of the gRPC server
     */
    constructor(serverUrl) {

        /**
         * gRPC client for the MessageService.
         * @type {MessageServiceClient}
         * @private
         */
        this.client = new MessageServiceClient(serverUrl);
    }

    /**
     * Connects to the message stream and sets up event handlers
     * @param {number} senderID - The ID of the sending user
     * @param {string} username - The username of the sending user
     * @param {function} onDataCallback - Callback function for handling incoming data - Function (data)
     * @param {function} onEndCallback - Callback function for handling stream end - Function ()
     * @param {function} onErrorCallback - Callback function for handling errors - Function (error)
     */
    connectToMessageStream(senderID, username, onDataCallback, onEndCallback, onErrorCallback) {
        var sendingUser = new User();
        sendingUser.setUserid(senderID);
        sendingUser.setUsername(username);

        var stream = this.client.openMessageStream(sendingUser);

        stream.on('data', onDataCallback);
        stream.on('end', onEndCallback);
        stream.on('error', onErrorCallback);
    }

    /**
     * Sends a message to a specific user.
     * @param {number} senderID - The ID of the sending user
     * @param {string} username - The username of the sending user
     * @param {number} receiverID - The ID of the receiving user
     * @param {string} messageText - The text of the message to be sent
     */
    sendMessage(senderID, username, receiverID, messageText) {
        var sendingUser = new User();
        sendingUser.setUserid(senderID);
        sendingUser.setUsername(username);

        var receivingUser = new User();
        receivingUser.setUserid(receiverID);

        var message = new ClientMessage();
        message.setMessage(messageText);
        message.setSendinguser(sendingUser);
        message.setReceivinguser(receivingUser);

        this.client.sendMessageToUser(message);
    }
}

module.exports = GrpcMessageClient;
