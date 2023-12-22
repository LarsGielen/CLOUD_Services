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

    def __repr__(self):
        return self.name
    
    def toJSON(self):
        return {
            'id': self.id,
            'name': self.name, 
            'description': self.description, 
            'address': self.address
        }

class Organizer(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String, unique=True, nullable=False)
    description = db.Column(db.String, nullable=False)
    contactPerson = db.Column(db.String, nullable=False)

    def __repr__(self):
        return self.name
    
    def toJSON(self):
        return {
            'id': self.id,
            'name': self.name, 
            'description': self.description, 
            'contactPerson': self.contactPerson
        }

class Evenement(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String, unique=True, nullable=False)
    description = db.Column(db.String, nullable=False)
    date = db.Column(db.DateTime, nullable=False)
    ticketPrice =  db.Column(db.Integer, nullable=False)
    seats = db.Column(db.Integer, nullable=False)
    remainingSeats = db.Column(db.Integer, nullable=False)
    location_id = db.Column(db.Integer, db.ForeignKey('location.id'), nullable=False)
    organizer_id = db.Column(db.Integer, db.ForeignKey('organizer.id'), nullable=False)

    location = db.relationship("Location")
    organizer = db.relationship("Organizer")

    def __repr__(self):
        return self.name
    
    def toJSON(self):
        return {
            'id': self.id, 
            'name': self.name, 
            'description': self.description, 
            'date': self.date, 
            'ticketPrice': self.ticketPrice, 
            'seats': self.seats, 
            'remainingSeats': self.remainingSeats, 
            'location': self.location.toJSON(), 
            'organizer': self.organizer.toJSON()
        }

class Booking(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    userID = db.Column(db.Integer, nullable=False)
    evenementID = db.Column(db.Integer, db.ForeignKey('evenement.id'), nullable=False)
    userEmail = db.Column(db.String, nullable=False)
    bookedSeats = db.Column(db.Integer, nullable=False)

    evenement = db.relationship("Evenement")
    
    def __repr__(self):
        return f"{self.userID} - {self.evenement.name}: {self.bookedSeats}"
    
    def toJSON(self):
        return {
            'id': self.id ,
            'userID': self.userID ,
            'evenementID': self.evenementID ,
            'userEmail': self.userEmail ,
            'bookedSeats': self.bookedSeats ,
            'evenement': self.evenement.toJSON()
        }