<?php

class db
{
    private $dbhost = 'localhost';

    //servidor
//    private $dbuser = 'viajero2';
//    private $dbpass = 'Alvaro_3414789';
//    private $dbname = 'viajero2_ViajerosAPP';

    //local
    private $dbuser = 'root';
    private $dbpass = '';
    private $dbname = 'ViajerosAPP';

    public function connect()
    {
        $mysql_connect_str = "mysql:host=$this->dbhost;dbname=$this->dbname";
        $dbConnection = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }
}