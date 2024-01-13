var openSaveMusicSheetModalBtn = null;
var notationInput = null;
var notationHiddenInput = null;
var titleInput = null;

var saveSheetMusicForm = null;

function initSaveMusicSheetModal() {
    openSaveMusicSheetModalBtn = document.querySelector("#openSaveMusicSheetModalBtn");
    notationInput = document.querySelector("#notationInput");
    notationHiddenInput = document.querySelector("#notationHiddenInput");
    titleInput = document.querySelector("#titleInput");
    saveSheetMusicForm = document.querySelector("#saveSheetMusicForm");

    openSaveMusicSheetModalBtn.onclick = openSaveMusicSheetModal;
}

function openSaveMusicSheetModal() {
    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'saveMusicSheetModal' }));

    notationHiddenInput.value = notationInput.value;
}