<?php

use App\Db\Producto;

session_start();
require __DIR__ . "/../../vendor/autoload.php";
$productos = Producto::read();

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
    <title>Productos</title>
</head>

<body class="bg-slate-200">
    <h3 class="my-2 text-2xl text-center">Listado de Productos</h3>
    <div class="w-1/2 mx-auto">
        <div class="flex flex-row-reverse mb-2">
            <a href="nuevo.php" class="p-2 rounded-lg bg-blue-400 hover:bg-blue-600 text-white font-bold upper">
                <i class="fas fa-add mr-2"></i>NUEVO
            </a>
        </div>
        <!-- tabla con los productos -->



        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-16 py-3">
                        <span class="sr-only">Image</span>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        NOMBRE
                    </th>
                    <th scope="col" class="px-6 py-3">
                        DESCRIPCION
                    </th>
                    <th scope="col" class="px-6 py-3">
                        CATEGORIA
                    </th>
                    <th scope="col" class="px-6 py-3">
                        ACCIONES
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $item): ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="p-4">
                            <img src="../<?= $item->imagen ?>" class="w-16 md:w-32 max-w-full max-h-full" alt="<?= $item->nombre; ?>">
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                            <?= $item->nombre ?>
                        </td>
                        <td class="px-6 py-4">
                            <?= $item->descripcion ?>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                            <?= $item->nomcat ?>
                        </td>
                        <td class="px-6 py-4">

                            <form method="POST" action="borrar.php">
                                <a href="update.php?pid=<?= $item->id ?>">
                                    <i class="fas fa-edit text-xl"></i>
                                </a>
                                <input type="hidden" name="pid" value="<?= $item->id ?>" />
                                <button type="submit" onclick="return confirm('¿Borrar Producto?');">
                                    <i class="fas fa-trash text-xl"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>


    </div>
    <?php if (isset($_SESSION['mensaje'])): ?>
        <script>
            Swal.fire({
                icon: "success",
                title: "<?= $_SESSION['mensaje'] ?>",
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    <?php unset($_SESSION['mensaje']);
    endif ?>
</body>

</html>