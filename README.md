# Webm TV

Parses video files from imageboards, organizing it into a convenient video player.

![Demo](demo.png)

## Features

* Supported websites:
    * https://2ch.hk
* Modern Youtube-like player based on https://plyr.io/
* Video duplication prevention based on hash and filename check
* Full-fledged playlist with thumbnails
* Download and share video URL
* Mobile-friendly UI
* Hotkeys
* Closed boards support (initial stage)

## Hosted At

https://webm-tv.com/

## Inspired By

* https://github.com/sasfmlzr/DvachMovie
* https://github.com/Karasiq/webm-tv

## Planned Features

* Personal view history based duplication prevention
* More websites to come

## Self-host

### Set up host machine

* Install `docker` with `docker compose`.
* Install `make`.
* Install `git`.
* Create a non-root user, add it to `www-data` and `docker` groups.
* Clone the project, set up `.env` file.

### NGINX

* Install certificates into `/etc/ssl`.
* Install `nginx`.
```
server {
    listen 80;
    server_name webm-tv.com;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name webm-tv.com;

    ssl_certificate /etc/ssl/{cert}.crt;
    ssl_certificate_key /etc/ssl/{cert}.key;
    ssl_protocols TLSv1 TLSv1.1 TLSv1.2;

    location / {
        proxy_buffering off;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header Host $host;
        proxy_set_header X-Forwarded-Proto https;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_pass http://localhost:{PORT};
    }
}
```

### Boot up the project
* Switch to the non-root user
* `cd` into project directory
* `git fetch --tags --force && git pull && git checkout tags/{TAG}`
* `make up`

To stop, execute `docker compose down`.
