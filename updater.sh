#!/bin/sh
# updater.sh

cd /home/pi

git clone git://github.com/batterx/trax.git

sudo cp /home/pi/trax/update.sh /home/pi
sudo chmod 777 /home/pi/update.sh

sudo sh /home/pi/update.sh