<?php
    class N
    {
        public static $e;
        public static $database;
        public static $interval = 0;
        public static $DIR = "https://fyores.com";
        public static $GMAIL = "info@fyores.com";
        public static $GMAIL_PASSWORD = "";

        public static function _DB()
        {
            try
            {
                self::$database = new PDO('mysql:host=localhost; dbname=fyores; charset=utf8mb4', '', '');
                self::$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $e = self::$e;
            }
            catch (PDOException $e)
            {
                echo $e->getMessage();
            }
            return self::$database;
        }
    }
?>
