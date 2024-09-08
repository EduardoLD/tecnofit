<?php

class Connection
{
    protected static $db;

    private function __construct()
    {
        $driver   = 'mysql';
        $host     = 'sql10.freemysqlhosting.net';
        $dbname   = 'sql10730151';
        $username = 'sql10730151';
        $password = 'L27NWuwhM7';  
        $port     = '3306';  

        try {
            self::$db = new PDO("{$driver}:host={$host};port={$port};dbname={$dbname}", $username, $password);

            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            self::$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getConnection()
    {
        if ( !self::$db ) {
            new Connection();
        }

        return self::$db;
    }
}
