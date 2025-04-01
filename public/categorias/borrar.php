<?php
session_start();
use App\Db\Categoria;

require __DIR__."/../../vendor/autoload.php";
if(!$id=filter_input(INPUT_POST, 'cat_id', FILTER_VALIDATE_INT)){
    header("Location:index.php");
    die();
}
//hemos mandado por post el id y es un numero entero
Categoria::delete($id);
$_SESSION['mensaje']="Se ha borrado la categoría";
header("Location:index.php");