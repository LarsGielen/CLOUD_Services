"""
    Sources:
        https://flask-sqlalchemy.palletsprojects.com/en/3.1.x/

"""
from flask import Flask

from models import db
from routes_location import *
from routes_organizer import *
from routes_evenement import *
from routes_booking import *
from createDatabase import createDatabase

server = Flask(__name__)
server.config["SQLALCHEMY_DATABASE_URI"] = "sqlite:///data.db"

db.init_app(server)

createDatabase(server, db)

# Location routes
server.add_url_rule('/api/locations/sorted/popular', view_func=getPopularLocations) # Get locations sorted on popularity
server.add_url_rule('/api/locations/sorted/popular/<count>', view_func=getPopularWithCountLocations) # Get the 'count' most pupular locations sorted on popularity

server.add_url_rule('/api/locations/sorted/alphabetical', view_func=getSortedAlphabeticalLocations) # Get locations sorted on name
server.add_url_rule('/api/locations/sorted/alphabetical/<count>', view_func=getSortedAlphabeticalWithCountLocations) # Get 'count' locations sorted on name
server.add_url_rule('/api/locations/sorted/alphabetical/letter/<letter>', view_func=getSortedAlphabeticalWithLetterLocations) # Get the locations that start with the letter 'letter'
server.add_url_rule('/api/locations/sorted/alphabetical/letter/<letter>/<count>', view_func=getSortedAlphabeticalWithLetterWithCountLocations) # Get 'count' locations that start with the letter 'letter'

server.add_url_rule('/api/locations/evenements/<id>', view_func=getLocationEvenementsByID) # Get evenements organized at the given location

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

server.add_url_rule('/api/organizers/evenements/<id>', view_func=getOrganizerEvenementsByID) # Get evenements organized by the given organizer

server.add_url_rule('/api/organizers', view_func=getOrganizer) # Get all organizers
server.add_url_rule('/api/organizers/<id>', view_func=getOrganizerByID) # Get an organizer with id
server.add_url_rule('/api/organizers', view_func=addOrganizer, methods=['POST']) # Create a new organizer
server.add_url_rule('/api/organizers/<id>', view_func=editOrganizer, methods=['PUT']) # Edit an organizer
server.add_url_rule('/api/organizers/<id>', view_func=deleteOrganizer, methods=['DELETE']) # Delete an organizer

# Evenement routes
server.add_url_rule('/api/evenements/sorted/popular', view_func=getPopularEvenements) # Get evenements sorted on popularity
server.add_url_rule('/api/evenements/sorted/popular/<count>', view_func=getPopularWithCountEvements) # Get the 'count' most pupular evenements sorted on popularity

server.add_url_rule('/api/evenements/sorted/alphabetical', view_func=getSortedAlphabeticalEvenements) # Get evenements sorted on name
server.add_url_rule('/api/evenements/sorted/alphabetical/<count>', view_func=getSortedAlphabeticalWithCountEvenements) # Get 'count' evenements sorted on name
server.add_url_rule('/api/evenements/sorted/alphabetical/letter/<letter>', view_func=getSortedAlphabeticalWithLetterEvenements) # Get the evenements that start with the letter 'letter'
server.add_url_rule('/api/evenements/sorted/alphabetical/letter/<letter>/<count>', view_func=getSortedAlphabeticalWithLetterWithCountEvenements) # Get 'count' evenements that start with the letter 'letter'

server.add_url_rule('/api/evenements/sorted/price', view_func=getSortedTicketPriceEvenements) # Get evenements sorted by ticket price (low to high)
server.add_url_rule('/api/evenements/sorted/price/<count>', view_func=getSortedTicketPriceWithCountEvenements) # Get 'count' evenements sorted by ticket price (low to high)

server.add_url_rule('/api/evenements/sorted/date', view_func=getSortedDateEvenements) # Get evenements sorted by date (early first)
server.add_url_rule('/api/evenements/sorted/date/<count>', view_func=getSortedDateWithCountEvenements) # Get 'count' evenements sorted by date (early first)

server.add_url_rule('/api/evenements', view_func=getEvenement) # Get all evenements
server.add_url_rule('/api/evenements/<id>', view_func=getEvenementByID) # Get an evenement with id
server.add_url_rule('/api/evenements', view_func=addEvenement, methods=['POST']) # Create a new evenement
server.add_url_rule('/api/evenements/<id>', view_func=editEvenement, methods=['PUT']) # Edit an evenement
server.add_url_rule('/api/evenements/<id>', view_func=deleteEvenement, methods=['DELETE']) # Delete an evenement

# Booking routes
server.add_url_rule('/api/booking/<id>', view_func=getBookedEvenementsByUserID) # Get bookings from user with userID
server.add_url_rule('/api/booking', view_func=addBooking, methods=['POST']) # Create a new booking
server.add_url_rule('/api/booking/<id>', view_func=deleteBooking, methods=['DELETE']) # Delete a booking with ID

# start server
server.run(port=5000)