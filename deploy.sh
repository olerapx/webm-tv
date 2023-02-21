#!/usr/bin/env bash

TAG=$1

git checkout -- .

git fetch --tags --force
git checkout tags/$TAG

php8.2 artisan migrate --force
php8.2 artisan scout:sync

npm install
npm run build

php8.2 artisan view:cache
php8.2 artisan route:cache
php8.2 artisan config:cache
