#!/bin/sh
# update.sh

sudo cp /home/pi/trax/html /var/www -r
sudo chmod 777 /var/www -R

sudo rm /home/pi/BatterX
sudo cp /home/pi/trax/BatterX /home/pi
sudo chmod 777 /home/pi/BatterX

sudo rm /home/pi/MqttStream
sudo cp /home/pi/trax/MqttStream /home/pi
sudo chmod 777 /home/pi/MqttStream

sudo rm /home/pi/CloudStream
sudo cp /home/pi/trax/CloudStream /home/pi
sudo chmod 777 /home/pi/CloudStream

sudo cp /home/pi/trax/launcher.sh /home/pi
sudo chmod 777 /home/pi/launcher.sh

sudo cp /home/pi/trax/updater.sh /home/pi
sudo chmod 777 /home/pi/updater.sh



sudo sed -i 's/.*www-data .*/www-data ALL=(ALL:ALL) NOPASSWD:ALL/' /etc/sudoers

sudo apt-get install rng-tools -y



sudo kill $(pgrep "BatterX")
sudo kill $(pgrep "MqttStream")
sudo kill $(pgrep "CloudStream")



sudo rm /home/pi/trax -r

sudo rm /home/pi/update.sh
