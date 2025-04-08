<?php
function salir(){
    header("Location:index.php");
    die();
}
use App\Db\Categoria;
use App\Db\Producto;
use App\Utils\Validaciones;

session_start();
require __DIR__ . "/../../vendor/autoload.php";
if(!$id=filter_input(INPUT_GET, 'pid', FILTER_VALIDATE_INT)){
    salir();
 }

$categorias = Categoria::read();
$dato=Producto::read($id);
if(!count($dato)){
    $_SESSION['mensaje']="No existe el producto a editar";
    salir();
}
$producto=$dato[0];


if (isset($_POST['nombre'])) {
    $nombre = Validaciones::sanearCadena($_POST['nombre']);
    $descripcion = Validaciones::sanearCadena($_POST['descripcion']);
    $categoria = (int) Validaciones::sanearCadena($_POST['categoria']);

    $errores = false;

    if (!Validaciones::longitudCampoValida('nombre', $nombre, 3, 50)) {
        $errores = true;
    } else {
        //la longitud está bien comprobaré que NO esté duplicado
        if (!Validaciones::isCampoUnico($nombre, Producto::class, $id)) {
            $errores = true;
        }
    }
    if (!Validaciones::longitudCampoValida('descripcion', $descripcion, 5, 150)) {
        $errores = true;
    }

    if (!Validaciones::existeCategoria($categoria)) {
        $errores = true;
    }
    //procesamos la imagen si se ha subido ---------------------------------
    $imagen = null;
    if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
        //hemos subido un fichero, compruebo que sea una imagen y que no exceda 2MB
        if (!Validaciones::isImagenValida($_FILES['imagen']['type'], $_FILES['imagen']['size'])) {
            $errores = true;
        } else {
            //he subido un archivo ademas es una imagen y no excede los 2MB
            //vamos a guardarlo en la carpeta public/img en este caso, darle un nombre de forma img/nombre.jpg
            $imagen = "img/" . uniqid() . "_" . $_FILES['imagen']['name']; // img/12345_nombre.jpg
            //el archivo esta en la carpeta temporal
            //queremos guardarlo en public/img
            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], "../$imagen")) {
                $errores = true;
                $_SESSION['err_imagen'] = "*** Error , no se pudo move la imagen a la ruta deseada";
            }
        }
    }
    if ($errores) {
        header("Location:nuevo.php");
        exit;
    }
    //Si estoy aqui imagen sera null on un valor de imagen valido por ejemplo img/12345_nombre.jpg
    (new Producto)
        ->setNombre($nombre)
        ->setDescripcion($descripcion)
        ->setCategoriaId($categoria)
        ->setImagen($imagen)
        ->create();
    $_SESSION['mensaje'] = "Se guardó el producto";
    header("Location:index.php");
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CDN Tailwind css-->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- CDN Sweet alert2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--CDN Fontawesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>EditarProducto</title>
</head>

<body class="bg-slate-200">
    <h3 class="my-2 text-2xl text-center">Editar Producto</h3>
    <div class="w-1/2 p-8 rounded-xl shadow-xl border-2 border-slate-300 mx-auto bg-gray-100">
        <form action="update.php?pid=<?= $id ?>" method="POST" enctype="multipart/form-data">
            <!-- Nombre -->
            <div class="flex items-center space-x-2">
                <i class="fas fa-user text-gray-500"></i>
                <input type="text" name="nombre" value="<?= $producto->nombre?>" placeholder="Nombre" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
            </div>
            <?php
            Validaciones::pintarError('err_nombre');
            ?>

            <!-- Descripción -->
            <div class="flex items-center space-x-2 mt-4">
                <i class="fas fa-align-left text-gray-500"></i>
                <textarea name="descripcion" placeholder="Descripción" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"><?= $producto->descripcion?></textarea>
            </div>
            <?php
            Validaciones::pintarError('err_descripcion');
            ?>


            <!-- Categoría -->
            <div class="flex items-center space-x-2 mt-4">
                <i class="fas fa-list text-gray-500"></i>
                <select name="categoria" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                    <option value="">Seleccionar categoría</option>
                    <?php 
                    foreach ($categorias as $item):
                        $cadena=($producto->categoria_id==$item->id) ? "selected" : ""; 
                    ?>
                        <option value="<?= $item->id ?>" <?= $cadena?> ><?= $item->nombre ?></option>
                    <?php endforeach; ?>
                </select>

            </div>
            <?php
            Validaciones::pintarError('err_categoria');
            ?>

            <!-- Imagen -->
            <div class="flex items-center space-x-2 mt-4">
                <i class="fas fa-image text-gray-500"></i>
                <input
                    type="file"
                    name="imagen"
                    accept="image/*"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                    oninput="preview.src=window.URL.createObjectURL(this.files[0])">
                <img id="preview" 
                src="<?= "../".$producto->imagen ?>" class="w-20 h-20 object-cover object-center rounded-md ml-4" />
            </div>
            <?php
            Validaciones::pintarError('err_imagen');
            ?>

            <!-- Botones -->
            <div class="flex space-x-4 mt-4">
                <a href="index.php" class="px-4 py-2 bg-gray-500 text-white rounded-md text-center hover:bg-gray-600">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md text-center hover:bg-blue-600">
                    Enviar
                </button>
            </div>
        </form>
    </div>

</body>

</html>