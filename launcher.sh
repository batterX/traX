#!/bin/sh
# launcher.sh

sleep 2

sudo touch /srv/bx/usv.db3
sudo touch /srv/bx/ram/currentD.db3
sudo touch /srv/bx/ram/currentC.db3
sudo chmod 777 /srv/bx/usv.db3
sudo chmod 777 /srv/bx/usv.db3-journal
sudo chmod 777 /srv/bx/ram/currentD.db3
sudo chmod 777 /srv/bx/ram/currentD.db3-journal
sudo chmod 777 /srv/bx/ram/currentC.db3
sudo chmod 777 /srv/bx/ram/currentC.db3-journal

if ! pgrep -x "BatterX" > /dev/null
then
	cd /
	cd home/pi
	sudo ./BatterX
	cd /
fi

if ! pgrep -x "CloudStream" > /dev/null
then
	cd /
	cd home/pi
	sudo ./CloudStream
	cd /
fi

if ! pgrep -x "MqttStream" > /dev/null
then
	cd /
	cd home/pi
	sudo ./MqttStream
	cd /
fi
