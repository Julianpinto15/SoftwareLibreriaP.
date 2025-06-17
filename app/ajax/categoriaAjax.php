<?php
require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\categoryController;

if(isset($_POST['modulo_categoria'])){
    $insCategory = new categoryController();
    $response = ['tipo' => '', 'icono' => '', 'titulo' => '', 'texto' => ''];

    try {
        switch($_POST['modulo_categoria']) {
            case 'registrar':
                $resultado = $insCategory->registrarCategoriaControlador();
                $response = [
                    'tipo' => 'limpiar',
                    'icono' => 'success',
                    'titulo' => 'Categoría Registrada',
                    'texto' => 'La categoría se registró correctamente'
                ];
                break;

            case 'eliminar':
                $resultado = $insCategory->eliminarCategoriaControlador();
                $response = [
                    'tipo' => 'recargar',
                    'icono' => 'success',
                    'titulo' => 'Categoría Eliminada',
                    'texto' => 'La categoría se eliminó correctamente'
                ];
                break;

            case 'actualizar':
                $resultado = $insCategory->actualizarCategoriaControlador();
                $response = [
                    'tipo' => 'recargar',
                    'icono' => 'success',
                    'titulo' => 'Categoría Actualizada',
                    'texto' => 'La categoría se actualizó correctamente'
                ];
                break;

            case 'listar':
                $pagina = isset($_POST['pagina']) ? intval($_POST['pagina']) : 1;
                $registros = isset($_POST['registros']) ? intval($_POST['registros']) : 10;
                $url = isset($_POST['url']) ? $_POST['url'] : '';
                $busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';
                
                $resultado = $insCategory->listarCategoriaControlador($pagina, $registros, $url, $busqueda);
                echo $resultado;
                exit;
        }

        echo json_encode($response);
    } catch (Exception $e) {
        $response = [
            'tipo' => 'error',
            'icono' => 'error',
            'titulo' => 'Error',
            'texto' => 'Ocurrió un error: ' . $e->getMessage()
        ];
        echo json_encode($response);
    }
} else {
    session_destroy();
    header("Location: ".APP_URL."login/");
}