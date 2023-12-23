from flask import jsonify, request, abort
from models import Booking, Event, db

def getBookedEventsByUserID(id):
    evenemens = db.session.query(Booking).filter(Booking.userID == id)
    return {'bookings': bookingListToJson(evenemens)}

def addBooking():

    if request.json['ticketAmount'] <= 0:
        return giveBookingError("You can't book less than 1 seat")

    event = Event.query.get_or_404(request.json['eventID'])
    if event.remainingSeats - request.json['ticketAmount'] <= 0:
        return giveBookingError(f"There are not enough seats. {event.remainingSeats} seats left")

    booking = Booking.query.filter_by(userID=request.json['userID'], eventID=request.json['eventID']).first()
    if booking is None:
        booking = Booking(
            userID = request.json['userID'],
            userEmail = request.json['userEmail'],
            ticketAmount = request.json['ticketAmount'],
            event = Event.query.get_or_404(request.json['eventID'])
        )
        db.session.add(booking)
    else: 
        booking.ticketAmount += request.json['ticketAmount']

    db.session.commit()
    return {'booking': booking.toJSON()}

def deleteBooking(id):
    booking = Booking.query.get_or_404(id)
    booking.event.remainingSeats += booking.ticketAmount
    db.session.delete(booking)
    db.session.commit()
    return {'status': 'succes'}

def bookingListToJson(list):
    output = []
    for booking in list:
        output.append(booking.toJSON())
    return output

def giveBookingError(message):
    response = jsonify({
        'error': message,
    })
    response.status_code = 400
    return response