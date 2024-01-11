var joinField = null;
var inputField = null;

var connectButton = null;
var disConnectButton = null;
var joinButton = null;
var leaveButton = null;

var musicSessionServerURL = '127.0.0.1:8081';

window.onload = function() {
    joinField = document.querySelector("#joinField");
    inputField = document.querySelector("#inputField");

    connectButton = document.querySelector('#connectBtn');
    disConnectButton = document.querySelector('#disconnectBtn');
    joinButton = document.querySelector("#joinBtn");
    leaveButton = document.querySelector("#leaveBtn");

    connectButton.onclick = onConnectButton;
    disConnectButton.onclick = onDisconnectButton;
    joinButton.onclick = onJoinButton;
    leaveButton.onclick = onLeaveButton;

    MusicSessionClient.onConnect = onConnect;
    MusicSessionClient.onDisconnect = onDisconnect;
    MusicSessionClient.onMessage = onMessage;
    MusicSessionClient.onError = null

    inputField.addEventListener('input', onInputFieldChanged);

    connectButton.disabled = false;
    disConnectButton.disabled = true;

    joinField.disabled = true;
    inputField.disabled = true;
    joinButton.disabled = true;
    leaveButton.disabled = true;
}

function sendMessage(status) {
    var data = {
        roomName: joinField.value,
        sharedText: inputField.value,
        status: status
    }

    MusicSessionClient.sendMessage(JSON.stringify(data));
}

// UI handlers

function onConnectButton(){
    MusicSessionClient.connect(musicSessionServerURL);
}

function onDisconnectButton(){
    MusicSessionClient.disconnect();
}

function onJoinButton(){
    joinField.disabled = true;
    inputField.disabled = false;
    joinButton.disabled = true;
    leaveButton.disabled = false;

    sendMessage("JOIN");
}

function onLeaveButton(){
    joinField.disabled = false;
    inputField.disabled = true;
    joinButton.disabled = false;
    leaveButton.disabled = true;

    sendMessage("LEAVE");
}

function onInputFieldChanged() {
    sendMessage("UPDATE");
}

// Websocket Handlers

function onConnect(event, message) {
 connectButton.disabled = true;
 disConnectButton.disabled = false;

 joinField.disabled = false;
 inputField.disabled = true;
 joinButton.disabled = false;
 leaveButton.disabled = true;
}

function onDisconnect(event, message) {
    connectButton.disabled = false;
    disConnectButton.disabled = true;

    joinField.disabled = true;
    inputField.disabled = true;
    joinButton.disabled = true;
    leaveButton.disabled = true;
}

function onMessage(event, message) {
    var data = JSON.parse(message);

    inputField.value = data.sharedText;
}