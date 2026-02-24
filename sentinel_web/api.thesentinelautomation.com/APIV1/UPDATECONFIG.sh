#!/bin/sh

updateconfig() {
  find . -name "$1.$2" | while read line; do
    dest=${line:0:$(((${#line}) - 1 - (${#2})))}
    cp "$line" $dest
  done
}

if [ "$1" != "dev" ] && [ "$1" != "prod" ] 
then
  echo Invalid input. Supply either dev or prod
  echo e.g. ./updateconfig.sh dev
  exit;
fi

echo Updating configuration.ini from configuration.ini."$1"
updateconfig configuration.ini $1

echo Done

