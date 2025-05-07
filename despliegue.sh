#!/bin/bash

set -e

cd /home/azualet/produccion/

echo "Haciendo pull..."
git pull origin main

echo "Reconstruyendo contenedores..."
docker compose -f docker-compose-produccion.yml build

echo "Levantando en modo detached..."
docker compose -f docker-compose-produccion.yml up -d --force-recreate

echo "Despliegue completado."
