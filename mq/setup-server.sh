#!/bin/bash


#install needed programs
sudo apt install git
curl -s https://install.zerotier.com | sudo bash
sudo apt install composer php
sudo apt install rabbitmq-server -y
#join zerotier network
sudo zerotier-cli join cf719fd540fc6df4
#copy the git repo
git clone https://github.com/MattToegel/IT490-2026.git
#change directory to the cloned repo
cd IT490-2026
#install composer in the directory that contains the composer json file
composer install
#display the zerotier info for this device to allow user to verify the device connecting
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

#create test user with test password this is because by default the guest user is the only one
#and guest only works for local host
sudo rabbitmqctl add_user test test
#set permissions for test to allow it to read write and executre
sudo rabbitmqctl set_permissions -p / test ".*" ".*" ".*"
#run the server php file
php RabbitMQServerSample.php

