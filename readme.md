# Environment Configuration

## Install MySql 

0. The following steps followed this [video](https://www.youtube.com/watch?v=WuBcTJnIuzo).

1. Go to the [webpage](https://dev.mysql.com/downloads/windows/installer/8.0.html) and download either version(online or offline) of Mysql Installer and install. *Note: MySQL Installer is 32 bit, but will install both 32 bit and 64 bit binaries*.

## Install Apache 2.4

0. The following steps followed this [video](https://www.youtube.com/watch?v=TDpllMVuoeE). 

1. Go the [Downloading Apache for Windows](https://httpd.apache.org/docs/current/platform/windows.html#down). Clicked `Apache Lounge` and we will be directed to [Apache Lounge Download site](https://www.apachelounge.com/download/)

2. Be sure to download and install `C++ Redistributable Visual Studio 2017 ` before installing `Apache 2.4`. Click `vc_redist_x64`, download and install.

3. Download `Apache 2.4.39 Win64` (current version when creating this documentation).

4. Create a new folder under `C:\` with name `Apache24`

5. Extract the zip file `httpd-2.4.39-win64-VC15.zip` under the path `C:\Apache24\`

6. Add `PHP7` into system path variable: 

    * Search `environment variable` in `Windows Start`
    * Find the `Path` variable under `System Variables` section and click Edit. A new dialog will pop up
    * Click `New` and type `C:\Apache24\bin` into the field. You can also use `Browse` to add new value instead of typing.

7. Run `Command Prompt` as `administrator`, then type `httpd -k install`. You should get 

```shell
The 'Apache2.4' service is successfully installed.
```

You may get errors after `Testing httpd.conf...`, but just ignore.

8. Search `Services` in `Windows Start`. Find `Apache 2.4` in windows services. Right click and start.

9. Open your favourite web browser and type `localhost:` in url field and you should get 'It works'.


## Install PHP

0. The following steps followed this [video](https://www.youtube.com/watch?v=iW0B9NTId2g&list=PLQ-hdHPyZo5aCvycZEahlbHyDJfB-WltC&index=2&t=0s).

1. Go to [php dowload](https://windows.php.net/download/) and download the latest version of `x64 Tread Safe version` for Windows x64 OS.

2. Create a new folder under `C:\` with name `PHP7`

3. Extract the zip file `php-7.3.4-Win32-VC15-x64` under the path `C:\PHP7\`

4. Open folder `C:\PHP7\` and copy the file `php.ini-development` to another file into `php - Copy.ini-development`

5. Rename file `php - Copy.ini-development` into `php.ini`.
 
6. Open `open.ini` and search keyword `extension_dir`, uncomment `extension_dir = "ext"`

7. Continue uncommenting: uncomment modules: `extension=curl`, `extension=fileinfo`, `extension=gd2`, `extension=gettext`, `extension=gmp`, `extension=mysqli`, `extension=pdo_sqlite`, `extension=pgsql`, `extension=shmop`, `extension=sqlite3`
`extension=tidy`, `extension=xmlrpc`, `extension=xsl`

6. Add `PHP7` into system path variable: 

    * Search `environment variable` in `Windows Start`
    * Find the `Path` variable under `System Variables` section and click Edit. A new dialog will pop up
    * Click `New` and type `C:\PHP7` into the field. You can also use `Browse` to add new value instead of typing.

9. Open `Command Prompt` and type in `php -v` to check whether php is installed correctly.


## Make MySql, Appache2.4 and PHP 7 work together

1. Open file `C:\Apache24\conf\httpd.conf` with vs code.

2. Scroll to the end of the file and copy the following code at the end.

```
LoadModule php7_module "C:/PHP7/php7apache2_4.dll"
AddHandler application/x-httpd-php .php
AddType application/x-httpd-php .php .html
# configure the path to php.ini
PHPiniDir "C:/PHP7"
```

3. Search `DirectoryIndex` and change `index.html` to `index.php`.

4. Search `ServerName`, uncomment the line and change `www.example.com:80` to `localhost`.

5. Open `CMD` and type `httpd -S`, we should get 

```
VirtualHost configuration:
ServerRoot: "C:/Apache24"
Main DocumentRoot: "C:/Apache24/htdocs"
Main ErrorLog: "C:/Apache24/logs/error.log"
Mutex default: dir="C:/Apache24/logs/" mechanism=default
PidFile: "C:/Apache24/logs/httpd.pid"
Define: DUMP_VHOSTS
Define: DUMP_RUN_CFG
Define: SRVROOT=c:/Apache24
```

6. Stop the Apache Server in Windows Service and restart it again. (The reason we are doing this is because we changed some configuration in `httpd.conf` file). Now the Apache Server will load `php7apache2_4.dll` when serving.

7. Create a new file `info.php` with content 

```
<?php 
phpinfo();
?>
```

open browser and type `http://localhost/info.php`. The webpage will show all the infomation of the configuration. Now the Apache server uses php parser to parse php file, the connection between Apache and php is complete.