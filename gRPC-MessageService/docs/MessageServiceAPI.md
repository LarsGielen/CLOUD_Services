# Introduction

This project implements a gRPC-based message service using C#. The server facilitates the exchange of messages between clients, managing user streams and message persistence. The client communicates with the server using the gRPC protocol to send and receive messages. 

# Message Service Implementation

The MessageServiceImplementation class serves as the core component of the server. It extends MessageService.MessageServiceBase and provides implementations for two gRPC service methods: sendMessageToUser and openMessageStream.

sendMessageToUser
This method handles the sending of messages from one user to another. It ensures database persistence and checks for open streams before delivering the message.

openMessageStream
This method is called when a client opens a stream to listen for incoming messages. It manages the client's connection, sends stored messages, and handles client disconnection.

# Group Message Service Implementation

TODO

# Client Implementation

The client implementation, initializes a gRPC channel, sets up the client, and opens a stream for incoming messages. Users can interact with the server by sending messages to each other.

# Usage

Run the server project to start the gRPC server:

```console 
dotnet run
```

Start the client project:

```console
dotnet run
```

Enter the user ID and username when prompted by the client. Users can send messages by providing the receiver's ID and message content. All send messages will be stored. If you restart your client and enter with the same id you will receive al previously send messages.

Exit: Press 'e' to exit the client. The server handles disconnection appropriately.

# Notes

Update the server address in the client code ("http://localhost:5177") to match your server configuration. You can find change the server port in the launchSettings.json file inside the Properties folder.