README:
KIT317 Assignment2
Author: Shaowen Zhu

sensor.py
Continuously generates random temperature data simulating a fermentation tank. 
Also includes functions to switch Error Mode on and off, which injects spikes into the data.

recordtemp.php
Receives temperature readings from the sensor and writes them into an XML file.

convertXMLtoJSON.php
Reads the XML file, uses a pre-trained MLP model to predict a label for each temperature value, 
and combines the temperature and prediction into a JSON file.

tempindex.php
Visualizes the temperature data with line chart. 
Temperatures labeled as "spike" are shown in red. 
Only the most recent 60 records are displayed.

trainData.json
Contains raw temperature values collected from the sensor. 
This dataset is used for training the MLP model and does not include labels.

train_findspike.php
Trains the MLP model with manually labeled data from trainData.json. 
Also includes a small test dataset to verify the model after training.

trainedModel_test.php
Allows manual testing of the trained model via a web browser.

mlp_trained_model.dat
The trained MLP model, saved for prediction use in other PHP files.