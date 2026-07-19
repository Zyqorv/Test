#!/bin/bash
# Author: Nickita Zekov - nz84
# Setup Script for App VM (MVP Milestone)

set -e

run() {
    local command="$1"

    echo "Running '$command'"

    if eval "$command" > /dev/null 2>&1; then
        echo "'$command' completed successfully"
    else
        echo "'$command' failed to complete"
        return 1
    fi
}

# Updates preinstalled packages
run "sudo apt update"

# Changes hostname
run "sudo hostnamectl set-hostname app-vm-mvp-milestone"

# Installs necessary packages
run "sudo apt install -y git"
run "sudo apt install -y composer" 
run "sudo apt install -y php"
run "sudo apt install -y ssh"
run "sudo apt install -y php-cli"

# Installs zerotier and joins group network if not already installed
if ! command -v zerotier-cli >/dev/null 2>&1; then
    run "curl -s https://install.zerotier.com/ | sudo bash"
    run "sudo zerotier-cli join cf719fd540fc6df4"
else
    echo "ZeroTier is already installed, skipping installation"
fi

run "composer install"

echo "Setup script completed successfully"