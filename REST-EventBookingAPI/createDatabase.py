from faker import Faker
import random

from models import *

def createDatabase(server, db):
    with server.app_context():
        db.create_all()

        fake = Faker()

        # Create dummy locations
        if db.session.query(Location).count() == 0:
            locations = [Location(name=fake.company(), description=fake.text(), address=fake.address()) for _ in range(5)]
            db.session.add_all(locations)
            db.session.commit()

        # Create dummy event organizers
        if db.session.query(Organizer).count() == 0:
            organizers = [Organizer(name=fake.company(), description=fake.text(), contactPerson=fake.email()) for _ in range(5)]
            db.session.add_all(organizers)
            db.session.commit()

        # Create dummy events
        if db.session.query(Evenement).count() == 0:
            events = []
            for _ in range(10):
                event = Evenement(
                    name=fake.word(),
                    description=fake.text(),
                    date=fake.date_time_between(start_date='now', end_date='+30d'),
                    ticketPrice=random.randint(20, 100),
                    seats=random.randint(50, 200),
                    remainingSeats=random.randint(10, 50),
                    location=random.choice(locations),
                    organizer=random.choice(organizers)
                )
                events.append(event)
            db.session.add_all(events)
            db.session.commit()
