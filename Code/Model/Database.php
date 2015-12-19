<?php

/**
 * Class MyDB
 * makes the database access
 */
class MyDB extends SQLite3
{
      function __construct()
      {
         $this->open('lib/blog.db');
      }
}
$db = new MyDB();
if(!$db){
   echo $db->lastErrorMsg();
} else {
   //echo "Opened database successfully\n";
}

/**
 * creates the databse if not exists
 */
$sql =<<<EOF
    CREATE TABLE IF NOT EXISTS Users
             (ID INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
             Email TEXT NOT NULL,
             Password TEXT NOT NULL,
             Nickname TEXT,
             Admin INTEGER);

    CREATE TABLE IF NOT EXISTS Categorie
            (ID INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            Description TEXT);

    CREATE TABLE IF NOT EXISTS Blog
            (ID INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
             UserID INT NOT NULL,
             Titel TEXT,
             Text TEXT,
             Date TEXT,
             CategorieID INT);

    CREATE TABLE IF NOT EXISTS Comments
            (ID INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            UserID INT,
            BlogID INT,
            Text TEXT,
            Date DATETIME);
EOF;

$ret = $db->exec($sql);
if(!$ret){
   echo $db->lastErrorMsg();
} else {
   //echo "Table created successfully\n";
}
$db->close();

