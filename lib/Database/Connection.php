<?php

class Connection
{
    // private static $conn;

    // public static function getConn()
    // {
    //     if ( self::$conn == null ) {
    //         self::$conn = new PDO('mysql: host=localhost; dbname=db_tecnofit;', 'root', '');
    //     }

    //     return self::$conn;
    // }

    protected static $db;

    private function __construct()
    {
        $driver   = 'mysql';
        $host     = 'localhost';
        $dbname   = 'Db_tecnofit';
        $username = 'root';

        try {
            self::$db = new PDO("{$driver}: host={$host}; dbname={$dbname}", $username);

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