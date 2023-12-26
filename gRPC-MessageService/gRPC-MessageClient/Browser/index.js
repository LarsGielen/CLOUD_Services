const {ClientMessage, Status, StatusResponse, StreamMessage, User} = require('./protobuf_pb.js');
const {MessageServiceClient} = require('./protobuf_grpc_web_pb.js');

var client = new MessageServiceClient('http://localhost:6060');

var senderIDInput = document.querySelector("#senderID");
var usernameInput = document.querySelector("#username");
var connectButton = document.querySelector("#connect");

var receiverIDInput = document.querySelector("#receiverID");
var messageInput = document.querySelector("#message");
var sendButton = document.querySelector("#send");

var output = document.querySelector("#output");

connectButton.onclick= function () {

    var sendingUser = new User();
    sendingUser.setUserid( senderIDInput.value );
    sendingUser.setUsername( usernameInput.value );

    var stream = client.openMessageStream(sendingUser);

    stream.on('data', (response) => {
        console.log('Received message:', response.getMessage());
        console.log('Status:', response.getStatus());
        console.log('Sender:', response.getSender().getUserid());
        console.log('Timestamp:', response.getTimestamp());

        var paragraph = document.createElement('p');
        paragraph.textContent = response.getSender().getUsername() + ": " + response.getMessage();
        output.appendChild(paragraph);
    });

    // Handle stream close or errors
    stream.on('end', function () {
        console.log('Stream ended');
    });

    stream.on('error', function (err) {
        console.error('Stream error:', err);
    });
}

sendButton.onclick = function() {
    
    var sendingUser = new User();
    sendingUser.setUserid( senderIDInput.value );
    sendingUser.setUsername( usernameInput.value );

    var receivingUser = new User();
    receivingUser.setUserid( receiverIDInput.value );

    var message = new ClientMessage();
    message.setMessage(messageInput.value);
    message.setSendinguser( sendingUser );
    message.setReceivinguser( receivingUser );

    client.sendMessageToUser(message);
}