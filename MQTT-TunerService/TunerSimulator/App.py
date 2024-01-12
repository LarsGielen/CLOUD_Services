import tkinter as tk
from BrokerConfig import *

def format_noteSlider_label(value):
    noteSlider.config(label=SCALE_LABELS[int(value)])

def format_pitchSlider_label(value):
    pitchSlider.config(label=value)

def on_send():
    value_noteSlider = noteSlider.get()
    value_pitchSlider = pitchSlider.get()
    value_device_name = device_name.get()
    publish(value_device_name, SCALE_LABELS[int(value_noteSlider)] + "|" + str(value_pitchSlider))

# Create the main window
window = tk.Tk()
window.title("Simple UI")

# Device name input
device_name_label = tk.Label(window, text="Device name:")
device_name_label.pack()

device_name = tk.Entry(window)
device_name.pack()

# Note slider
device_name_label = tk.Label(window, text="Note:")
device_name_label.pack()

SCALE_LABELS = {
    0: "A",
    1: "B",
    2: "C",
    3: "D",
    4: "E",
    5: "F",
    6: "G",
}
noteSlider = tk.Scale(window, label="A", from_=min(SCALE_LABELS), to=max(SCALE_LABELS), orient=tk.HORIZONTAL, showvalue=False, command=format_noteSlider_label)
noteSlider.pack()

# Pitch slider
device_name_label = tk.Label(window, text="Pitch offset:")
device_name_label.pack()

pitchSlider = tk.Scale(window, label="0", from_=-50, to=50 ,orient="horizontal", showvalue=False, command=format_pitchSlider_label)
pitchSlider.set(0)
pitchSlider.pack()

# Send buttonn
button = tk.Button(window, text="Send", command=on_send)
button.pack()

start_loop()

window.mainloop()
