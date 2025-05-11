from sense_emu import SenseHat
import time
import requests
import random

s = SenseHat()
s.clear()

xml_server = 'http://iotserver.com/recordtemp.php'
temperature = 50.0
temp_rising = True
error_mode = False
overshoot_count = 0
first_spike_set = False

print("Press middle button to turn ON or OFF error mode.")

while True:
    #Error mode
    for event in s.stick.get_events():
        if event.action == "pressed" and event.direction == "middle":
            error_mode = not error_mode
            first_spike_set = False
            if error_mode == True:
                print("Error Mode ON!")
            else:
                print("Error Mode OFF!")
    #simulate temperature changes
    if temp_rising:
        temperature += random.uniform(0.5, 0.8)
        if temperature > 53:
            if overshoot_count < 3:
                overshoot_count += 1
            else:
                temp_rising = False
                overshoot_count = 0
    else:
        temperature -= random.uniform(0.5, 0.8)
        if temperature < 47:
            if overshoot_count < 3:
                overshoot_count += 1
            else:
                temp_rising = True
                overshoot_count = 0

    temperature = round(temperature, 1)
    temp = temperature
    
    #set spike in 2 ways
    if error_mode == True:
        if first_spike_set == False:
            spike = random.uniform(20,30)
            #To marker: you can change the probability higher for more spikes, 0.5 should be good
            if random.random() < 0.2:
                spike = -spike
            temp += spike
            temp = round(temp,1)
            print("First spike set: " ,spike)
            first_spike_set = True
        elif random.random() < 0.2:
            spike = random.uniform(20,30)
            #To marker: you can change the probability higher for more spikes, 0.5 should be good
            if random.random() < 0.2:
                spike = -spike
            temp += spike
            temp = round(temp,1)
            print("Random spike set: " ,spike)                    
                
    timestamp = time.strftime("%d-%m-%Y %H:%M:%S")
    print("Temp:", temp, "Time:", timestamp)
    
    #send data to server
    payload = {
        "temp": temp,
        "time": timestamp
        }
    r = requests.get(xml_server, params=payload)    
    if "1" not in r.text:
        print("logger acknowledgement failed")

    time.sleep(1)


