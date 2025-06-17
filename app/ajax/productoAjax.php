<?php
require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\productController;
if (isset($_POST['modulo_producto'])) {
    $insProducto = new productController();
    // Verifica si se deben realizar ambas acciones
    if ($_POST['modulo_producto'] == "actualizar" || $_POST['modulo_producto'] == "actualizarFoto") {
        // Si se envía "actualizar" o "actualizarFoto", ejecuta ambas acciones
        $respuestaActualizar = $insProducto->actualizarProductoControlador();
        $respuestaActualizarFoto = $insProducto->actualizarFotoProductoControlador();

        // Combina las respuestas
        $respuesta = [
            'tipo' => 'recargar',
            'icono' => 'success',
            'titulo' => '¡Éxito!',
            'texto' => 'Los campos y la imagen se actualizaron correctamente.'
        ];
        echo json_encode($respuesta);
    } else {
        // Manejo de otras acciones (registrar, eliminar, etc.)
        if ($_POST['modulo_producto'] == "registrar") {
            echo $insProducto->registrarProductoControlador();
        }

        if ($_POST['modulo_producto'] == "eliminar") {
            echo $insProducto->eliminarProductoControlador();
        }

        if ($_POST['modulo_producto'] == "eliminarFoto") {
            echo $insProducto->eliminarFotoProductoControlador();
        }

        if ($_POST['modulo_producto'] == "listar") {
            $pagina = isset($_POST['pagina']) ? intval($_POST['pagina']) : 1;
            $registros = isset($_POST['registros']) ? intval($_POST['registros']) : 4;
            $url = isset($_POST['url']) ? $_POST['url'] : '';
            $busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';
            $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : ''; // Ya existe
            
            // Agregar estas líneas para los filtros faltantes
            $subcategoria = isset($_POST['subcategoria']) ? $_POST['subcategoria'] : '';
            $autor = isset($_POST['autor']) ? $_POST['autor'] : '';
            $editorial = isset($_POST['editorial']) ? $_POST['editorial'] : '';
            
            $resultado = $insProducto->listarProductoControlador($pagina, $registros, $url, $busqueda, $categoria, $subcategoria, $autor, $editorial);
            echo $resultado;
            exit;
        }
    }
    
} else {
    session_destroy();
    header("Location: " . APP_URL . "login/");
}