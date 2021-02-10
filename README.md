# Wiki web server
Docker image for wiki web server.

Container runs as non-root user.
This user owns wiki process and owns wiki files.

To run container next volumes should be mapped:
* folder for SQL database
* folder for wiki images
* logs folder
* backups folder

## Installation
### Installation from docker image
1. Pull docker image.
2. Create user and group to own wiki files and to run docker container:
    ```
    sudo groupadd -g 962 wiki
    ```
    ```
    useradd -u 962 -g 962 -M wiki
    ```
3. Proceed to configuration.

### Installation from source
1. Pull project sources from version control system.
2. Create user and group to own wiki files and to run docker container:
    ```
    sudo useradd -r wiki
    ```
3. Make **build** executable:
    ```
    sudo chmod u+x ./build
    ```
4. Execute **build**:
    ```
    sudo ./build wiki
    ```
5. Proceed to configuration.

### Configuration
1. Create folders for wiki files:
    ```
    sudo mkdir /wiki
    ```
    ```
    sudo mkdir /wiki/db
    ```
    ```
    sudo mkdir /wiki/images
    ```
2. Create folder for logs:
    ```
    sudo mkdir /var/log/wiki
    ```
3. Create folder for backups:
    ```
    sudo mkdir /var/backups/wiki
    ```
4. Grant permit to all folders:
    ```
    sudo chown -R wiki:wiki /wiki
    ```
    ```
    sudo chown wiki:wiki /var/log/wiki
    ```
    ```
    sudo chown wiki:wiki /var/backups/wiki
    ```
5. Copy **etc/init.d/wiki** to **/etc/init.d** folder:
    ```
    sudo cp ./etc/init.d/wiki /etc/init.d
    ```
6. Copy **usr/sbin/wiki** to **/usr/sbin** folder:
    ```
    sudo cp ./usr/sbin/wiki /usr/sbin
    ```
7. Copy **usr/bin/wkutil** to **/usr/bin** folder:
    ```
    sudo cp ./usr/bin/wkutil /usr/bin
    ```
8. Make all files executable:
    ```
    sudo chmod a+x /etc/init.d/wiki
    ```
    ```
    sudo chmod a+x /usr/sbin/wiki
    ```
    ```
    sudo chmod a+x /usr/bin/wkutil
    ```
9. Register service:
    ```
    sudo update-rc.d wiki defaults
    ```
10. Specify database root password in **/usr/sbin/wiki** file:
    ```
    docker run ... -e DB_ROOT_PASSWORD="<some_password>" ...
    ```
11. Specify wiki database user password in **/usr/sbin/wiki** file:
    ```
    docker run ... -e DB_USER_PASSWORD="<some_password>" ...  
    ```
12. Specify wiki server URL in **/usr/sbin/wiki** file:
    ```
    docker run ... -e SERVER="<some_server>" ...  
    ```
13. Specify wiki language code in **/usr/sbin/wiki** file:
    ```
    docker run ... -e LANGUAGE_CODE="<some_language_code>" ...  
    ```
14. Start wiki service:
    ```
    sudo service wiki start
    ```
15. Initialize wiki database:
    ```
    sudo wkutil initialize
    ```
16. Obtain the generated secret key and upgrade key from the output.
17. Specify wiki secret key in **/usr/sbin/wiki** file:
    ```
    docker run ... -e SECRET_KEY="<some_key>" ...  
    ```
18. Specify wiki upgrade key in **/usr/sbin/wiki** file:
    ```
    docker run ... -e UPGRADE_KEY="<some_key>" ...  
    ```
19. Restart wiki service:
    ```
    sudo service wiki restart
    ```

## Management
### Service management
```
sudo service wiki (start|stop|status|restart)
```

### Create backup
```
sudo wkutil backup <filename>
```

Backup file **/var/backups/wiki/&lt;filename&gt;.tar.gz** will be created.

### Restore backup
```
sudo wkutil restore <filename>
```

### Command line (bash)
```
sudo wkutil bash
```

## Apache mod_proxy configuration
Wiki web server can be located with another web applications.
For example, mercurial, bugzilla, wiki etc can be run as docker containers on the same host.
In this case apache server can be used to redirect requests to different docker containers.

1. Enable apache mod_proxy:
    ```
    sudo a2enmod deflate headers proxy proxy_ajp proxy_balancer proxy_connect proxy_html proxy_http rewrite
    ```
2. Configure proxy:
    ```
    <VirtualHost *:80>
        ...
        ProxyPreserveHost On
        <Proxy *>
            Order allow,deny
            Allow from all
        </Proxy>
        ...
    </VirtualHost>
    ```
3. Copy **./etc/apache2/sites-available/wiki.conf** to **/etc/apache2/sites-available** folder:
    ```
    sudo cp ./etc/apache2/sites-available/wiki.conf /etc/apache2/sites-available
    ```
4. Enable apache sites:
    ```
    sudo a2ensite wiki
    ```
5. Restart apache service:
    ```
    sudo service apache2 restart
    ```

## HOW TO
### How to change database root password
1. Stop wiki service:
    ```
    sudo service wiki stop
    ```
2. Specify new database root password in **/usr/sbin/wiki** file:
    ```
    docker run ... -e DB_ROOT_PASSWORD="<new_password>" ...
    ```
3. Start wiki service:
    ```
    sudo service wiki start
    ```
4. Run the following command:
    ```
    sudo wkutil changeRootPassword "<old_password>"
    ```

### How to change wiki database user password
1. Stop wiki service:
    ```
    sudo service wiki stop
    ```
2. Specify new wiki database user password in **/usr/sbin/wiki** file:
    ```
    docker run ... -e DB_USER_PASSWORD="<new_password>" ...  
    ```
3. Start wiki service:
    ```
    sudo service wiki start
    ```
4. Run the following command
    ```
    sudo wkutil changeUserPassword
    ```

### How to specify special characters in password
Special characters should be escaped:
```
docker run ... -e DB_ROOT_PASSWORD="pa\$\$word" ...
```
```
docker run ... -e DB_USER_PASSWORD="pas\$11" ...  
```

### How to create cron job for backups
```
sudo crontab -l | { cat; echo "minute hour * * * /usr/bin/wkutil backup <filename>"; echo ""; } | sudo crontab -
```

# Donation
If you find my code useful, you can [bye me a coffee](https://www.paypal.me/dshapovalov)
