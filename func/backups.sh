#!/bin/bash

function get_backup_path() {
    [ $# -lt 3 ] && {
        echo "Usage: ./restore_backup_remote.sh <server> <user> <date> [time]" && exit
    }
        
    SERVER=$1
    USER=$2
    DATE=$3
    TIME=$4
    BUCKET="inligo-server-backups"

    FILEPATH="$BUCKET/$SERVER/$USER/$USER.$DATE"
    LOCALPATH="/backup/$USER.$DATE"
    
    if [ ! -z $TIME ] 
    then 
        FILEPATH+="_$TIME"
        LOCALPATH+="_$TIME"
    fi

    ls $LOCALPATH* >/dev/null 2>&1 && echo $(ls $LOCALPATH*) && return

    LISTING=$(aws s3 ls $FILEPATH)

    [[ -z $LISTING ]] && return

    LISTING=$(echo $LISTING | head -n 1 | python3 -c "a=input();print(a.split(' ')[3])")

    FILEPATH="s3://$BUCKET/$SERVER/$USER/$LISTING"

    echo $FILEPATH
}