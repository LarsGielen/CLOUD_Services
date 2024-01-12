var deviceNameInput = null;
var setDeviceBtn = null;
var noteOutput = null;
var pitchOutput = null;
var connectedDeviceOutput = null;

var client = null;

window.onload = function() {
    deviceNameInput = document.querySelector("#deviceNameInput");
    setDeviceBtn = document.querySelector("#setDeviceBtn");
    noteOutput = document.querySelector("#noteOutput");
    pitchOutput = document.querySelector("#pitchOutput");
    connectedDeviceOutput = document.querySelector("#connectedDeviceOutput");

    setDeviceBtn.onclick = onSetDeviceBtn;
}

function connectToBroker(brokerURL) {
    client = new Paho.MQTT.Client(brokerURL, 'webClient');

    client.onConnectionLost = onConnectionLost;
    client.onMessageArrived = onMessageArrived;

    client.connect({
        onSuccess: onConnect,
        onFailure: onFailure,
        userName: 'Admin',
        password: 'Admin123',
    });
}

function onSetDeviceBtn() {
    client.unsubscribe('#');
    connectedDeviceOutput.innerHTML = "";
    noteOutput.innerHTML = "";
    pitchOutput.innerHTML = "";

    if (client == null)
        return;

    if (!deviceNameInput.value || deviceNameInput.value.trim() === "")
        return;
    
    client.subscribe(deviceNameInput.value);
    connectedDeviceOutput.innerHTML = "Subscribed to: " + deviceNameInput.value;
}

function onMessageArrived(message) {
    let dataArray = message.payloadString.split("|");

    let noteValue = dataArray[0];
    let pitchValue = dataArray[1];

    noteOutput.innerHTML = noteValue;
    pitchOutput.innerHTML = pitchValue;

    if (pitchValue < 0)
        pitchOutput.innerHTML = "Higher";
    else if (pitchValue > 0)
        pitchOutput.innerHTML = "Lower";
    else
        pitchOutput.innerHTML = "";

    var color = [0, 0, 0];
    if (Math.abs(pitchValue) <= 10){
        colorGoodPitch = [0, 255, 0];
        colorBadPitch = [255, 165, 0];

        color = colorGoodPitch.map((start, i) => {
            const end = colorBadPitch[i];
            const delta = end - start;
            return Math.round(start + delta * Math.min(Math.max(Math.abs(pitchValue) / 10, 0), 1));
        });
    }
    else {
        var colorGoodPitch = [255, 165, 0];
        var colorBadPitch = [255, 0, 0];

        color = colorGoodPitch.map((start, i) => {
            const end = colorBadPitch[i];
            const delta = end - start;
            return Math.round(start + delta * Math.min(Math.max(Math.abs(pitchValue - 10) / 40, 0), 1));
        });
    }

    noteOutput.style.color = `rgb(${color.join(", ")})`;
}

function onConnect() {
    console.log('Connected to MQTT broker');
}

function onFailure(err) {
    console.log('Connection failed: ' + err.errorMessage);
    client = null;
}

function onConnectionLost(responseObject) {
    if (responseObject.errorCode !== 0) {
        console.log('Connection lost: ' + responseObject.errorMessage);
        client = null;
    }
}