from flask import request
from models import Organizer, Evenement,db

def getOrganizer():
    organizers = Organizer.query.all()

    return organizerListToJson(organizers)

def getOrganizerByID(id):
    organizer = Organizer.query.get_or_404(id)
    return {'organizer': {'id': organizer.id,'name': organizer.name, 'description': organizer.description, 'contactPerson': organizer.contactPerson}}

def addOrganizer():
    organizer = Organizer(name=request.json['name'], description=request.json['description'], contactPerson=request.json['contactPerson'])
    db.session.add(organizer)
    db.session.commit()
    return {'organizer': {'id': organizer.id,'name': organizer.name, 'description': organizer.description, 'contactPerson': organizer.contactPerson}}

def editOrganizer(id):
    organizer = Organizer.query.get_or_404(id)
    organizer.name = request.json['name']
    organizer.description = request.json['description']
    organizer.contactPerson = request.json['contactPerson']
    db.session.commit()
    return {'organizer': {'id': organizer.id,'name': organizer.name, 'description': organizer.description, 'contactPerson': organizer.contactPerson}}

def deleteOrganizer(id):
    organizer = Organizer.query.get_or_404(id)
    db.session.delete(organizer)
    db.session.commit()
    return {'status': 'succes'}

def getPopularOrganizers():
    # Get the organizers sorted from most common in the event table to lowest
    organizerTuples = db.session.query(Organizer, db.func.count(Evenement.location_id).label('count')) \
    .join(Evenement, Organizer.id == Evenement.location_id, isouter=True) \
    .group_by(Evenement.location_id) \
    .order_by(db.func.count(Evenement.location_id).desc()) \
    .all()

    organizers = []
    for organizerTuple in organizerTuples:
        organizers.append(organizerTuple[0])

    return organizerListToJson(organizers)

def getPopularWithCountOrganizers(count):
    # Get the first 'count' organizers sorted from most common in the event table to lowest
    organizerTuples = db.session.query(Organizer, db.func.count(Evenement.location_id).label('count')) \
    .join(Evenement, Organizer.id == Evenement.location_id, isouter=True) \
    .group_by(Evenement.location_id) \
    .order_by(db.func.count(Evenement.location_id).desc()) \
    .limit(count) \
    .all()
    
    organizers = []
    for organizerTuple in organizerTuples:
        organizers.append(organizerTuple[0])

    return organizerListToJson(organizers)

def getSortedAlphabeticalOrganizers():
    # get organizers sorted by name
    organizers = db.session.query(Organizer) \
    .order_by(Organizer.name) \
    .all()
    
    return organizerListToJson(organizers)

def getSortedAlphabeticalWithCountOrganizers(count):
    # get organizers sorted by name
    organizers = db.session.query(Organizer) \
    .order_by(Organizer.name) \
    .limit(count) \
    .all()
    
    return organizerListToJson(organizers)

def getSortedAlphabeticalWithLetterOrganizers(letter):
    # get organizers sorted by name and start with letter 'letter'
    organizers = db.session.query(Organizer) \
    .filter(Organizer.name.ilike(letter + '%')) \
    .order_by(Organizer.name) \
    .all()
    return organizerListToJson(organizers)

def getSortedAlphabeticalWithLetterWithCountOrganizers(letter, count):
    # get the first 'count' organizers sorted by name and start with letter 'letter'
    organizers = db.session.query(Organizer) \
    .filter(Organizer.name.ilike(letter + '%')) \
    .order_by(Organizer.name) \
    .limit(count) \
    .all()
    return organizerListToJson(organizers)

def organizerListToJson(list):
    output = []
    for organizer in list:
        organizerData = {'id': organizer.id,'name': organizer.name, 'description': organizer.description, 'contactPerson': organizer.contactPerson}
        output.append(organizerData)
    return {'organizers': output}