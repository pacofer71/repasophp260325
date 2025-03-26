<?php
namespace App\Db;
use \PDO;
use \PDOException;

class Conexion{
    private static ?PDO $conexion=null;

    protected static function getConexion(): PDO{
        if(is_null(self::$conexion)){
            self::setConexion();
        }
        return self::$conexion;
    }

    private static function setConexion(){
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__."/../../");
        $dotenv->load();
        $usuario=$_ENV['USUARIO'];
        $host=$_ENV['HOST'];
        $database=$_ENV['DATABASE'];
        $password=$_ENV['PASSWORD'];
        $port=$_ENV['PORT'];

        //nos creamos el descriptor de conexion dsn
        $dsn="mysql:host=$host;dbname=$database;port=$port;charset=utf8mb4";

        $opciones=[
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT=>true
        ];
        try{
            self::$conexion=new PDO($dsn, $usuario, $password, $opciones);
        }catch(PDOException $ex){
            throw new PDOException("Error en la conexion: ".$ex->getMessage());
        }
    }

    protected static function cerrarConexion(){
        self::$conexion=null;
    }

}