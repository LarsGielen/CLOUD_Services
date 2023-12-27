// main.js

const GrpcMessageClient = require('./GrpcClient.js');

var grpcMessageClient = new GrpcMessageClient('http://localhost:6060');

var senderIDInput = document.querySelector("#senderID");
var usernameInput = document.querySelector("#username");
var connectButton = document.querySelector("#connect");

var receiverIDInput = document.querySelector("#receiverID");
var messageInput = document.querySelector("#message");
var sendButton = document.querySelector("#send");

var output = document.querySelector("#output");

connectButton.onclick = function () {
    grpcMessageClient.connectToMessageStream (
        senderIDInput.value,
        usernameInput.value,
        (data) => {
            console.log('Received message:', data.getMessage());
            console.log('Status:', data.getStatus());
            console.log('Sender:', data.getSender().getUserid());
            console.log('Timestamp:', data.getTimestamp());

            var paragraph = document.createElement('p');
            paragraph.textContent = data.getSender().getUsername() + ": " + data.getMessage();
            output.appendChild(paragraph);
        },
        ()    => console.log('Stream ended'),
        (error) => console.error('Stream error:', error)
    );
}

sendButton.onclick = function () {
    grpcMessageClient.sendMessage(
        senderIDInput.value,
        usernameInput.value,
        receiverIDInput.value,
        messageInput.value
    );

    var paragraph = document.createElement('p');
    paragraph.textContent = usernameInput.value+ ": " + messageInput.value;
    output.appendChild(paragraph);
}
