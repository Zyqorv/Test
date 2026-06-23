#!/bin/bash
#setup Script for API VM -mj464
#installs python3, venv, FastAPI, and uvicorn

set -e #exit on error

echo "Setting hostname"
sudo hostnamectl set-hostname api-vm

echo "Updating package lists"
sudo apt update

echo "Installing Python3-venv"
sudo apt install -y python3-venv

echo "Creating Python virtual environment"
cd ~/api-vm
python3 -m venv venv
source venv/bin/activate

echo "Installing FastAPI and uvicorn"
pip install fastapi uvicorn

echo "Creating main.py with FastAPI example"
cat <<EOL > main.py
from fastapi import FastAPI

app = FastAPI()

@app.get("/")
def read_root():
    return {"status": "API VM is running!"}

@app.get("/health")
def health_check():
    return {"status": "healthy"}    

EOL

echo "API VM setup complete"
echo "uvicorn main:app --host 0.0.0.0 --port 8000 --reload"
