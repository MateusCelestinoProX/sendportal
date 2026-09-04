#!/bin/bash
set -e

echo "⏳ Inicializando SendPortal..."
sleep 2

cd /var/www/sendportal

# Garante permissões de storage e bootstrap/cache
chmod -R 777 storage bootstrap/cache

# Gera APP_KEY se não existir
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:GENERATE_ME" ]; then
    echo "🔑 Gerando nova chave de criptografia do Laravel..."
    php artisan key:generate --force
fi

# Executa migrações do banco de dados
echo "📦 Executando migrações do SendPortal..."
php artisan migrate --force

# Publica assets estáticos apenas se necessário sem sobrescrever views ou traduções
echo "🎨 Publicando assets estáticos..."
php artisan vendor:publish --tag=sendportal-assets --force || true

# Cria link simbólico do storage
php artisan storage:link || true

echo "🚀 Iniciando SendPortal na porta 8080..."
exec /usr/bin/supervisord -n -c /etc/supervisord.conf
