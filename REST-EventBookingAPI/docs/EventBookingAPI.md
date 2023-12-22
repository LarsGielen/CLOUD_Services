# Introduction

This project is a REST API developed using Flask, a web framework for Python. The API serves as a backend for managing locations, organizers, events and bookings. The application uses SQLAlchemy for database operations and follows REST principles for designing endpoints.

# Running the API server

Before running the API, make sure to install the required dependencies. The following command installs the necessary packages:

```console
pip install Flask Flask-SQLAlchemy Faker
```

To start the server, open a Python console and run the following command:

```console
from server import *
```

# Using the API

The API consists of 4 main endpoints: \
[/api/locations](#locations) \
[/api/organizers](#organizers) \
[/api/events](#events) \
[/api/booking](#booking) 

## Locations

### Endpoints

Get all locations sorted by id:
```console
GET /api/locations
```

Get a single location with its id:
```console
GET /api/locations/<id>
```

Create a new location:
```console
POST /api/locations
```

Edit a location:
```console
PUT /api/locations/<id>
```

Delete a location:
```console
DELETE /api/locations/<id>
```

Get all locations sorted by popularity:
```console
GET /api/locations/sorted/popular
```

Get the `count` most pupular locations sorted by popularity:
```console
GET /api/locations/sorted/popular/<count>
``` 

Get all locations sorted by name:
```console
GET /api/locations/sorted/alphabetical`
```

Get the first `count` locations sorted by name:
```console
GET /api/locations/sorted/alphabetical/<count>`
```

Get all locations that start with the letter `letter`:
```console
GET /api/locations/sorted/alphabetical/letter/<letter>`
```

Get the first `count` locations that start with the letter `letter`:
```console
GET /api/locations/sorted/alphabetical/letter/<letter>/<count>`
```

Get all events organized at the given location:
```console
GET /api/locations/events/<id>
```
### Example response

Single location:
```json
{
  "location": {
    "address": "location address",
    "description": "location description",
    "id": 1,
    "name": "location name"
  }
}
```

List of locations:
```json
{
  "locations": [
    {
        "address": "location address 1",
        "description": "location description 1",
        "id": 1,
        "name": "location name 1"
    },
    {
        "address": "location address 2",
        "description": "location description 2",
        "id": 2,
        "name": "location name 2"
    }
}
```

## Organizers

### Endpoints

Get all organizers sorted by id:
```console
GET /api/organizers 
```

Get an organizer with id:
```console
GET /api/organizers/<id> 
```

Create a new organizer:
```console
POST /api/organizers 
```

Edit an organizer:
```console
PUT /api/organizers/<id> 
```

Delete an organizer:
```console
DELETE /api/organizers/<id> 
```

Get all organizers sorted by popularity:
```console
GET /api/organizers/sorted/popular 
```

Get the `count` most pupular organizers sorted by popularity:
```console
GET /api/organizers/sorted/popular/<count> 
```

Get all organizers sorted by name:
```console
GET /api/organizers/sorted/alphabetical 
```

Get `count` organizers sorted by name:
```console
GET /api/organizers/sorted/alphabetical/<count> 
```

Get all the organizers that start with the letter `letter`:
```console
GET /api/organizers/sorted/alphabetical/letter/<letter>
```

Get the first `count` organizers that start with the letter `letter`:
```console
GET /api/organizers/sorted/alphabetical/letter/<letter>/<count>
```

Get all events organized by the given organizer:
```console
GET /api/organizers/events/<id> 
```

### Example response

Single organizer:
```json
{
  "organizer": {
      "contactPerson": "contact person",
      "description": "description",
      "id": 1,
      "name": "name"
    }
}
```

List of organizers:
```json
{
  "organizers": [
    {
      "contactPerson": "contact person 1",
      "description": "description 1",
      "id": 1,
      "name": "name 1"
    },
    {
      "contactPerson": "contact person 2",
      "description": "description 2",
      "id": 2,
      "name": "name 2"
    }
}
```

## Events

### Endpoints

Get all events sorted by id:
```console
GET /api/events 
```

Get an event with id:
```console
GET /api/events/<id> 
```

Create a new event:
```console
POST /api/events 
```

Edit an event:
```console
PUT /api/events/<id> 
```

Delete an event:
```console
DELETE /api/events/<id> 
```

Get all events sorted by popularity:
```console
GET /api/events/sorted/popular 
```

Get the `count` most pupular events sorted by popularity:
```console
GET /api/events/sorted/popular/<count> 
```

Get all events sorted by name:
```console
GET /api/events/sorted/alphabetical 
```

Get the first `count` events sorted by name:
```console
GET /api/events/sorted/alphabetical/<count> 
```

Get all the events that start with the letter `letter`:
```console
GET /api/events/sorted/alphabetical/letter/<letter> 
```

Get the first `count` events that start with the letter `letter`:
```console
GET /api/events/sorted/alphabetical/letter/<letter>/<count> 
```

Get all events sorted by ticket price (low to high):
```console
GET /api/events/sorted/price 
```

Get the first `count` events sorted by ticket price (low to high):
```console
GET /api/events/sorted/price/<count> 
```

Get all events sorted by date (early first):
```console
GET /api/events/sorted/date 
```

Get the first `count` events sorted by date (early first):
```console
GET /api/events/sorted/date/<count> 
```

### Example response

Single event:
```json
{
    "event": {
        "date": "event date",
        "description": "event description",
        "id": 1,
        "location": {
            "address": "event location address",
            "description": "event location description",
            "id": 1,
            "name": "event location name"
            },
        "name": "event name",
        "organizer": {
            "contactPerson": "event organizer contactPerson",
            "description": "event organizer description",
            "id": 1,
            "name": "event organizer name"
        },
        "remainingSeats": 10,
        "seats": 100,
        "ticketPrice": 50
    }
}
```

List of events:
```json
{
    "events": [
        {
            "date": "event date 1",
            "description": "event description 1",
            "id": 1,
            "location": {
                "address": "event location address 1",
                "description": "event location description 1",
                "id": 1,
                "name": "event location name 1"
            },
            "name": "event name 1",
            "organizer": {
                "contactPerson": "event organizer contactPerson 1",
                "description": "event organizer description 1",
                "id": 1,
                "name": "event organizer name 1"
            },
            "remainingSeats": 10,
            "seats": 100,
            "ticketPrice": 50
            },
            {
            "date": "event date 2",
            "description": "event description 2",
            "id": 2,
            "location": {
                "address": "event location address 2",
                "description": "event location description 2",
                "id": 2,
                "name": "event location name 2"
            },
            "name": "event name 2",
            "organizer": {
                "contactPerson": "event organizer contactPerson 2",
                "description": "event organizer description 2",
                "id": 2,
                "name": "event organizer name 2"
            },
            "remainingSeats": 10,
            "seats": 100,
            "ticketPrice": 50
        }
    ]
}
```

## Booking

### Endpoints

Get all bookings from user with userID `id`:
```console
GET /api/booking/<id> 
```

Create a new booking:
```console
POST /api/booking 
```

Delete a booking with ID:
```console
DELETE /api/booking/<id> 
```

### Example reponse

Single booking:
```json
{
    "booking": {
        "bookedSeats": 5,
        "event":  {
            "date": "booking event date",
            "description": "booking event description",
            "id": 1,
            "location": {
                "address": "booking event location address",
                "description": "booking event location description",
                "id": 1,
                "name": "booking event location name"
            },
            "name": "booking event name",
            "organizer": {
                "contactPerson": "booking event organizer contactPerson",
                "description": "booking event organizer description",
                "id": 1,
                "name": "booking event organizer name"
            },
            "remainingSeats": 10,
            "seats": 100,
            "ticketPrice": 50
        },
        "id": 1,
        "userEmail": "example@example.com",
        "userID": 1
    }
}
```

List of bookings:
```json
{
    "bookings": [
        {
            "bookedSeats": 5,
            "event":  {
                "date": "booking event date 1",
                "description": "booking event description 1",
                "id": 1,
                "location": {
                    "address": "booking event location address 1",
                    "description": "booking event location description 1",
                    "id": 1,
                    "name": "booking event location name 1"
                },
                "name": "booking event name 1",
                "organizer": {
                    "contactPerson": "booking event organizer contactPerson 1",
                    "description": "booking event organizer description 1",
                    "id": 1,
                    "name": "booking event organizer name 1"
                },
                "remainingSeats": 10,
                "seats": 100,
                "ticketPrice": 50
            },
            "id": 1,
            "userEmail": "example@example.com",
            "userID": 1
        },
        {
            "bookedSeats": 5,
            "event":  {
                "date": "booking event date 2",
                "description": "booking event description 2",
                "id": 2,
                "location": {
                    "address": "booking event location address 2",
                    "description": "booking event location description 2",
                    "id": 2,
                    "name": "booking event location name 2"
                },
                "name": "booking event name 2",
                "organizer": {
                    "contactPerson": "booking event organizer contactPerson 2",
                    "description": "booking event organizer description 2",
                    "id": 2,
                    "name": "booking event organizer name 2"
                },
                "remainingSeats": 10,
                "seats": 100,
                "ticketPrice": 50
            },
            "id": 2,
            "userEmail": "example@example.com",
            "userID": 1
        }
    ]
}
```