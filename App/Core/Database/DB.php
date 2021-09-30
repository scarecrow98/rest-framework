<?php

namespace App\Core\Database;
use \Exception;
use PDO;

class DB {

    private static $con = null;
    private static string $host = 'localhost';
    private static string $user = 'root';
    private static string|null $password = 'asdasdasd';
    private static string $database = 'grtc';

    public static function init($host, $user, $password, $database) {

    }

    public static function con() {
        if (!self::$con) {
            self::$con = new PDO(
                'mysql:host=' . self::$host . ';dbname=' . self::$database,
                self::$user,
                self::$password,
                [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_general_ci',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
        }

        return self::$con;
    }

    public static function qb(): QueryBuilder {
        return new QueryBuilder(self::con());
    }
}