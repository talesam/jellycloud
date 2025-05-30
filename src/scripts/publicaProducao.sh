#!/bin/bash

# JellyCloud Production Deploy Script
echo "🚀 Fazendo deploy do JellyCloud em produção..."

ssh -p 2225 ubuntu@cm.deskfacil.com 'cd ~/JellyCloud ; git pull ; src/scripts/build.sh'

echo "✅ Deploy concluído!"
