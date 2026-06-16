#!/bin/bash
# Author: Nickita Zekov - nz84

sudo apt update # Updates installed packages

# Installs git, composer, php, and rabbitmq-server
apt install -y git composer php rabbitmq-server 

cd "$HOME" # Navigates to the home directory

# Clones the repository into home directory if it doesn't exist
if [ ! -d "$HOME/IT490-2026" ]; then 
    git clone https://github.com/MattToegel/IT490-2026
fi

cd "$HOME/IT490-2026" # Navigates to the repository directory

# Installs dependencies based on composer.json file
composer install 