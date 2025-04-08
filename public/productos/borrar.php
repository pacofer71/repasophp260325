<?php
session_start();
use App\Db\Producto;
function salir(){
    header("Location:index.php");
    die();
}

require __DIR__."/../../vendor/autoload.php";
if(!$id=filter_input(INPUT_POST, 'pid', FILTER_VALIDATE_INT)){
   salir();
}
//hemos mandado por post el id y es un numero entero
//tenemos que borrar la imagen del producto elimiado siempre y cuando
//no sea default.png
//recupero la imagen y de paso compruebo que existe

if(!$imagen=Producto::getImagen($id)){
   salir();
}

//existe la imagen la borraré si no es default.png y borraré el producto tambien
Producto::delete($id);

if(basename($imagen)!="default.png"){
    unlink("../$imagen");
}
$_SESSION['mensaje']='Producto Borrado';
salir();