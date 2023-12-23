from flask_sqlalchemy import SQLAlchemy
from sqlalchemy.orm import DeclarativeBase

class Base(DeclarativeBase):
  pass

db = SQLAlchemy(model_class=Base)

class Location(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String, unique=True, nullable=False)
    description = db.Column(db.String, nullable=False)
    address = db.Column(db.String, unique=True, nullable=False)
    imageURL = db.Column(db.String, unique=False, nullable=True)

    def __repr__(self):
        return self.name
    
    def toJSON(self):
        return {
            'address': self.address,
            'description': self.description, 
            'id': self.id,
            'imageURL': self.imageURL,
            'name': self.name, 
        }

class Organizer(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String, unique=True, nullable=False)
    description = db.Column(db.String, nullable=False)
    contactPerson = db.Column(db.String, nullable=False)
    imageURL = db.Column(db.String, unique=False, nullable=True)

    def __repr__(self):
        return self.name
    
    def toJSON(self):
        return {
            'contactPerson': self.contactPerson,
            'description': self.description, 
            'id': self.id,
            'imageURL': self.imageURL,
            'name': self.name, 
        }

class Event(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String, unique=True, nullable=False)
    description = db.Column(db.String, nullable=False)
    date = db.Column(db.DateTime, nullable=False)
    ticketPrice =  db.Column(db.Integer, nullable=False)
    seats = db.Column(db.Integer, nullable=False)
    remainingSeats = db.Column(db.Integer, nullable=False)
    location_id = db.Column(db.Integer, db.ForeignKey('location.id'), nullable=False)
    organizer_id = db.Column(db.Integer, db.ForeignKey('organizer.id'), nullable=False)
    imageURL = db.Column(db.String, unique=False, nullable=True)

    location = db.relationship("Location")
    organizer = db.relationship("Organizer")

    def __repr__(self):
        return self.name
    
    def toJSON(self):
        return {
            'dateTime': {
                'date': f"{self.date.day}-{self.date.month}-{self.date.year}",
                'day': self.date.day,
                'full': f"{self.date.day}-{self.date.month}-{self.date.year} {self.date.hour}:{self.date.minute}",
                'hour': self.date.hour,
                'minute': self.date.minute,
                'month': self.date.month,
                'year': self.date.year,
                'time': f"{self.date.hour}:{self.date.minute}",
            }, 
            'description': self.description, 
            'id': self.id, 
            'imageURL': self.imageURL,
            'location': self.location.toJSON(), 
            'name': self.name, 
            'organizer': self.organizer.toJSON(),
            'remainingSeats': self.remainingSeats, 
            'seats': self.seats, 
            'ticketPrice': self.ticketPrice, 
        }

class Booking(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    userID = db.Column(db.Integer, nullable=False)
    eventID = db.Column(db.Integer, db.ForeignKey('event.id'), nullable=False)
    userEmail = db.Column(db.String, nullable=False)
    ticketAmount = db.Column(db.Integer, nullable=False)

    event = db.relationship("Event")

    db.UniqueConstraint('userID', 'eventID')

    def __repr__(self):
        return f"{self.userID} - {self.event.name}: {self.ticketAmount}"
    
    def toJSON(self):
        return {
            'event': self.event.toJSON(),
            'id': self.id ,
            'ticketAmount': self.ticketAmount ,
            'userEmail': self.userEmail ,
            'userID': self.userID ,
        }