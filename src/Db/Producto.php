<?php
namespace App\Db;
use \PDO;
use \PDOException;
use \PDOStatement;

class Producto extends Conexion{
    private int $id;
    private string $nombre;
    private string $descripcion;
    private string $imagen;
    private int $categoria_id;
    

    private static function executeQuery(string $query, array $parametros=[], bool $flag=false): ?PDOStatement {
        $stmt=parent::getConexion()->prepare($query);
        try{
            (count($parametros)) ? $stmt->execute($parametros) : $stmt->execute() ;
            return ($flag) ? $stmt : null;
        }catch(PDOException $ex){
            throw new PDOException("Error: ".$ex->getMessage());
        }finally{
            parent::cerrarConexion();
        }
    }

    public function create(){
        $q="insert into productos(nombre, descripcion, categoria_id, imagen) values(:n, :d, :ci, :im)";
        $atributos=[':n'=>$this->nombre, ':d'=>$this->descripcion, ':ci'=>$this->categoria_id, ':im'=>$this->imagen];
        self::executeQuery($q, $atributos, false);
    }

    public static function read(): array{
        $q="select productos.*, categorias.nombre as nomcat from productos, categorias
        where categoria_id=categorias.id order by nomcat, productos.nombre";
        $stmt=self::executeQuery($q, [], true);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function isNombreUnico(string $nombre): bool{
        $q="select id from productos where nombre=:n";
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

    /**
     * Set the value of descripcion
     */
    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Set the value of imagen
     */
    public function setImagen(?string $imagen=null): self
    {
        $this->imagen = (is_null($imagen)) ? "img/default.png" :$imagen;

        return $this;
    }

    /**
     * Set the value of categoria_id
     */
    public function setCategoriaId(int $categoria_id): self
    {
        $this->categoria_id = $categoria_id;

        return $this;
    }
}