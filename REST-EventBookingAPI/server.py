"""
    Sources:
        https://flask-sqlalchemy.palletsprojects.com/en/3.1.x/

"""
from flask import Flask

from models import db
from routes import *
from createDatabase import createDatabase

server = Flask(__name__)
server.config["SQLALCHEMY_DATABASE_URI"] = "sqlite:///data.db"

db.init_app(server)

createDatabase(server, db)

# Location routes
server.add_url_rule('/api/locations', view_func=getLocations)
server.add_url_rule('/api/locations/<id>', view_func=getLocationByID)
server.add_url_rule('/api/locations', view_func=addLocation, methods=['POST'])
server.add_url_rule('/api/locations/<id>', view_func=editLocation, methods=['PUT'])
server.add_url_rule('/api/locations/<id>', view_func=deleteLocation, methods=['DELETE'])

# Organizer routes
server.add_url_rule('/api/organizers', view_func=getOrganizer)
server.add_url_rule('/api/organizers/<id>', view_func=getOrganizerByID)
server.add_url_rule('/api/organizers', view_func=addOrganizer, methods=['POST'])
server.add_url_rule('/api/organizers/<id>', view_func=editOrganizer, methods=['PUT'])
server.add_url_rule('/api/organizers/<id>', view_func=deleteOrganizer, methods=['DELETE'])

# Evenement routes
server.add_url_rule('/api/evenements', view_func=getEvenement)
server.add_url_rule('/api/evenements/<id>', view_func=getEvenementByID)
server.add_url_rule('/api/evenements', view_func=addEvenement, methods=['POST'])
server.add_url_rule('/api/evenements/<id>', view_func=editEvenement, methods=['PUT'])
server.add_url_rule('/api/evenements/<id>', view_func=deleteEvenement, methods=['DELETE'])

server.run(port=5000)