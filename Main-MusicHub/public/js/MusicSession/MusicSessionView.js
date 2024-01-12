// joinView
var joinView = null;
var joinButton = null;
var joinRoomInput = null;

// sessionView
var sessionView = null;
var leaveButton = null;
var roomName = null;
var notationInput = null;
var notationCanvas = null;
var notationErrors = null;

function initWebsocket(serverURL) {
    // Get HTML elements
    joinView = document.querySelector("#joinView")
    joinButton = document.querySelector("#joinBtn");
    joinRoomInput = document.querySelector("#roomNameInput");
    
    sessionView = document.querySelector("#sessionView");
    leaveButton = document.querySelector("#leaveBtn");
    roomName = document.querySelector("#roomName");
    notationInput = document.querySelector("#notationInput");
    notationCanvas = document.querySelector("#notationCanvas");
    notationErrors = document.querySelector("#notationErrors");

    // Set HTML element events
    joinButton.onclick = onJoinButton;
    leaveButton.onclick = onLeaveButton;
    notationInput.addEventListener('input', onNotationInputFieldChanged);

    // Set websocket events
    MusicSessionClient.onConnect = onConnect;
    MusicSessionClient.onDisconnect = onDisconnect;
    MusicSessionClient.onMessage = onMessage;
    MusicSessionClient.onError = null

    // set UI views
    joinView.style.display  = "block";
    sessionView.style.display  = "none";

    // Set abcj render view
    new ABCJS.Editor("notationInput", { 
        canvas_id: "notationCanvas",
        generate_warnings: true,
        warnings_id:"notationErrors",
        abcjsParams: {
            responsive: "resize"
        }
    });

    MusicSessionClient.connect(serverURL);
}

// UI handlers
function onJoinButton(){
    var data = {
        roomName: joinRoomInput.value,
        sharedText: "",
        status: "JOIN"
    }
    roomName.innerHTML = "Room name: " + joinRoomInput.value;
    MusicSessionClient.sendMessage(JSON.stringify(data));
}

function onLeaveButton(){
    joinView.style.display = "block"
    sessionView.style.display  = "none";

    var data = {
        roomName: "",
        sharedText: "",
        status: "LEAVE"
    }

    MusicSessionClient.sendMessage(JSON.stringify(data));
}

function onNotationInputFieldChanged() {
    var data = {
        roomName: "",
        sharedText: notationInput.value,
        status: "UPDATE"
    }

    MusicSessionClient.sendMessage(JSON.stringify(data));
}

// Websocket Handlers
function onConnect(event, message) {
    console.log(message);
}

function onDisconnect(event, message) {
    console.log(message);
}

function onMessage(event, message) {
    joinView.style.display = "none"
    sessionView.style.display  = "block";

    var data = JSON.parse(message);

    notationInput.value = data.sharedText;
    notationInput.classList.add('abc_textarea_dirty');
}
