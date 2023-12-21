from flask import request
from models import *

# Location functions
def getLocations():
    locations = Location.query.all()
    output = []
    for location in locations:
      locationData = {'id': location.id,'name': location.name, 'description': location.description, 'address': location.address}
      output.append(locationData)
    return {'locations': output}

def getLocationByID(id):
    location = Location.query.get_or_404(id)
    return {'location': {'id': location.id,'name': location.name, 'description': location.description, 'address': location.address}}

def addLocation():
    location = Location(name=request.json['name'], description=request.json['description'], address=request.json['addres'])
    db.session.add(location)
    db.session.commit()
    return {'location': {'id': location.id,'name': location.name, 'description': location.description, 'address': location.address}}

def editLocation(id):
    location = Location.query.get_or_404(id)
    location.name = request.json['name']
    location.description = request.json['description']
    location.address = request.json['address']
    db.session.commit()
    return {'location': {'id': location.id,'name': location.name, 'description': location.description, 'address': location.address}}

def deleteLocation(id):
    location = Location.query.get_or_404(id)
    db.session.delete(location)
    db.session.commit()
    return {'status': 'succes'}

# Organizer functions
def getOrganizer():
    organizers = Organizer.query.all()
    output = []
    for organizer in organizers:
      organizerData = {'id': organizer.id,'name': organizer.name, 'description': organizer.description, 'contactPerson': organizer.contactPerson}
      output.append(organizerData)
    return {'organizers': output}

def getOrganizerByID(id):
    organizer = Organizer.query.get_or_404(id)
    return {'organizer': {'id': organizer.id,'name': organizer.name, 'description': organizer.description, 'contactPerson': organizer.contactPerson}}

def addOrganizer():
    organizer = Organizer(name=request.json['name'], description=request.json['description'], address=request.json['addres'])
    db.session.add(organizer)
    db.session.commit()
    return {'organizer': {'id': organizer.id,'name': organizer.name, 'description': organizer.description, 'contactPerson': organizer.contactPerson}}

def editOrganizer(id):
    organizer = Organizer.query.get_or_404(id)
    organizer.id = request.json['id']
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

# Event functions
def getEvenement():
    evenements = Evenement.query.all()
    output = []
    for evenement in evenements:
      locationData = {'location': {'id': evenement.location.id,'name': evenement.location.name, 'description': evenement.location.description, 'address': evenement.location.address}}
      organizerData = {'organizer': {'id': evenement.organizer.id,'name': evenement.organizer.name, 'description': evenement.organizer.description, 'contactPerson': evenement.organizer.contactPerson}}
      evenenementData = {'id': evenement.id, 'name': evenement.name, 'description': evenement.description, 'date': evenement.date, 'ticketPrice': evenement.ticketPrice, 'seats': evenement.seats, 'remainingSeats': evenement.remainingSeats, 'location': locationData, 'organizer': organizerData} 
      output.append(evenenementData)
    return {'evenements': output}

def getEvenementByID(id):
    evenement = Evenement.query.get_or_404(id)
    locationData = {'location': {'id': evenement.location.id,'name': evenement.location.name, 'description': evenement.location.description, 'address': evenement.location.address}}
    organizerData = {'organizer': {'id': evenement.organizer.id,'name': evenement.organizer.name, 'description': evenement.organizer.description, 'contactPerson': evenement.organizer.contactPerson}}
    evenenementData = {'id': evenement.id, 'name': evenement.name, 'description': evenement.description, 'date': evenement.date, 'ticketPrice': evenement.ticketPrice, 'seats': evenement.seats, 'remainingSeats': evenement.remainingSeats, 'location': locationData, 'organizer': organizerData} 
    return evenenementData

def addEvenement():
    location = Location.query.get_or_404(request.json['locationID'])
    organizer = Organizer.query.get_or_404(request.json['organizeID'])
    evenement = Evenement(id=request.json['id'], name=request.json['name'], description=request.json['description'], date=request.json['date'], ticketPrice=request.json['ticketPrice'], seats=request.json['seats'], remainingSeats=request.json['remainingSeats'], location=location, organizer=organizer)

    locationData = {'location': {'id': evenement.location.id,'name': evenement.location.name, 'description': evenement.location.description, 'address': evenement.location.address}}
    organizerData = {'organizer': {'id': evenement.organizer.id,'name': evenement.organizer.name, 'description': evenement.organizer.description, 'contactPerson': evenement.organizer.contactPerson}}
    evenenementData = {'id': evenement.id, 'name': evenement.name, 'description': evenement.description, 'date': evenement.date, 'ticketPrice': evenement.ticketPrice, 'seats': evenement.seats, 'remainingSeats': evenement.remainingSeats, 'location': locationData, 'organizer': organizerData} 
    return evenenementData


def editEvenement(id):
    evenement = Evenement.query.get_or_404(id)

    evenement.location = Location.query.get_or_404(request.json['locationID'])
    evenement.organizer = Organizer.query.get_or_404(request.json['organizerID'])
    evenement.name = request.json['name']
    evenement.description = request.json['description']
    evenement.date = request.json['date']
    evenement.ticketPrice = request.json['ticketPrice']
    evenement.seats = request.json['seats']
    evenement.remainingSeats = request.json['remainingSeats']
    db.session.commit()

    locationData = {'location': {'id': evenement.location.id,'name': evenement.location.name, 'description': evenement.location.description, 'address': evenement.location.address}}
    organizerData = {'organizer': {'id': evenement.organizer.id,'name': evenement.organizer.name, 'description': evenement.organizer.description, 'contactPerson': evenement.organizer.contactPerson}}
    evenenementData = {'id': evenement.id, 'name': evenement.name, 'description': evenement.description, 'date': evenement.date, 'ticketPrice': evenement.ticketPrice, 'seats': evenement.seats, 'remainingSeats': evenement.remainingSeats, 'location': locationData, 'organizer': organizerData} 
    return evenenementData

def deleteEvenement(id):
    evenement = Evenement.query.get_or_404(id)
    db.session.delete(evenement)
    db.session.commit()
    return {'status': 'succes'}