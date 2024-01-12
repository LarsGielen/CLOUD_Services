var MusicSessionClient = {};

var socket = null;

MusicSessionClient.onConnect = null;
MusicSessionClient.onDisconnect = null;
MusicSessionClient.onMessage = null;
MusicSessionClient.onError = null;

MusicSessionClient.connect = function (serverURL) {
    if (socket != null) 
        socket.close();

    socket = new WebSocket(serverURL);

    socket.addEventListener('open', event => {
        if (this.onConnect != null)
            this.onConnect(event, "Connection opened");
    });

    socket.addEventListener('close', event => {
        if (this.onDisconnect != null)
            this.onDisconnect(event, "connection closed");

        socket = null;
    });

    socket.addEventListener('message', event => {
        if (this.onMessage != null)
            this.onMessage(event, event.data);
    });

    socket.addEventListener('error', event => {
        if (this.onError != null)
            this.onError(event, "connection error");
    });
}

MusicSessionClient.disconnect = function() {
    socket.close();
}

MusicSessionClient.sendMessage = function(message) {
    if (socket == null) {
        if (this.onError != null)
            this.onError(null, "No connection to a websocket, call the connect function to connect to a server");
        
        return;
    }
        
    socket.send(message);
}