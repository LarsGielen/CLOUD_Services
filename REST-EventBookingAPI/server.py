"""
    Sources:
        https://flask-sqlalchemy.palletsprojects.com/en/3.1.x/

"""
from flask import Flask
from flask_cors import CORS

from models import db
from routes_location import *
from routes_organizer import *
from routes_event import *
from routes_booking import *
from createDatabase import createDatabase

server = Flask(__name__)
server.config["SQLALCHEMY_DATABASE_URI"] = "sqlite:///data.db"
CORS(server) 

db.init_app(server)

createDatabase(server, db)

# Location routes
server.add_url_rule('/api/locations/sorted/popular', view_func=getPopularLocations) # Get locations sorted on popularity
server.add_url_rule('/api/locations/sorted/popular/<count>', view_func=getPopularWithCountLocations) # Get the 'count' most pupular locations sorted on popularity

server.add_url_rule('/api/locations/sorted/alphabetical', view_func=getSortedAlphabeticalLocations) # Get locations sorted on name
server.add_url_rule('/api/locations/sorted/alphabetical/<count>', view_func=getSortedAlphabeticalWithCountLocations) # Get 'count' locations sorted on name
server.add_url_rule('/api/locations/sorted/alphabetical/letter/<letter>', view_func=getSortedAlphabeticalWithLetterLocations) # Get the locations that start with the letter 'letter'
server.add_url_rule('/api/locations/sorted/alphabetical/letter/<letter>/<count>', view_func=getSortedAlphabeticalWithLetterWithCountLocations) # Get 'count' locations that start with the letter 'letter'

server.add_url_rule('/api/locations/events/<id>', view_func=getLocationEventsByID) # Get events organized at the given location

server.add_url_rule('/api/locations', view_func=getLocations) # Get all locations
server.add_url_rule('/api/locations/<id>', view_func=getLocationByID) # Get a location with id
server.add_url_rule('/api/locations', view_func=addLocation, methods=['POST']) # Create a new location
server.add_url_rule('/api/locations/<id>', view_func=editLocation, methods=['PUT']) # Edit a location
server.add_url_rule('/api/locations/<id>', view_func=deleteLocation, methods=['DELETE']) # Delete a location

# Organizer routes
server.add_url_rule('/api/organizers/sorted/popular', view_func=getPopularOrganizers) # Get organizers sorted on popularity
server.add_url_rule('/api/organizers/sorted/popular/<count>', view_func=getPopularWithCountOrganizers) # Get the 'count' most pupular organizers sorted on popularity

server.add_url_rule('/api/organizers/sorted/alphabetical', view_func=getSortedAlphabeticalOrganizers) # Get organizers sorted on name
server.add_url_rule('/api/organizers/sorted/alphabetical/<count>', view_func=getSortedAlphabeticalWithCountOrganizers) # Get 'count' organizers sorted on name
server.add_url_rule('/api/organizers/sorted/alphabetical/letter/<letter>', view_func=getSortedAlphabeticalWithLetterOrganizers) # Get the organizers that start with the letter 'letter'
server.add_url_rule('/api/organizers/sorted/alphabetical/letter/<letter>/<count>', view_func=getSortedAlphabeticalWithLetterWithCountOrganizers) # Get 'count' organizers that start with the letter 'letter'

server.add_url_rule('/api/organizers/events/<id>', view_func=getOrganizerEventsByID) # Get events organized by the given organizer

server.add_url_rule('/api/organizers', view_func=getOrganizers) # Get all organizers
server.add_url_rule('/api/organizers/<id>', view_func=getOrganizerByID) # Get an organizer with id
server.add_url_rule('/api/organizers', view_func=addOrganizer, methods=['POST']) # Create a new organizer
server.add_url_rule('/api/organizers/<id>', view_func=editOrganizer, methods=['PUT']) # Edit an organizer
server.add_url_rule('/api/organizers/<id>', view_func=deleteOrganizer, methods=['DELETE']) # Delete an organizer

# Event routes
server.add_url_rule('/api/events/sorted/popular', view_func=getPopularEvents) # Get events sorted on popularity
server.add_url_rule('/api/events/sorted/popular/<count>', view_func=getPopularWithCountEvents) # Get the 'count' most pupular events sorted on popularity

server.add_url_rule('/api/events/sorted/alphabetical', view_func=getSortedAlphabeticalEvents) # Get events sorted on name
server.add_url_rule('/api/events/sorted/alphabetical/<count>', view_func=getSortedAlphabeticalWithCountEvents) # Get 'count' events sorted on name
server.add_url_rule('/api/events/sorted/alphabetical/letter/<letter>', view_func=getSortedAlphabeticalWithLetterEvents) # Get the events that start with the letter 'letter'
server.add_url_rule('/api/events/sorted/alphabetical/letter/<letter>/<count>', view_func=getSortedAlphabeticalWithLetterWithCountEvents) # Get 'count' events that start with the letter 'letter'

server.add_url_rule('/api/events/sorted/price', view_func=getSortedTicketPriceEvents) # Get events sorted by ticket price (low to high)
server.add_url_rule('/api/events/sorted/price/<count>', view_func=getSortedTicketPriceWithCountEvents) # Get 'count' events sorted by ticket price (low to high)

server.add_url_rule('/api/events/sorted/date', view_func=getSortedDateEvents) # Get events sorted by date (early first)
server.add_url_rule('/api/events/sorted/date/<count>', view_func=getSortedDateWithCountEvents) # Get 'count' events sorted by date (early first)

server.add_url_rule('/api/events', view_func=getEvents) # Get all events
server.add_url_rule('/api/events/<id>', view_func=getEventByID) # Get an event with id
server.add_url_rule('/api/events', view_func=addEvent, methods=['POST']) # Create a new event
server.add_url_rule('/api/events/<id>', view_func=editEvent, methods=['PUT']) # Edit an event
server.add_url_rule('/api/events/<id>', view_func=deleteEvent, methods=['DELETE']) # Delete an event

# Booking routes
server.add_url_rule('/api/booking/<id>', view_func=getBookedEventsByUserID) # Get bookings from user with userID
server.add_url_rule('/api/booking', view_func=addBooking, methods=['POST']) # Create a new booking
server.add_url_rule('/api/booking/<id>', view_func=deleteBooking, methods=['DELETE']) # Delete a booking with ID

# start server
server.run(host='0.0.0.0', port=80)