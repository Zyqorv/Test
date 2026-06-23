#!/bin/bash
#setup script for APP VM -nz84

sudo apt update # updates preinstalled packages

sudo hostnamectl set-hostname app-vm # sets hostname

# installs necessary packages for app vm
sudo apt install -y git composer php nodejs npm ssh mysql-client

curl -s https://install.zerotier.com/ | sudo bash # installs zerotier

sudo zerotier-cli join cf719fd540fc6df4 # joins group zerotier network