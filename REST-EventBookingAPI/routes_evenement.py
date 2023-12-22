from flask import request
from models import Evenement, Organizer, Location, db
from datetime import datetime

def getEvenement():
    evenements = Evenement.query.all()
    return evenementListToJson(evenements)

def getEvenementByID(id):
    evenement = Evenement.query.get_or_404(id)
    locationData = {'location': {'id': evenement.location.id,'name': evenement.location.name, 'description': evenement.location.description, 'address': evenement.location.address}}
    organizerData = {'organizer': {'id': evenement.organizer.id,'name': evenement.organizer.name, 'description': evenement.organizer.description, 'contactPerson': evenement.organizer.contactPerson}}
    evenenementData = {'id': evenement.id, 'name': evenement.name, 'description': evenement.description, 'date': evenement.date, 'ticketPrice': evenement.ticketPrice, 'seats': evenement.seats, 'remainingSeats': evenement.remainingSeats, 'location': locationData, 'organizer': organizerData} 
    return evenenementData

def addEvenement():
    location = Location.query.get_or_404(request.json['locationID'])
    organizer = Organizer.query.get_or_404(request.json['organizerID'])
    date = datetime.strptime(request.json['date'], "%Y-%m-%d %H:%M")
    evenement = Evenement(name=request.json['name'], description=request.json['description'], date=date, ticketPrice=request.json['ticketPrice'], seats=request.json['seats'], remainingSeats=request.json['remainingSeats'], location=location, organizer=organizer)

    db.session.add(evenement)
    db.session.commit()

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
    evenement.date = datetime.strptime(request.json['date'], "%Y-%m-%d %H:%M")
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

def getPopularEvenements():
    # Get the evenements sorted from most least seats remaining to most
    evenements = db.session.query(Evenement) \
    .order_by(Evenement.remainingSeats) \
    .all()

    return evenementListToJson(evenements)

def getPopularWithCountEvements(count):
    # Get the first 'count' enements sorted from most least seats remaining to most
    evenements= db.session.query(Evenement) \
    .order_by(Evenement.remainingSeats) \
    .limit(count) \
    .all()

    return evenementListToJson(evenements)

def getSortedAlphabeticalEvenements():
    # get evenements sorted by name
    evenements = db.session.query(Evenement) \
    .order_by(Evenement.name) \
    .all()
    
    return evenementListToJson(evenements)

def getSortedAlphabeticalWithCountEvenements(count):
    # get evenements sorted by name
    evenements = db.session.query(Evenement) \
    .order_by(Evenement.name) \
    .limit(count) \
    .all()
    
    return evenementListToJson(evenements)

def getSortedAlphabeticalWithLetterEvenements(letter):
    # get evenements sorted by name and start with letter 'letter'
    evenements = db.session.query(Evenement) \
    .filter(Evenement.name.ilike(letter + '%')) \
    .order_by(Evenement.name) \
    .all()
    return evenementListToJson(evenements)

def getSortedAlphabeticalWithLetterWithCountEvenements(letter, count):
    # get the first 'count' evenements sorted by name and start with letter 'letter'
    evenements = db.session.query(Evenement) \
    .filter(Evenement.name.ilike(letter + '%')) \
    .order_by(Evenement.name) \
    .limit(count) \
    .all()
    return evenementListToJson(evenements)

def getSortedTicketPriceEvenements():
    # get evenements sorted by price
    evenements = db.session.query(Evenement) \
    .order_by(Evenement.ticketPrice) \
    .all()
    return evenementListToJson(evenements)

def getSortedTicketPriceWithCountEvenements(count):
    # get first 'count' evenements sorted by price
    evenements = db.session.query(Evenement) \
    .order_by(Evenement.ticketPrice) \
    .limit(count) \
    .all()
    return evenementListToJson(evenements)

def getSortedDateEvenements():
    # get evenements sorted by price
    evenements = db.session.query(Evenement) \
    .order_by(Evenement.date) \
    .all()
    return evenementListToJson(evenements)

def getSortedDateWithCountEvenements(count):
    # get first 'count' evenements sorted by price
    evenements = db.session.query(Evenement) \
    .order_by(Evenement.date) \
    .limit(count) \
    .all()
    return evenementListToJson(evenements)

def getLocationEvenementsByID(id):
    evenements = db.session.query(Evenement) \
    .filter(Evenement.location_id == id) \
    .all()
    return evenementListToJson(evenements)

def getOrganizerEvenementsByID(id):
    evenements = db.session.query(Evenement) \
    .filter(Evenement.organizer_id == id) \
    .all()
    return evenementListToJson(evenements)

def evenementListToJson(list):
    output = []
    for evenement in list:
        locationData = {'id': evenement.location.id,'name': evenement.location.name, 'description': evenement.location.description, 'address': evenement.location.address}
        organizerData = {'id': evenement.organizer.id,'name': evenement.organizer.name, 'description': evenement.organizer.description, 'contactPerson': evenement.organizer.contactPerson}
        evenenementData = {'id': evenement.id, 'name': evenement.name, 'description': evenement.description, 'date': evenement.date, 'ticketPrice': evenement.ticketPrice, 'seats': evenement.seats, 'remainingSeats': evenement.remainingSeats, 'location': locationData, 'organizer': organizerData} 
        output.append(evenenementData)
    return {'evenements': output}