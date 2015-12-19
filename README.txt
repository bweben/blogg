# Web Blog
* Brauchen Sie Chrome zum Testen

## Installation
1. Kopieren Sie das Projekt in irgendeinen Pfad
2. Kopieren Sie den Projekt Pfad

### Downloads
1. Apache herunterladen (https://www.apachefriends.org/xampp-files/5.6.15/xampp-win32-5.6.15-1-VC11-installer.exe)
2. Apache konfigurieren

### Apache Configuration
1. Apache starten
2. Auf Config klicken -> httpd.conf
3. DocumentRoot suchen und ins 2. Ergebnis der Pfad vom Projekt einf�gen
4. WorkingDirectory, direkt darunter, aufsuchen und ebenfalls der Pfad vom Projekt als Pfad einf�gen.
5. Folgendes ans Datei Ende einf�gen


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


6. Der Projekt Pfad dort schreiben, wo [Pfad] steht.
7. Apache neustarten

## Benutzer
### Standard
* iet-gibb@test.ch

### Administrator
* iet-admin@test.ch

## Anleitung
* Mit einem von den oberen Nutzern anmelden, das Passwort ist: Welcome$15

### Benutzer einloggen
* Email und Passwort ausf�llen
* Senden dr�cken

### Benutzer erstellen
* Alle Felder ausf�llen
* Senden dr�cken

### Blog Eintrag erstellen
* Auf der Startseite "Create Blog Entity" dr�cken.
* Alle Felder ausf�llen

### Nach Kategorien limitieren
* Eine Kategorie klicken
* Um zur�ck zu kommen, All klicken

### Benutzer �bersicht
* Auf "User Overview" klicken

### Abmelden
* Auf Ihre Email oben rechts klicken
* "Logout" klicken             