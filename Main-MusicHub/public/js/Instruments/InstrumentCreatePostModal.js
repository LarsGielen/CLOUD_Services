var createPostButton = null;
var typeInput = null;

function createPostModalInit(instrumentTypes) {
    createPostButton = document.querySelector("#createPostButton");
    createButton = document.querySelector("#createButton");

    typeInput = document.querySelector("#type");

    createPostButton.onclick = openCreatePostModal;
    addInstrumentTypes(instrumentTypes);
}

function openCreatePostModal() {
    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'createPostModal' }));
}

function addInstrumentTypes(instrumentTypes) {
    instrumentTypes.forEach(type => {
        const newOption = document.createElement('option');
        newOption.textContent = type.name;
        newOption.value = type.name.toUpperCase();
        typeInput.appendChild(newOption);
    });
}