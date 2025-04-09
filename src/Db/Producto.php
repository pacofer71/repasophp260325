<?php

namespace App\Db;

use \PDO;
use \PDOException;
use \PDOStatement;

class Producto extends Conexion
{
    private int $id;
    private string $nombre;
    private string $descripcion;
    private string $imagen;
    private int $categoria_id;


    private static function executeQuery(string $query, array $parametros = [], bool $flag = false): ?PDOStatement
    {
        $stmt = parent::getConexion()->prepare($query);
        try {
            (count($parametros)) ? $stmt->execute($parametros) : $stmt->execute();
            return ($flag) ? $stmt : null;
        } catch (PDOException $ex) {
            throw new PDOException("Error: " . $ex->getMessage());
        } finally {
            parent::cerrarConexion();
        }
    }

    public function create()
    {
        $q = "insert into productos(nombre, descripcion, categoria_id, imagen) values(:n, :d, :ci, :im)";
        $atributos = [':n' => $this->nombre, ':d' => $this->descripcion, ':ci' => $this->categoria_id, ':im' => $this->imagen];
        self::executeQuery($q, $atributos, false);
    }

    public static function read(?int $id = null): array
    {
        $q = (is_null($id)) ?
            "select productos.*, categorias.nombre as nomcat from productos, categorias
        where categoria_id=categorias.id order by nomcat, productos.nombre" :

            "select productos.*, categorias.nombre as nomcat from productos, categorias
        where categoria_id=categorias.id AND productos.id=:i order by nomcat, productos.nombre";
        $atributos = is_null($id) ? [] : [':i' => $id];

        $stmt = self::executeQuery($q, $atributos, true);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function delete(int $id)
    {
        $q = "delete from productos where id=:i";
        self::executeQuery($q, [':i' => $id], false);
    }

    public function update(int $id)
    {
        $q = "update productos set nombre=:n, descripcion=:d, categoria_id=:ci, imagen=:im where id=:i";
        $atributos = [
            ':n' => $this->nombre,
            ':d' => $this->descripcion,
            ':ci' => $this->categoria_id,
            ':im' => $this->imagen,
            ':i' => $id
        ];
        self::executeQuery($q, $atributos, false);
    }

    public static function isNombreUnico(string $nombre, ?int $id = null): bool
    {
        $q = (is_null($id)) ? "select id from productos where nombre=:n"
            : "select id from productos where nombre=:n AND id != :i";

        $parametros = (is_null($id)) ? [':n' => $nombre] : [':n' => $nombre, ':i' => $id];
        
        $stmt = self::executeQuery($q, $parametros, true);
        //var_dump( $stmt->fetch(PDO::FETCH_OBJ));
        //die();
        return $stmt->fetch(PDO::FETCH_OBJ) ? false : true;
    }

    public static function getImagen(int $id): bool|string
    {
        $q = "select imagen from productos where id=:i";
        $stmt = self::executeQuery($q, [':i' => $id], true);
        $filas = $stmt->fetchAll(PDO::FETCH_OBJ);
        return count($filas) ? $filas[0]->imagen :  false;
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
    public function setImagen(?string $imagen = null): self
    {
        $this->imagen = (is_null($imagen)) ? "img/default.png" : $imagen;

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
