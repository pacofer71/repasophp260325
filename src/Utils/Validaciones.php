<?php
namespace App\Utils;

use App\Db\{Categoria,Producto};

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

    public static function isCampoUnico(string $valor, string $nomClase, ?int $id=null): bool{
        if(!$nomClase::isNombreUnico($valor, $id)){
            $_SESSION['err_nombre']="*** Error el nombre ya existe en la base de datos";
            return false;
        }
        return true;
    }
   

    public static function existeCategoria(int $id){
        if(count(Categoria::read($id))==0){
            $_SESSION['err_categoria']="*** Error la categoria no existe o no seleccionaste ninguna";
            return false;
        }
        return true;
    }

    public static function isImagenValida(string $tipo, int $size){
        $imageMimeTypes = [
            'image/jpeg',    // JPEG
            'image/png',     // PNG
            'image/gif',     // GIF
            'image/bmp',     // BMP
            'image/webp',    // WebP
            'image/svg+xml', // SVG
            'image/tiff',    // TIFF
            'image/heif',    // HEIF
            'image/heic',    // HEIC
            'image/x-icon'   // ICO
        ];
        if(!in_array($tipo, $imageMimeTypes) || $size>2_097_152){
            $_SESSION['err_imagen']="*** Error o no es un fichero de imagen o excede los 2MB";
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