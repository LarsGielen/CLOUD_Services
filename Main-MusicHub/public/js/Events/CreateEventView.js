var locationID = null;
var organizerID = null;

var eventAPIUrl = null;

function initCreateEventView(_eventAPIUrl) {
    eventAPIUrl = _eventAPIUrl;

    locationID = document.querySelector("#locationID");
    organizerID = document.querySelector("#organizerID");

    addLocations();
    addOrganizers();
}

function addLocations() {
    fetch(eventAPIUrl + "/api/locations")
    .then(function (response) {
        return response.json();
    })
    .then(function (data) {
        data.locations.forEach(location => {
            const newOption = document.createElement('option');
            newOption.textContent = location.name;
            newOption.value = location.id;
            locationID.appendChild(newOption);
        });
    })
    .catch(function (error) {
        console.log('Error: ' + error);
    });
}

function addOrganizers() {
    fetch(eventAPIUrl + "/api/organizers")
    .then(function (response) {
        return response.json();
    })
    .then(function (data) {
        data.organizers.forEach(organizer => {
            const newOption = document.createElement('option');
            newOption.textContent = organizer.name;
            newOption.value = organizer.id;
            organizerID.appendChild(newOption);
        });
    })
    .catch(function (error) {
        console.log('Error: ' + error);
    });
}