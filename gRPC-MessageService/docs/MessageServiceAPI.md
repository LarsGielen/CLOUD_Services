# Introduction

This project implements a gRPC-based message service using C#. The server facilitates the exchange of messages between clients, managing user streams and message persistence. The client communicates with the server using the gRPC protocol to send and receive messages. 

The server uses the gRPC web middleware from .NET, and handles both normal gRPC clients and web based clients.

# Message Service Implementation

The MessageServiceImplementation class serves as the core component of the server. It extends MessageService.MessageServiceBase and provides implementations for two gRPC service methods: sendMessageToUser and openMessageStream.

sendMessageToUser: \
This method handles the sending of messages from one user to another. It ensures database persistence and checks for open streams before delivering the message.

openMessageStream: \
This method is called when a client opens a stream to listen for incoming messages. It manages the client's connection, sends stored messages, and handles client disconnection.

## Usage

To run the server, make sure to install all dependencies, then run the following command:

```Command
dotnet run
```

# Group Message Service Implementation

TODO

# C# Client Implementation

This C# client implementation initializes a gRPC channel, sets up the client, and opens a stream for incoming messages. Users can interact with the server by sending messages to each other. 

## Usage

Make sure that the server is running before starting the client. To start the client, run the following command:

```console
dotnet run
```

Enter a user ID and username when prompted by the client. Users can send messages by providing the receiver's ID and message content. All send messages will be stored. If you restart your client and enter with the same id you will receive al previously send messages.

Exit: Press 'e' to exit the client. The server handles disconnection appropriately.

# Browser (javascript) Client implementation

This browser client makes use of gRPC web to connect to the server. There is no need to set up a proxy, the server uses the [Grpc.AspNetCore.Web](https://www.nuget.org/packages/Grpc.AspNetCore.Web) package to handle http1.1 connections. Do note that client to server streams are not possible in the browser.

## Usage

install dependencies:

```console 
npm install
```

Generate code from the .proto file: \
Install protoc for javascript [here](https://github.com/protocolbuffers/protobuf-javascript/releases) \
Install the generator for gRPC-Web [here](https://github.com/grpc/grpc-web/releases)

**Make sure that both these files are added to your path variables!**

Run the following command to generate the files:

```command
protoc -I="." protobuf.proto  --js_out=import_style=commonjs:"." --grpc-web_out=import_style=commonjs,mode=grpcwebtext:"."
```

Compile client side code:

```console
npx webpack ./index.js
```

Run client:

```console
python -m http.server 8080
```

# Notes

Update the server address in the client code to match your server configuration. You can find change the server port in the appsettings.json file inside the Properties folder. for normal gRPC clients (Http2), the default is `https://localhost:6061`. For browser based clients (Http1), the default is `https://localhost:6060` 