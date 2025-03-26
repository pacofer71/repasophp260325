<?php
namespace App\Utils;

use App\Db\Categoria;

class Validaciones{
    public static function sanearCadena(string $cad): string{
        return htmlspecialchars(trim($cad));
    } 

    public static function longitudCampoValida(string $nomCamp, string $valorCamp, int $min, int $max): bool{
        if(strlen($valorCamp)<$min || strlen($valorCamp)>$max){
            $_SESSION["err_$nomCamp"]="*** Error la longitd debe estar entre $min y $max";
            return false;
        }
        return true;
    }

    public static function isCampoUnico($valor): bool{
        if(!Categoria::isNombreUnico($valor)){
            $_SESSION['err_nombre']="*** Error el nombre ya existe en la base de datos";
            return false;
        }
        return true;
    }

    public static function pintarError(string $nombre_error){
        if(isset($_SESSION[$nombre_error])){
            echo "<p class='text-sm italic text-red-500 mt-1'>{$_SESSION[$nombre_error]}</p>";
            unset($_SESSION[$nombre_error]);
        }
    }
}