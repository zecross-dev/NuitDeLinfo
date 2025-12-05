#!/bin/bash

# Nom de l'image
IMAGE_NAME="nuit"

echo "🔧 Construction de l'image Docker..."
docker build -t $IMAGE_NAME .

echo "🚀 Lancement du conteneur..."
docker run -d -p 8000:80 -v "$(pwd)":/var/www/html $IMAGE_NAME
