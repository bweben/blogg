8888888b.  8888888888        d8888 8888888b.  888b     d888 8888888888 
888   Y88b 888              d88888 888  "Y88b 8888b   d8888 888        
888    888 888             d88P888 888    888 88888b.d88888 888        
888   d88P 8888888        d88P 888 888    888 888Y88888P888 8888888    
8888888P"  888           d88P  888 888    888 888 Y888P 888 888        
888 T88b   888          d88P   888 888    888 888  Y8P  888 888        
888  T88b  888         d8888888888 888  .d88P 888   "   888 888        
888   T88b 8888888888 d88P     888 8888888P"  888       888 8888888888 
----------------------------------------------------------------------

Vorgehen:
1. Das Projekt in einen Ordner kopieren.
2. In Apache das File http.conf öffnen und folgendes an Datei Ende einfügen,
[Pfad] mit dem Pfad ersetzen, indem der Ordner Code vom Projekt gespeichert ist.

<VirtualHost 127.0.0.1>
    ServerName www.blog.local
    ServerAlias blog.local
    AddType text/html .shtml
    AddHandler server-parsed .shtml
    ServerAdmin webmaster@mvc.local
    DocumentRoot "[Pfad]"

    <Directory "[Pfad]">
        Options Indexes FollowSymLinks
        Options +Includes
        AllowOverride All
        Order allow,deny
        Require all granted
        Allow from All
        DirectoryIndex index.php
    </Directory>
</VirtualHost>

3. In der http.conf Datei ca. in der Mitte bei folgendem den Pfad eingeben,
wo sich der Ordner Code vom Projekt befindet.

DocumentRoot "[Pfad]"
<Directory "[Pfad]">

-----------------------------------------------------------------------------

Bei Fragen:
1. Fehleranalyse durchführen.
2. Google verwenden.
3. Mich anfragen.

--   __      ___      _              _____              _    
--   \ \    / (_)    | |            |  __ \            | |   
--    \ \  / / _  ___| | ___ _ __   | |  | | __ _ _ __ | | __
--     \ \/ / | |/ _ \ |/ _ \ '_ \  | |  | |/ _` | '_ \| |/ /
--      \  /  | |  __/ |  __/ | | | | |__| | (_| | | | |   < 
--       \/   |_|\___|_|\___|_| |_| |_____/ \__,_|_| |_|_|\_\
--                                                           
--                                                           