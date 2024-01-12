var setDeviceField = null;
var setDeviceBtn = null;
var noteOutput = null;
var pitchOutput = null;

var client = null;

const brokerUrl = 'wss://c3a83306c2b24c68835c34e6983a57b1.s2.eu.hivemq.cloud:8884/mqtt';

window.onload = function() {
    setDeviceField = document.querySelector("#setDeviceField");
    setDeviceBtn = document.querySelector("#setDeviceBtn");
    noteOutput = document.querySelector("#noteOutput");
    pitchOutput = document.querySelector("#pitchOutput");

    client = new Paho.MQTT.Client(brokerUrl, 'webClient');

    setDeviceBtn.onclick = onSetDeviceBtn;

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
    if (client == null)
        return;
    client.unsubscribe('#');
    client.subscribe(setDeviceField.value);

    console.log("Subscribed to: ", setDeviceField.value);
}

function onConnect() {
    console.log('Connected to MQTT broker');
}

function onConnectionLost(responseObject) {
    if (responseObject.errorCode !== 0) {
        console.log('Connection lost: ' + responseObject.errorMessage);
    }
}

function onMessageArrived(message) {
    console.log('Message received: ' + message.payloadString);
}

function onFailure(err) {
    console.log('Connection failed: ' + err.errorMessage);
}