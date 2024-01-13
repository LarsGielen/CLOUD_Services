# Introduction
MQTT (Message Queuing Telemetry Transport) is a lightweight messaging protocol designed for devices with limited resources. It is well-suited for scenarios where low bandwidth, high latency, or an unreliable network is a concern. In this cloud service, HiveMQ serves as the MQTT broker, facilitating communication between devices.

# JavaScript Client (Subscriber)
The JavaScript client in the browser acts as a subscriber. It allows users to set the device name, subscribe to a specific topic, and receive messages. The client utilizes the Paho MQTT library for communication.

## Running the JavaScript Client
Include the Paho MQTT library in your HTML file:

```html
<script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.js" type="text/javascript"></script>
```

Include the JavaScript file:

```html
<script src="src/index.js"></script>
```

Run the client in a browser by running this command:

```console
python -m http.server 5050
```

# Python Client (Publisher)
The Python client acts as a publisher with a simple UI using Tkinter. It simulates a tuner device, sending MQTT messages with note and pitch offset information.

## Running the Python Client
Install the required Python libraries:

```console
pip install paho-mqtt
pip install tk
```
Execute the Python script:

```console
python App.py
```

# Notes
Ensure that your environment supports WebSocket connections sinds the browser client can only connect to the broker with webockets. 

The broker URL and other settings can be changed in the BrokerConfig.py file.