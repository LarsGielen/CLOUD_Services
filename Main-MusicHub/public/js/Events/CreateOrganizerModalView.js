var openCreateNewOrganizerModalBtn = null;
var createNewOrganizerBtn = null;

var organizerNameInput = null;
var OrganizerDiscriptionInput = null;
var OrganizerContactPersonInput = null;
var OrganizerImageUrlInput = null;

var eventAPIUrl = null;

function initCreateOrganizerModal(_eventAPIUrl) {
    eventAPIUrl = _eventAPIUrl;

    openCreateNewOrganizerModalBtn = document.querySelector("#openCreateNewOrganizerModalBtn");
    createNewOrganizerBtn = document.querySelector("#createNewOrganizerBtn");
    
    organizerNameInput = document.querySelector("#organizerNameInput");
    OrganizerDiscriptionInput = document.querySelector("#OrganizerDiscriptionInput");
    OrganizerContactPersonInput = document.querySelector("#OrganizerContactPersonInput");
    OrganizerImageUrlInput = document.querySelector("#OrganizerImageUrlInput");

    openCreateNewOrganizerModalBtn.onclick = openCreateOrganizerModal;
    createNewOrganizerBtn.onclick = onCreateButton;
}

function openCreateOrganizerModal() {
    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'createOrganizerModal' }));
}

function onCreateButton() {
    var data = {
        name: organizerNameInput.value,
        description: OrganizerDiscriptionInput.value,
        contactPerson: OrganizerContactPersonInput.value,
        imageURL: OrganizerImageUrlInput.value,
    };
    
    fetch(eventAPIUrl + "/api/organizers ", {
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