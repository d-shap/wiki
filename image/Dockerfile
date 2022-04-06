FROM        debian:buster
MAINTAINER  Dmitry Shapovalov

ARG         hostuid=962
ARG         hostgid=962

ENV         DEBIAN_FRONTEND=noninteractive \
            RUN_USER="wiki" \
            RUN_GROUP="wiki" \
            RUN_PORT=8002 \
            APACHE_RUN_USER="wiki" \
            APACHE_RUN_GROUP="wiki" \
            DB_NAME="wiki" \
            DB_USER_NAME="wiki" \
            WIKI_DOWNLOAD_URL="https://releases.wikimedia.org/mediawiki/1.36/mediawiki-1.36.1.tar.gz" \
            WIKI_DOWNLOAD_NAME="mediawiki-1.36.1" \
            WIKI_FOLDER_NAME="mediawiki-1.36.1" \
            EXT_TEMPLATY_STYLES_NAME="TemplateStyles-REL1_37" \
            EXT_TABS_NAME="Tabs-REL1_37"

COPY        . /tmp

# Install common packages and configure environment
RUN         echo "deb http://ftp.debian.org/debian buster-backports main" >> /etc/apt/sources.list.d/backports.list && \
            apt-get update && \
            apt-get upgrade --assume-yes && \
            apt-get install --assume-yes \
                apt-utils \
                build-essential \
                cron \
                curl \
                net-tools \
                procps \
                software-properties-common \
                vim \
                wget && \
            apt-get update && \
            apt-get install --assume-yes \
                git \
                imagemagick \
                inkscape && \
            apt-get clean

# Create user and group
RUN         groupadd -g $hostgid $RUN_GROUP && \
            useradd -u $hostuid -g $hostgid -M $RUN_USER

# Configure application folders
RUN         mkdir /wiki && \
            mkdir /wiki/db && \
            mkdir /wiki/images && \
            mkdir /wiki/scripts && \
            mkdir /wiki/logs && \
            mkdir /wiki/backups && \
            chown -R $RUN_USER:$RUN_GROUP /wiki

# Install PHP
RUN         apt-get update && \
            apt-get install --assume-yes \
                php \
                php-apcu \
                php-bcmath \
                php-cli \
                php-curl \
                php-gd \
                php-intl \
                php-mbstring \
                php-mysql \
                php-xml && \
            apt-get clean && \
            phpenmod mbstring && \
            phpenmod xml

# Install MySQL
RUN         apt-get update && \
            apt-get install --assume-yes \
                default-mysql-client \
                default-mysql-server && \
            apt-get clean && \
            sed -i '\|\[mysqld\]|a ft_min_word_len = 2' /etc/mysql/mariadb.conf.d/50-server.cnf && \
            sed -i 's|user.*|user            = '"$RUN_USER"'|' /etc/mysql/mariadb.conf.d/50-server.cnf && \
            sed -i 's|datadir.*|datadir         = /wiki/db|' /etc/mysql/mariadb.conf.d/50-server.cnf && \
            sed -i 's|key_buffer.*|key_buffer_size         = 16M|' /etc/mysql/mariadb.conf.d/50-server.cnf && \
            sed -i 's|max_allowed_packet.*|max_allowed_packet      = 8M|' /etc/mysql/mariadb.conf.d/50-server.cnf && \
            sed -i 's|myisam-recover.*|myisam-recover-options  = BACKUP|' /etc/mysql/mariadb.conf.d/50-server.cnf && \
            sed -i 's|log_error.*|log_error                = /var/log/mysql/dberror.log|' /etc/mysql/mariadb.conf.d/50-server.cnf && \
            sed -i 's|syslog.*|# syslog|' /etc/mysql/mariadb.conf.d/50-mysqld_safe.cnf && \
            rm -rf /var/lib/mysql && \
            rm -rf /var/log/mysql && \
            ln -s /wiki/logs /var/log/mysql && \
            chown -h $RUN_USER:$RUN_GROUP /var/log/mysql && \
            mkdir -p /var/run/mysqld && \
            chown -R $RUN_USER:$RUN_GROUP /var/run/mysqld

# Install Apache
RUN         apt-get update && \
            apt-get install --assume-yes \
                apache2 \
                libapache2-mod-php && \
            apt-get clean && \
            sed -i 's|:80>|:'"$RUN_PORT"'>|' /etc/apache2/sites-available/000-default.conf && \
            sed -i 's|#ServerName www.example.com|ServerName localhost|' /etc/apache2/sites-available/000-default.conf && \
            sed -i 's|Listen 80|Listen '"$RUN_PORT"'|' /etc/apache2/ports.conf && \
            echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf && \
            a2enconf servername && \
            a2enmod cgi expires headers rewrite && \
            rm -rf /var/log/apache2 && \
            ln -s /wiki/logs /var/log/apache2 && \
            chown -h $RUN_USER:$RUN_GROUP /var/log/apache2 && \
            mkdir -p /var/lock/apache2 && \
            chown -R $RUN_USER:$RUN_GROUP /var/lock/apache2 && \
            mkdir -p /var/run/apache2 && \
            chown -R $RUN_USER:$RUN_GROUP /var/run/apache2

# Configure app
RUN         cd /tmp && \
            wget -O $WIKI_DOWNLOAD_NAME.tar.gz $WIKI_DOWNLOAD_URL && \
            tar xzf $WIKI_DOWNLOAD_NAME.tar.gz -C /var/www/html && \
            rm $WIKI_DOWNLOAD_NAME.tar.gz && \
            mv /var/www/html/$WIKI_FOLDER_NAME /var/www/html/wiki && \
            rm -rf /var/www/html/wiki/images && \
            ln -s /wiki/images /var/www/html/wiki/images && \
            tar xzf bin/$EXT_TEMPLATY_STYLES_NAME.tar.gz -C /var/www/html/wiki/extensions && \
            tar xzf bin/$EXT_TABS_NAME.tar.gz -C /var/www/html/wiki/extensions && \
            rm -rf bin && \
            mv /tmp/LocalSettings.php /var/www/html/wiki && \
            sed -i 's|\$wgDBname.*|\$wgDBname = "'"$DB_NAME"'";|' /var/www/html/wiki/LocalSettings.php && \
            sed -i 's|\$wgDBuser.*|\$wgDBuser = "'"$DB_USER_NAME"'";|' /var/www/html/wiki/LocalSettings.php && \
            chown -R wiki:wiki /var/www/html/wiki

# Configure helper scripts
RUN         mv /tmp/containerConfig /wiki/scripts && \
            mv /tmp/containerDummy /wiki/scripts && \
            mv /tmp/containerStartup /wiki/scripts && \
            mv /tmp/containerShutdown /wiki/scripts && \
            mv /tmp/webStartup /wiki/scripts && \
            mv /tmp/webShutdown /wiki/scripts && \
            mv /tmp/utilInitialize /wiki/scripts && \
            mv /tmp/utilChangeRootPassword /wiki/scripts && \
            mv /tmp/utilChangeUserPassword /wiki/scripts && \
            mv /tmp/utilBackup /wiki/scripts && \
            mv /tmp/utilRestore /wiki/scripts && \
            chmod 755 /wiki/scripts/*

USER        $RUN_USER

EXPOSE      $RUN_PORT

ENTRYPOINT  ["/wiki/scripts/containerStartup"]
