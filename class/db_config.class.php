<?php
    class N
    {
        public static $e;
        public static $database;
        public static $interval = 0;
        public static $DIR = "https://fyores.com";
        public static $GMAIL = "info@fyores.com";
        public static $GMAIL_PASSWORD = "+Xc7,ofT~ypo";

        public static function _DB()
        {
            try
            {
                self::$database = new PDO('mysql:host=localhost; dbname=meemabvx_fyores; charset=utf8mb4', 'meemabvx_fyores77', 'dfbX4_EsMOX@');
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
