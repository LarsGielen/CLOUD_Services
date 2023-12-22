
from flask import request
from models import Location, Event,db
    
def getLocations():
    locations = Location.query.all()

    return {'locations': locationListToJson(locations)}

def getLocationByID(id):
    location = Location.query.get_or_404(id)
    return {'location': location.toJSON()}

def addLocation():
    location = Location(name=request.json['name'], description=request.json['description'], address=request.json['address'])
    db.session.add(location)
    db.session.commit()
    return {'location': location.toJSON()}

def editLocation(id):
    location = Location.query.get_or_404(id)
    location.name = request.json['name']
    location.description = request.json['description']
    location.address = request.json['address']
    db.session.commit()
    return {'location': location.toJSON()}

def deleteLocation(id):
    location = Location.query.get_or_404(id)
    db.session.delete(location)
    db.session.commit()
    return {'status': 'succes'}

def getPopularLocations():
    # Get the locations sorted from most common in the event table to lowest
    locationTuples = db.session.query(Location, db.func.count(Event.location_id).label('count')) \
    .join(Event, Location.id == Event.location_id, isouter=True) \
    .group_by(Event.location_id) \
    .order_by(db.func.count(Event.location_id).desc()) \
    .all()
    locations = []
    for locationTuple in locationTuples:
        locations.append(locationTuple[0])
    return {'locations': locationListToJson(locations)}

def getPopularWithCountLocations(count):
    # Get the first 'count' locations sorted from most common in the event table to lowest
    locationTuples = db.session.query(Location, db.func.count(Event.location_id).label('count')) \
    .join(Event, Location.id == Event.location_id, isouter=True) \
    .group_by(Event.location_id) \
    .order_by(db.func.count(Event.location_id).desc()) \
    .limit(count) \
    .all()
    locations = []
    for locationTuple in locationTuples:
        locations.append(locationTuple[0])
    return {'locations': locationListToJson(locations)}

def getSortedAlphabeticalLocations():
    # get locations sorted by name
    locations = db.session.query(Location) \
    .order_by(Location.name) \
    .all()
    return {'locations': locationListToJson(locations)}

def getSortedAlphabeticalWithCountLocations(count):
    # get locations sorted by name
    locations = db.session.query(Location) \
    .order_by(Location.name) \
    .limit(count) \
    .all()
    return {'locations': locationListToJson(locations)}

def getSortedAlphabeticalWithLetterLocations(letter):
    # get locations sorted by name and start with letter 'letter'
    locations = db.session.query(Location) \
    .filter(Location.name.ilike(letter + '%')) \
    .order_by(Location.name) \
    .all()
    return {'locations': locationListToJson(locations)}

def getSortedAlphabeticalWithLetterWithCountLocations(letter, count):
    # get the first 'count' locations sorted by name and start with letter 'letter'
    locations = db.session.query(Location) \
    .filter(Location.name.ilike(letter + '%')) \
    .order_by(Location.name) \
    .limit(count) \
    .all()
    return {'locations': locationListToJson(locations)} 

def locationListToJson(list):
    output = []
    for location in list:
        output.append(location.toJSON())
    return output