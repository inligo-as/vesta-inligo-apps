#!/bin/bash

[ $# -lt 3 ] && {
    echo "Usage: ./restore_backup_remote.sh <server> <user> <date> [time]" && exit
}
    
SERVER=$1
USER=$2
DATE=$3
TIME=$4
BUCKET="inligo-server-backups"

if [ -z $TIME ] 
then 
    FILEPATH="$BUCKET/$SERVER/$USER/$USER.$DATE"
else
    FILEPATH="$BUCKET/$SERVER/$USER/$USER.$DATE\_$TIME"
fi

LISTING=$(aws s3 ls $FILEPATH)

[[ -z $LISTING ]] && {
    echo "Backup was not found: $FILEPATH"
    exit 1
}

LISTING=$(echo $LISTING | head -n 1 | python3 -c "a=input();print(a.split(' ')[3])")

FILEPATH="s3://$BUCKET/$SERVER/$USER/$LISTING"

echo $FILEPATH