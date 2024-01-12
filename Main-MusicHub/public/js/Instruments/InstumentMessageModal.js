var openMessageModalButton = null;
var sendMessageButton = null;
var sendMessageText = null;
var messageText = null;

var messageServiceURL = null;
var senderUserName = null;
var senderUserID = null;
var receiverUserID = null;

function MessageModalInit(_messageServiceURL, _senderUserName, _senderUserID, _receiverUserID, _receiverUserName) {
    openMessageModalButton = document.querySelector('#openModalButton');
    sendMessageButton = document.querySelector('#sendMessageButton');
    sendMessageText = document.querySelector('#sendMessageText');
    messageText = document.querySelector('#messageText');

    messageServiceURL = _messageServiceURL;
    senderUserName = _senderUserName;
    senderUserID = _senderUserID;
    receiverUserName = _receiverUserName;
    receiverUserID = _receiverUserID;

    openMessageModalButton.onclick = onOpenMessageModalButton;
    
    sendMessageButton.onclick = onSendMessageButton;
}

function onOpenMessageModalButton() {
    sendMessageText.textContent = "Send message to " + receiverUserName;
    messageText.value = "";
    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'messageModal' }));
}

function onSendMessageButton() {
    GrpcMessageClient.sendMessageToUser (
        messageServiceURL,
        senderUserName,
        senderUserID,
        receiverUserID,
        document.querySelector('#messageText').value
    );
}