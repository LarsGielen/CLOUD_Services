const messageContainer = document.querySelector('#messages');

var ServerUrl = null;
var UserID = null;
var Username = null;

function init(messageServerUrl, userID, username) {
    ServerUrl = messageServerUrl;
    UserID = userID;
    Username = username;
}

function openStream() {
    GrpcMessageClient.openMessageStream (
        ServerUrl,
        UserID,
        Username,
        (data) => {
            if (data.getStatus() != 1) return;
    
            const newMessageDiv = createMessageElement(
                getDateFromTimestamp(data.getTimestamp()),
                data.getSender().getUsername(),
                data.getSender().getUserid(),
                data.getMessage()
            );
    
            messageContainer.insertBefore(newMessageDiv, messageContainer.firstChild);
        },
    
        ()      => console.log('Stream ended'),
        (error) => console.error('Stream error:', error)
    );
}

function openMessageModal(receiverID, receiverUsername) {
    document.querySelector('#sendMessageText').textContent = "Send message to " + receiverUsername;
    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'messageModal' }));

    const onClick = () => {
        GrpcMessageClient.sendMessageToUser (
            ServerUrl,
            UserID,
            Username,
            receiverID,
            document.querySelector('#messageText').value
        );
        
        const newMessageDiv = createMessageElement(
            new Date(),
            Username,
            UserID,
            document.querySelector('#messageText').value
        );
        
        messageContainer.insertBefore(newMessageDiv, messageContainer.firstChild);
        
        document.querySelector('#messageText').value = "";
        document.querySelector('#sendMessageButton').removeEventListener('click', onClick);
    }
    document.querySelector('#sendMessageButton').addEventListener('click', onClick);
}

function createMessageElement(date, senderName, senderID, message) {

    const newMessageDiv = document.createElement('div');
    newMessageDiv.className = "bg-white overflow-hidden shadow-sm rounded-lg p-4 flex gap-2 items-center";

    // Date
    const dateElement = document.createElement('p');
    dateElement.className = "text-gray-500"
    dateElement.textContent = date.toLocaleString('en-US', {
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: false,
    });
    newMessageDiv.appendChild(dateElement);

    // Sender name
    const senderNameElement = document.createElement('p');
    senderNameElement.textContent = senderName + ":"
    newMessageDiv.appendChild(senderNameElement);

    // Message
    const messageElement = document.createElement('p');
    messageElement.className = 'grow';
    messageElement.textContent = message;
    newMessageDiv.appendChild(messageElement);

    if (Username != senderName) {
        // Button
        const replyButtonElement = document.createElement('button');
        replyButtonElement.textContent = 'Reply';
        replyButtonElement.className = "inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
        replyButtonElement.addEventListener('click', () => { openMessageModal(senderID, senderName) });
        newMessageDiv.appendChild(replyButtonElement);
    }

    return newMessageDiv;
}

function getDateFromTimestamp(timestamp) {
    const seconds = timestamp.getSeconds();
    const nanos = timestamp.getNanos();
    const milliseconds = seconds * 1000 + nanos / 1e6;
    return new Date(milliseconds)
}