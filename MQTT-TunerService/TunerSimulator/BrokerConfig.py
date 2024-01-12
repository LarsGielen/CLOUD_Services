import paho.mqtt.client as mqtt;

broker = "c3a83306c2b24c68835c34e6983a57b1.s2.eu.hivemq.cloud"
port = 8883

# setup client
client = mqtt.Client()
client.tls_set(tls_version=mqtt.ssl.PROTOCOL_TLS)
client.username_pw_set("Admin", "Admin123")

def on_connect(client, userdata, flags, rc):
    print('CONNACK received with code %d.' % (rc))

# callbacks
client.on_connect = on_connect

# connect with broker
client.connect(
    host = broker, 
    port = port,
    clean_start = mqtt.MQTT_CLEAN_START_FIRST_ONLY,
    keepalive = 60
)

def publish(topic, message):
    client.publish(topic, message)

def start_loop():
    client.loop_start()

def stop_loop():
    client.loop_stop()