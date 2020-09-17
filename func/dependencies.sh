#!/bin/bash

function install_aws_cli() {
    local access_key=$1
    local secret_key=$2

    if [[ "$access_key" && "$secret_key" ]]; then
        do_configure=true
    fi

    aws --version > /dev/null && aws_installed=true

    if [[ "$aws_installed" != true ]]; then
        mkdir -p ~/downloads
        cd ~/downloads
        curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip"
        ./aws/install
        aws --version
    else
        echo "AWS cli already installed."
    fi

    if [[ "$do_configure" == true ]]; then
        aws configure set aws_access_key_id $access_key
        aws configure set aws_secret_access_key $secret_key
        
        echo "Configured AWS keys."
    fi

    return $?
}

function install_wp_cli() {
    wp --info > /dev/null && {
        ret=$?
        echo "WP cli already installed."
        return $ret
    }

    mkdir -p ~/downloads
    cd ~/downloads
    curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
    php wp-cli.phar --info || return $?
    chmod +x wp-cli.phar
    mv wp-cli.phar /usr/local/bin/wp
    wp --info
    return $?
}

function install_remote_backup() {
    server_name=$($VESTA/bin/v-inligo-server-name get)
    backup_cron=$($VESTA/bin/v-list-cron-jobs admin | grep v-backup-users)

    echo "Installing remote backup cron job..."

    if [[ ! $server_name ]]; then
        echo "Error: Server name must be set before running this script."
        exit 1
    fi

    if [[ ! $backup_cron ]]; then
        $VESTA/bin/v-add-cron-job admin 20 5 "*" "*" "*" "sudo /usr/local/vesta/bin/v-backup-users && sudo /usr/local/vesta/bin/v-inligo-upload-backups $server_name admin >/dev/null 2>&1"
        echo "Added new cron job"
    else
        cron_id=$(echo $backup_cron | awk '{print $1;}')
        $VESTA/bin/v-change-cron-job admin $cron_id 20 5 "*" "*" "*" "sudo /usr/local/vesta/bin/v-backup-users && sudo /usr/local/vesta/bin/v-inligo-upload-backups $server_name admin >/dev/null 2>&1"
        echo "Changed cron job $cron_id"
    fi

    echo "Successfully installed remote backup cron job!"
}

function install_web_templates() {
    mkdir -p /home/admin/templates
    
    cp $VESTA/plugins/vesta-inligo-apps/templates/security.nginx.txt /home/admin/templates/security.nginx.txt
    cp $VESTA/plugins/vesta-inligo-apps/templates/web/nginx/* $VESTA/data/templates/web/nginx

    echo "Successfully installed vesta web templates!"
}