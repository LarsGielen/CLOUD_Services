# Introduction
This project implements a websocket-based service using java. The server transfers abcNotation between clients so that they can work on the same music piece at the same time.

WebSockets are a communication protocol that provides a persistent connection between a client and a server, allowing bidirectional data flow. This enables real-time communication, making it suitable for applications such as chat systems, live updates, and (in this case) collaborative editing.

Spring Boot is a popular Java-based framework that simplifies the development of stand-alone applications. It provides out-of-the-box solutions for various aspects of application development, including dependency management, configuration, and deployment.

# Running the server
To run the server, use the following command: 

```console
mvn spring-boot:run 
```

# Server Components

## MusicSessionApplication.java
The main class that initializes the Spring Boot application.

## MusicSessionData.java
A class representing the data exchanged between clients and the server during WebSocket communication.

## MusicSessionRoom.java
A class representing a WebSocket room where users can join, leave, and share text in real-time.

## User.java
A class representing a user connected to the WebSocket server.

## WebSocketConfig.java
Configuration class for WebSocket handling. Handles CORS and sends requests to the correct websocket/HTTP handler.

## WebSocketHandler.java
Handler for processing WebSocket messages and managing connected users and rooms.

## Changing the port
The port can be changed inside the application.properties file. You can find this dile in the resources folder.

# Client (JavaScript)

## Running the client
To run the client, run the following command:

```console
python -m http.server 5050
```

## Connecting to the WebSocket Server
To connect to the WebSocket server from a client, use the MusicSessionClient JavaScript object:

```javascript
MusicSessionClient.connect("127.0.0.1:8081");
```

## UI and Interaction
The client provides a simple UI for connecting, disconnecting, joining rooms, and updating shared text.

## WebSockets Handlers
The client has handlers for connecting, disconnecting, and receiving messages from the server. These handlers update the UI and handle real-time updates from the server.

## Sending Messages
Clients can send messages to the server using the sendMessage function of the MusicSessionClient object. Messages include information about the room, shared text, and the type of operation (JOIN, LEAVE, UPDATE).
