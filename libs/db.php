<?php

require_once(__DIR__ . "/../extlibs/vendor/autoload.php");
require_once(__DIR__ . "/../config.php");

class db
{
    private $db_name = "";

    function __construct($db_name, $user, $pass)
    {
        $this->db_name = $db_name;

        $connection_string = "mysql:host=localhost;dbname=" . $this->db_name;

        ORM::configure($connection_string, null, $this->db_name);
        ORM::configure("username", $user, $this->db_name);
        ORM::configure("password", $pass, $this->db_name);
    }

    function for_table($table_name)
    {
        return ORM::for_table($table_name, $this->db_name);
    }


    static private $realm_db = null;
    static private $mangos_db = null;
    static private $character_db = null;

    static function realm()
    {
        global $config;

        if (is_null(db::$realm_db))
        {
            $cfg = $config["db"]["realmdb"];
            db::$realm_db = new db($cfg["name"], $cfg["user"], $cfg["pass"]);
        }

        return db::$realm_db;
    }

    static function mangos()
    {
        global $config;

        if (is_null(db::$mangos_db))
        {
            $cfg = $config["db"]["mangosdb"];
            db::$mangos_db = new db($cfg["name"], $cfg["user"], $cfg["pass"]);
        }

        return db::$mangos_db;
    }

    static function character()
    {
        global $config;

        if (is_null(db::$character_db))
        {
            $cfg = $config["db"]["characterdb"];
            db::$character_db = new db($cfg["name"], $cfg["user"], $cfg["pass"]);
        }

        return db::$character_db;
    }
}
