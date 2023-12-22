from flask import request
from models import Event, Organizer, Location, db
from datetime import datetime

def getEvents():
    events = Event.query.all()
    return {'events': eventListToJson(events)}

def getEventByID(id):
    event = Event.query.get_or_404(id)
    return {'event': event.toJSON()}

def addEvent():
    location = Location.query.get_or_404(request.json['locationID'])
    organizer = Organizer.query.get_or_404(request.json['organizerID'])
    date = datetime.strptime(request.json['date'], "%Y-%m-%d %H:%M")
    event = Event(
        name=request.json['name'], 
        description=request.json['description'], 
        date=date, 
        ticketPrice=request.json['ticketPrice'], 
        seats=request.json['seats'], 
        remainingSeats=request.json['remainingSeats'], 
        location=location, organizer=organizer
    )
    db.session.add(event)
    db.session.commit()
    return {'event': event.toJSON()}

def editEvent(id):
    event = Event.query.get_or_404(id)
    event.location = Location.query.get_or_404(request.json['locationID'])
    event.organizer = Organizer.query.get_or_404(request.json['organizerID'])
    event.name = request.json['name']
    event.description = request.json['description']
    event.date = datetime.strptime(request.json['date'], "%Y-%m-%d %H:%M")
    event.ticketPrice = request.json['ticketPrice']
    event.seats = request.json['seats']
    event.remainingSeats = request.json['remainingSeats']
    db.session.commit()
    return {'event': event.toJSON()}

def deleteEvent(id):
    event = Event.query.get_or_404(id)
    db.session.delete(event)
    db.session.commit()
    return {'status': 'succes'}

def getPopularEvents():
    # Get the events sorted from most least seats remaining to most
    events = db.session.query(Event) \
    .order_by(Event.remainingSeats) \
    .all()
    return {'events': eventListToJson(events)}

def getPopularWithCountEvents(count):
    # Get the first 'count' enements sorted from most least seats remaining to most
    events= db.session.query(Event) \
    .order_by(Event.remainingSeats) \
    .limit(count) \
    .all()
    return {'events': eventListToJson(events)}

def getSortedAlphabeticalEvents():
    # get events sorted by name
    events = db.session.query(Event) \
    .order_by(Event.name) \
    .all()
    return {'events': eventListToJson(events)}

def getSortedAlphabeticalWithCountEvents(count):
    # get events sorted by name
    events = db.session.query(Event) \
    .order_by(Event.name) \
    .limit(count) \
    .all()
    return {'events': eventListToJson(events)}

def getSortedAlphabeticalWithLetterEvents(letter):
    # get events sorted by name and start with letter 'letter'
    events = db.session.query(Event) \
    .filter(Event.name.ilike(letter + '%')) \
    .order_by(Event.name) \
    .all()
    return {'events': eventListToJson(events)}

def getSortedAlphabeticalWithLetterWithCountEvents(letter, count):
    # get the first 'count' events sorted by name and start with letter 'letter'
    events = db.session.query(Event) \
    .filter(Event.name.ilike(letter + '%')) \
    .order_by(Event.name) \
    .limit(count) \
    .all()
    return {'events': eventListToJson(events)}

def getSortedTicketPriceEvents():
    # get events sorted by price
    events = db.session.query(Event) \
    .order_by(Event.ticketPrice) \
    .all()
    return {'events': eventListToJson(events)}

def getSortedTicketPriceWithCountEvents(count):
    # get first 'count' events sorted by price
    events = db.session.query(Event) \
    .order_by(Event.ticketPrice) \
    .limit(count) \
    .all()
    return {'events': eventListToJson(events)}

def getSortedDateEvents():
    # get events sorted by price
    events = db.session.query(Event) \
    .order_by(Event.date) \
    .all()
    return {'events': eventListToJson(events)}

def getSortedDateWithCountEvents(count):
    # get first 'count' events sorted by price
    events = db.session.query(Event) \
    .order_by(Event.date) \
    .limit(count) \
    .all()
    return {'events': eventListToJson(events)}

def getLocationEventsByID(id):
    events = db.session.query(Event) \
    .filter(Event.location_id == id) \
    .all()
    return {'events': eventListToJson(events)}

def getOrganizerEventsByID(id):
    events = db.session.query(Event) \
    .filter(Event.organizer_id == id) \
    .all()
    return {'events': eventListToJson(events)}

def eventListToJson(list):
    output = []
    for event in list:
        output.append(event.toJSON())
    return output