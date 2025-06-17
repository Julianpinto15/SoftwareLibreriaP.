<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\saleController;

	if(isset($_POST['modulo_venta'])){

		$insVenta = new saleController();

		
		if($_POST['modulo_venta']=="buscar_codigo"){
			echo $insVenta->buscarCodigoVentaControlador();
		}

		
		if($_POST['modulo_venta']=="agregar_producto"){
			echo $insVenta->agregarProductoCarritoControlador();
        }

        
		if($_POST['modulo_venta']=="remover_producto"){
			echo $insVenta->removerProductoCarritoControlador();
		}

		
		if($_POST['modulo_venta']=="actualizar_producto"){
			echo $insVenta->actualizarProductoCarritoControlador();
		}

		
		if($_POST['modulo_venta']=="buscar_cliente"){
			echo $insVenta->buscarClienteVentaControlador();
		}

		
		if($_POST['modulo_venta']=="agregar_cliente"){
			echo $insVenta->agregarClienteVentaControlador();
		}

		
		if($_POST['modulo_venta']=="remover_cliente"){
			echo $insVenta->removerClienteVentaControlador();
		}

		
		if($_POST['modulo_venta']=="registrar_venta"){
			echo $insVenta->registrarVentaControlador();
		}

		
		if($_POST['modulo_venta']=="eliminar_venta"){
			echo $insVenta->eliminarVentaControlador();
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}