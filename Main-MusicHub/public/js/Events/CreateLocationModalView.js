var openCreateNewLocationModalBtn = null;
var createNewLocationBtn = null;

var locationNameInput = null;
var locationDiscriptionInput = null;
var locationAddressInput = null;
var locationImageUrlInput = null;

var eventAPIUrl = null;

function initCreateLocationModal(_eventAPIUrl) {
    eventAPIUrl = _eventAPIUrl;

    createNewLocationBtn = document.querySelector("#createNewLocationBtn");
    openCreateNewLocationModalBtn = document.querySelector("#openCreateNewLocationModalBtn");

    locationNameInput = document.querySelector("#locationNameInput");
    locationDiscriptionInput = document.querySelector("#locationDiscriptionInput");
    locationAddressInput = document.querySelector("#locationAddressInput");
    locationImageUrlInput = document.querySelector("#locationImageUrlInput");

    openCreateNewLocationModalBtn.onclick = openCreateLocationModal;
    createNewLocationBtn.onclick = onCreateButton;
}

function openCreateLocationModal() {
    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'createLocationModal' }));
}

function onCreateButton() {
    var data = {
        name: locationNameInput.value,
        description: locationDiscriptionInput.value,
        address: locationAddressInput.value,
        imageURL: locationImageUrlInput.value,
    };
    
    fetch(eventAPIUrl + "/api/locations ", {
        method: 'POST',
        mode: 'cors',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        location.reload();
    })
    .catch(function(error) {
        console.error('Error:', error);
    });
}