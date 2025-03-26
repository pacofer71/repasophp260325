<?php

use App\Db\Categoria;
use App\Utils\Validaciones;

    session_start();
    require_once __DIR__."/../../vendor/autoload.php";
    if(isset($_POST['nombre'])){
        //procesamos el form
        $nombre=Validaciones::sanearCadena($_POST['nombre']);
        $errores=false;
        if(!Validaciones::longitudCampoValida('nombre', $nombre, 3, 50)){
            $errores=true;
        }else{
            //longitud valida comprobare si el campo está duplicado
            if(!Validaciones::isCampoUnico($nombre)){
                $errores=true;
            }
        }
        if($errores){
            header("Location:nuevo.php");
            die();
        }
        // Si estoy aquí es porque no hay errores guardare el registro
        (new Categoria)->setNombre($nombre)->create();
        $_SESSION['mensaje']="Categoria Creada";
        header("Location:index.php");
        exit();


        
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
    <title>Crear Categoria</title>
</head>

<body class="bg-slate-200">
    <h3 class="my-2 text-2xl text-center">Nueva Categoría</h3>
    <div class="w-1/2 mx-auto p-8 rounded-2xl shadow-2xl border-2 border-slate-500">
    <form action="nuevo.php" method="POST">
            <!-- Campo Nombre -->
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <div class="flex items-center border border-gray-300 rounded-md mt-1">
                    <input type="text" id="nombre" name="nombre" class="w-full px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md" placeholder="Ingrese su nombre">
                    <i class="fas fa-tag px-4 text-gray-500"></i>
                </div>
                <?php
                    Validaciones::pintarError('err_nombre');
                 ?>
            </div>
            <!-- Botones -->
            <div class="flex flex-row-reverse gap-2">
                <button type="submit" class="flex items-center px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    <i class="fas fa-check mr-2"></i> Crear
                </button>
                <a href="index.php" class="flex items-center px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</body>
</html>