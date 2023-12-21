#!/usr/bin/env bash

APPNAME="webm_tv"
HOSTS=("2ch.hk")

RULES_DESC=$(ufw status numbered | grep "$APPNAME" \
  | awk -F"[][]" '{print $2}' | tr --delete [:blank:] | sort -rn)
for NUM in $RULES_DESC; do
  yes | ufw delete $NUM
done

for HOST in $HOSTS; do
    HOST_IPS=$(dig +short "$HOST")
    HOST_IPS=($(echo "$HOST_IPS" | tr ' ' '\n'))

    for IP in "${HOST_IPS[@]}"; do
         ufw allow out to $IP app "$APPNAME"
    done
done
