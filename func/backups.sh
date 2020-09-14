#!/bin/bash

function backup_get_s3_path() {
    [ $# -lt 3 ] && {
        echo "Usage: ./restore_backup_remote.sh <server> <user> <date> [time]" && exit
    }
        
    SERVER=$1
    USER=$2
    DATE=$3
    TIME=$4
    BUCKET="inligo-server-backups"

    FILEPATH="$BUCKET/$SERVER/$USER/$USER.$DATE"
    
    if [ ! -z $TIME ] 
    then 
        FILEPATH+="_$TIME"
    fi

    LISTING=$(aws s3 ls $FILEPATH)

    [[ -z $LISTING ]] && {
        echo "Backup was not found: aws s3 ls $FILEPATH"
        return
    }

    LISTING=$(echo $LISTING | head -n 1 | python3 -c "a=input();print(a.split(' ')[3])")

    FILEPATH="s3://$BUCKET/$SERVER/$USER/$LISTING"

    echo $FILEPATH
}