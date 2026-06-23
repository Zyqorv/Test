#!/bin/bash

echo "starting process"
#install necessary components
sudo apt install git
curl -s https://install.zerotier.com | sudo bash
sudo apt install composer php
#clone the repo needed
git clone https://github.com/MattToegel/IT490-2026.git
#change directory to the cloned repo
cd IT490-2026
#install composer in the directory that has the .json file
composer install
#join network
sudo zerotier-cli join cf719fd540fc6df4
#display the info of this device for zero tier so the user can verify the device trying to join the network
sudo zerotier-cli info
#wait 5 seconds to allow time for zerotier to update
sleep 5
#while loop that checks if the device has been authorized on the network
while true; do
	#displays all connected networks then greps for the network ID we are using and checks if the device is
	#authorized on it
	if sudo zerotier-cli listnetworks | grep cf719fd540fc6df4 | grep "OK"; then
		echo "This device is authorized"
		break
	#if it is not it goes into a read to pause the process and give the user time to authorize the device
	fi
		echo -e "this device is not authorized\n"
		read -sp "Press enter once the device is authorized or CTRL + C to abort."
done
#take the ip of the broker host from the user
read -p "Enter the IP of the broker host: " Ip
#replaces the broker host in the .ini file with the one given by the user
sed - i "s/BROKER_HOST=.*/BROKER_HOST=$Ip" testRabbitMQ.ini
#replace the default guest user and password with test user and password
sed -i "s/guest/test/" testRabbitMQ.ini
#run the php file
php RabbitMQClientSample.php
#leave the network
sudo zerotier-cli leave cf719fd540fc6df4

