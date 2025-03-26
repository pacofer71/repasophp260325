<?php
namespace App\Db;
use \PDOException;
use \PDO;

class Categoria extends Conexion{
    private int $id;
    private string $nombre;


    private static function executeQuery(string $query, array $parametros=[], bool $flag=false){
        $stmt=parent::getConexion()->prepare($query);
        try{
            (count($parametros)) ? $stmt->execute($parametros) : $stmt->execute();
            return ($flag) ? $stmt : null;
        }catch(PDOException $ex){
            throw new PDOException("Error en consulta: ".$ex->getMessage());
        }finally{
            parent::cerrarConexion();
        }     
    }

    public static function read(): array{
        $q="select * from categorias order by id desc";
        $stmt=self::executeQuery(query: $q, flag:true);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function create(){
        $q="insert into categorias(nombre) values(:n)";
        self::executeQuery($q, [':n'=>$this->nombre]);
    }

    public static function delete(int $id){
        $q="delete from categorias where id=:i";
        self::executeQuery($q, [':i'=>$id]);
    }

    public static function isNombreUnico(string $nombre): bool{
        $q="select id from categorias where nombre=:n";
        $stmt=self::executeQuery($q, [':n'=>$nombre], true);
        //var_dump( $stmt->fetch(PDO::FETCH_OBJ));
        //die();
        return $stmt->fetch(PDO::FETCH_OBJ) ? false : true;
    }

    


    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }
}