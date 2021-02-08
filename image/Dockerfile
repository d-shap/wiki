FROM        debian:jessie
MAINTAINER  Dmitry Shapovalov

ARG         hostuid=962
ARG         hostgid=962

ENV         DEBIAN_FRONTEND=noninteractive \
            RUN_USER=wiki \
            RUN_GROUP=wiki \
            RUN_PORT=8002 \
            APACHE_RUN_USER=$RUN_USER \
            APACHE_RUN_GROUP=$RUN_GROUP \
            DB_NAME=wiki \
            DB_USER_NAME=wiki \
            WIKI_DOWNLOAD_URL="https://releases.wikimedia.org/mediawiki/1.35/mediawiki-1.35.1.tar.gz" \
            WIKI_DOWNLOAD_NAME="mediawiki-1.35.1" \
            WIKI_FOLDER_NAME="mediawiki-1.35.1"

COPY        . /tmp

# Install common packages and configure environment
RUN         echo "deb http://ftp.debian.org/debian buster-backports main" >> /etc/apt/sources.list.d/backports.list && \
            apt-get update && \
            apt-get install --assume-yes \
                apt-utils \
                build-essential \
                cron \
                net-tools \
                procps \
                software-properties-common \
                vim \
                wget && \
            apt-get clean

# Create user and group
RUN         groupadd -g $hostgid $RUN_GROUP && \
            useradd -u $hostuid -g $hostgid -M $RUN_USER

# Configure application folders
RUN         mkdir /wiki && \
            mkdir /wiki/db && \
            mkdir /wiki/data && \
            mkdir /wiki/scripts && \
            mkdir /wiki/logs && \
            mkdir /wiki/backups && \
            chown -R $RUN_USER:$RUN_GROUP /wiki
