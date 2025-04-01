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
    <title>NuevoProducto</title>
</head>

<body class="bg-slate-200">
    <h3 class="my-2 text-2xl text-center">Producto Nuevo</h3>
    <div class="w-1/2 p-8 rounded-xl shadow-xl border-2 border-slate-300 mx-auto bg-gray-100">
        <form>
            <!-- Nombre -->
            <div class="flex items-center space-x-2 mb-4">
                <i class="fas fa-user text-gray-500"></i>
                <input type="text" name="nombre" placeholder="Nombre" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Descripción -->
            <div class="flex items-center space-x-2 mb-4">
                <i class="fas fa-align-left text-gray-500"></i>
                <textarea name="descripcion" placeholder="Descripción" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <!-- Categoría -->
            <div class="flex items-center space-x-2 mb-4">
                <i class="fas fa-list text-gray-500"></i>
                <select name="categoria" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                    <option value="" disabled selected>Seleccionar categoría</option>
                    <option value="categoria1">Categoría 1</option>
                    <option value="categoria2">Categoría 2</option>
                    <option value="categoria3">Categoría 3</option>
                </select>
            </div>

            <!-- Imagen -->
            <div class="flex items-center space-x-2 mb-4">
                <i class="fas fa-image text-gray-500"></i>
                <input type="file" name="imagen" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                <img id="imagen-preview" class="w-20 h-20 object-cover rounded-md ml-4" />
            </div>

            <!-- Botones -->
            <div class="flex space-x-4">
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