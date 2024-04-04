<?php

namespace Model;

abstract class Connect {
    // const HOST = "db";
    const HOST = "localhost";
    const DB = "cinema_gino";
    const USER = "root";
    const PASS = "";

    public static function seConnecter() {
        try {
            return new \PDO(
                "mysql:host=". self::HOST .";dbname=". self::DB,
                self::USER, 
                self::PASS
            );

        } catch(\PDOException $ex){
            return $ex->getMessage();
        }
    }
}

