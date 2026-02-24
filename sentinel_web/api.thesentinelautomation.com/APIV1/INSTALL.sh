#!/bin/bash

echo "Installing dependencies..."
composer dump-autoload -o

echo "Adding apache folders..."

declare -a arr=("download" "upload")

for i in "${arr[@]}"
do

    if [ ! -d "$i" ]; then
      echo "Creating folder $i ..."
      mkdir "$i"
    fi

    
    echo "Setting permission on $i"
    sudo chown apache:apache -R $i
    sudo chmod 755 -R $i

done


exit


