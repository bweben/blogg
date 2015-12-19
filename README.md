# Web Blog
* Use Chrome to test the application

## Installation
1. Copy the project into any directory
2. Copy directory path

### Downloads
1. Download [Apache](https://www.apachefriends.org/xampp-files/5.6.15/xampp-win32-5.6.15-1-VC11-installer.exe)
2. Install Apache

### Apache Configuration
1. Start Apache
2. Click on Config -> httpd.conf
3. Search DocumentRoot and write into the second result the directory of the project
4. Write into the WorkingDirectory the directory of the project
5. Add the following at the bottom of the file:

```
<VirtualHost 127.0.0.1>
    ServerName www.blog.local
    ServerAlias blog.local
    AddType text/html .shtml
    AddHandler server-parsed .shtml
    ServerAdmin webmaster@mvc.local
    DocumentRoot "[Path]"

    <Directory "[Path]">
        Options Indexes FollowSymLinks
        Options +Includes
        AllowOverride All
        Order allow,deny
        Require all granted
        Allow from All
        DirectoryIndex index.php
    </Directory>
</VirtualHost>
```

6. Write the directory into the path (here : [Path])
7. Restart Apache

## Users
### Standard
* iet-gibb@test.ch

### Administrator
* iet-admin@test.ch

## Handling
* Log in with the user and the default password "Welcome$15"

### Create a user
* Fill in all fields to create a user
* Hit submit or senden

### Create a blog entity
* Hit create on the start site
* Fill in all fields

### Sort by categories
* Click on a category under the categories heading
* Click on all to go to the main site

### User overview
* Click on > User Overview

### Logout
* Click on your email on the top right corner
* Hit logout