#!/bin/bash
# Author: Nickita Zekov - nz84
# Setup Script for App VM (Milestone 2)

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

run "sudo apt update"

run "sudo hostnamectl set-hostname app-vm-milestone-2"

run "sudo apt install -y git"
run "sudo apt install -y composer" 
run "sudo apt install -y php"
run "sudo apt install -y ssh"
run "sudo apt install -y php-cli"

run "curl -s https://install.zerotier.com/ | sudo bash"
run "sudo zerotier-cli join cf719fd540fc6df4"


