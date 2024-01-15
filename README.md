<div align="center" style="display: flex; align-items: center; justify-content: center;">
  <picture>
    <source media="(prefers-color-scheme: dark" srcset="https://github.com/LarsG-2158052/CLOUD_Services/assets/146258020/285652eb-1553-462b-9168-17724bf44df3" width="100">
    <img src="https://github.com/LarsG-2158052/CLOUD_Services/assets/146258020/dc75c008-1ad5-4cf7-b743-39931e011ea3" width="100">
  </picture>
  <h1>MusicHub</h1>
</div>

# Welcome to MusicHub!
Welcome to MuseHub, a website that allows users to buy and sell musical instruments, organize and attend events, collaborate on sheet music creation, and communicate with other users. This wiki provides an overview of the website's functionalities and how to navigate through them.

MuseHub is built using the Laravel PHP framework, with the authentication system powered by the Breeze package. The website seamlessly integrates six different web services to provide a comprehensive musical experience. These services include GraphQL, REST API, SOAP, gRPC, Websockets, and MQTT.

# Running the Website
This project is completely set up with Docker files. To start the server, simply run the following command:

```console
docker-compose -p musichub up -d
``````

The website is accesable from with the url http://localhost:7070

# Page Overview

## Authentication page
The user can log in to his acount, or create a new acount via this page. This page is powered by the laravel breeze package.

## Home page
The home page shows some recommended and personal items. It shows the most popular events, the music you uploaded and the event that you have booked

## Instruments page (graphql)
The Instrument page shows all Instruments that are on sale. The user can filter the instrulent on different criteria like price, instrument type and more. The user can also create its own sale post. 

## Events page (REST)
The Event page shows all events. The user can sort these events by popularity, name, price and date. If users are logged in they also have the option to look at their booked events. If user want to go to an event they can book tickets, and users can also create a new event, or delete an event that they have created. 

## Sheet Music page (SOAP)
The Sheet Music page shows all uploaded sheet music. This music is searchable by title. Users can look at the music, generate a PDF or senda message to the componist. 

## Messages page (gRPC)
Here users can see and reply to all their messages.

## Music Session (websockets)
The Music Session page allows users to create or join a room and create new sheet music together. when the music is done they can upload the music to the Sheet Music API.

## Tuner page (MQTT)
The Tuner page allows users to conect their tuner to the website, this way they can check if they are playing to many wrong notes.

