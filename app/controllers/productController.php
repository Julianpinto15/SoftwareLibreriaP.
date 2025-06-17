<?php

	namespace app\controllers;
	use app\models\mainModel;

	class productController extends mainModel{

		/*----------  Controlador registrar producto  ----------*/
		public function registrarProductoControlador(){
			# Almacenando datos#
		    $codigo=$this->limpiarCadena($_POST['producto_codigo']);
		    $nombre=$this->limpiarCadena($_POST['producto_nombre']);
		    $precio_compra=$this->limpiarCadena($_POST['producto_precio_compra']);
		    $precio_venta=$this->limpiarCadena($_POST['producto_precio_venta']);
		    $stock=$this->limpiarCadena($_POST['producto_stock']);
		    $marca=$this->limpiarCadena($_POST['producto_marca']);
		    $modelo=$this->limpiarCadena($_POST['producto_modelo']);
		    $unidad=$this->limpiarCadena($_POST['producto_unidad']);
		    $categoria=$this->limpiarCadena($_POST['producto_categoria']);
			$subcategoria=$this->limpiarCadena($_POST['producto_subcategoria']);
			$autor = isset($_POST['idAutor']) ? $this->limpiarCadena($_POST['idAutor']) : "";
			$editorial = isset($_POST['editorial_id']) ? $this->limpiarCadena($_POST['editorial_id']) : "";

		    # Verificando campos obligatorios #
            if($codigo=="" || $nombre=="" || $precio_compra=="" || $precio_venta=="" || $stock==""){
            	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }

            # Verificando integridad de los datos #
		    if($this->verificarDatos("[a-zA-Z0-9- ]{1,77}",$codigo)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El CODIGO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,100}",$nombre)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[0-9.]{1,25}",$precio_compra)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El PRECIO DE COMPRA no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[0-9.]{1,25}",$precio_venta)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El PRECIO DE VENTA no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[0-9]{1,22}",$stock)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El STOCK O EXISTENCIAS no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($marca!=""){
		    	if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,30}",$marca)){
			    	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La MARCA no coincide con el formato solicitado",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
		    }

		    if($modelo!=""){
		    	if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,30}",$modelo)){
			    	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"El MODELO no coincide con el formato solicitado",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
		    }

		    # Comprobando presentacion del producto #
			if(!in_array($unidad, PRODUCTO_UNIDAD)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"La PRESENTACION DEL PRODUCTO no es correcta o no la ha seleccionado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			# Verificando categoria #
		    $check_categoria=$this->ejecutarConsulta("SELECT categoria_id FROM categoria WHERE categoria_id='$categoria'");
		    if($check_categoria->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"La categoría seleccionada no existe en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

			# Verificando subcategoria #
			if($subcategoria!=""){
				$check_subcategoria=$this->ejecutarConsulta("SELECT id_subcategoria FROM subcategoria WHERE id_subcategoria='$subcategoria'");
				if($check_subcategoria->rowCount()<=0){
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La subcategoría seleccionada no existe en el sistema",
						"icono"=>"error"
					];
					return json_encode($alerta);
					exit();
				}
			}

			# Verificando autor #
			if(isset($_POST['idAutor']) && $_POST['idAutor']!=""){
				$autor=$this->limpiarCadena($_POST['idAutor']);
				$check_autor=$this->ejecutarConsulta("SELECT idAutor FROM autor WHERE idAutor='$autor'");
				if($check_autor->rowCount()<=0){
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"El autor seleccionado no existe en el sistema",
						"icono"=>"error"
					];
					return json_encode($alerta);
					exit();
				}
			} else {
				$autor = "";  // Si no se selecciona autor
			}

			# Verificando editorial #
			if(isset($_POST['editorial_id']) && $_POST['editorial_id']!=""){
				$editorial=$this->limpiarCadena($_POST['editorial_id']);
				$check_editorial=$this->ejecutarConsulta("SELECT idEditorial FROM editorial WHERE idEditorial='$editorial'");
				if($check_editorial->rowCount()<=0){
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La editorial seleccionada no existe en el sistema",
						"icono"=>"error"
					];
					return json_encode($alerta);
					exit();
				}
			} else {
				$editorial = "";  // Si no se selecciona editorial
			}

		    # Verificando stock total o existencias #
            if($stock<=0){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No puedes registrar un producto con stock o existencias en 0, debes de agregar al menos una unidad",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }

            # Comprobando precio de compra del producto #
            $precio_compra=number_format($precio_compra,MONEDA_DECIMALES,'.','');
            if($precio_compra<=0){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El PRECIO DE COMPRA no puede ser menor o igual a 0",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }

            # Comprobando precio de venta del producto #
            $precio_venta=number_format($precio_venta,MONEDA_DECIMALES,'.','');
            if($precio_venta<=0){
                $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El PRECIO DE VENTA no puede ser menor o igual a 0",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			# Comprobando precio de compra y venta del producto #
			if($precio_compra>$precio_venta){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El precio de compra del producto no puede ser mayor al precio de venta",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			# Comprobando codigo de producto #
		    $check_codigo=$this->ejecutarConsulta("SELECT producto_codigo FROM producto WHERE producto_codigo='$codigo'");
		    if($check_codigo->rowCount()>=1){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El código de producto que ha ingresado ya se encuentra registrado en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Comprobando nombre de producto #
		    $check_nombre=$this->ejecutarConsulta("SELECT producto_nombre FROM producto WHERE producto_codigo='$codigo' AND producto_nombre='$nombre'");
		    if($check_nombre->rowCount()>=1){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Ya existe un producto registrado con el mismo nombre y código de barras",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Directorios de imagenes #
			$img_dir='../views/productos/';

			# Comprobar si se selecciono una imagen #
    		if($_FILES['producto_foto']['name']!="" && $_FILES['producto_foto']['size']>0){

    			# Creando directorio #
		        if(!file_exists($img_dir)){
		            if(!mkdir($img_dir,0777)){
		            	$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error inesperado",
							"texto"=>"Error al crear el directorio",
							"icono"=>"error"
						];
						return json_encode($alerta);
		                exit();
		            } 
		        }

		        # Verificando formato de imagenes #
		        if(mime_content_type($_FILES['producto_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['producto_foto']['tmp_name'])!="image/png"){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La imagen que ha seleccionado es de un formato no permitido",
						"icono"=>"error"
					];
					return json_encode($alerta);
		            exit();
		        }

		        # Verificando peso de imagen #
		        if(($_FILES['producto_foto']['size']/1024)>5120){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La imagen que ha seleccionado supera el peso permitido",
						"icono"=>"error"
					];
					return json_encode($alerta);
		            exit();
		        }

		        # Nombre de la foto #
		        $foto=$codigo."_".rand(0,100);

		        # Extension de la imagen #
		        switch(mime_content_type($_FILES['producto_foto']['tmp_name'])){
		            case 'image/jpeg':
		                $foto=$foto.".jpg";
		            break;
		            case 'image/png':
		                $foto=$foto.".png";
		            break;
		        }

		        chmod($img_dir,0777);

		        # Moviendo imagen al directorio #
		        if(!move_uploaded_file($_FILES['producto_foto']['tmp_name'],$img_dir.$foto)){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"No podemos subir la imagen al sistema en este momento",
						"icono"=>"error"
					];
					return json_encode($alerta);
		            exit();
		        }

    		}else{
    			$foto="";
    		}

    		$producto_datos_reg=[
				[
					"campo_nombre"=>"producto_codigo",
					"campo_marcador"=>":Codigo",
					"campo_valor"=>$codigo
				],
				[
					"campo_nombre"=>"producto_nombre",
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				[
					"campo_nombre"=>"producto_stock_total",
					"campo_marcador"=>":Stock",
					"campo_valor"=>$stock
				],
				[
					"campo_nombre"=>"producto_tipo_unidad",
					"campo_marcador"=>":Unidad",
					"campo_valor"=>$unidad
				],
				[
					"campo_nombre"=>"producto_precio_compra",
					"campo_marcador"=>":PrecioCompra",
					"campo_valor"=>$precio_compra
				],
				[
					"campo_nombre"=>"producto_precio_venta",
					"campo_marcador"=>":PrecioVenta",
					"campo_valor"=>$precio_venta
				],
				[
					"campo_nombre"=>"producto_marca",
					"campo_marcador"=>":Marca",
					"campo_valor"=>$marca
				],
				[
					"campo_nombre"=>"producto_modelo",
					"campo_marcador"=>":Modelo",
					"campo_valor"=>$modelo
				],
				[
					"campo_nombre"=>"producto_estado",
					"campo_marcador"=>":Estado",
					"campo_valor"=>"Habilitado"
				],
				[
					"campo_nombre"=>"producto_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				],
				[
					"campo_nombre"=>"categoria_id",
					"campo_marcador"=>":Categoria",
					"campo_valor"=>$categoria
				],

				[
					"campo_nombre"=>"id_subcategoria",
					"campo_marcador"=>":Subcategoria",
					"campo_valor"=>$subcategoria
				],

				[
					"campo_nombre"=>"idAutor",
					"campo_marcador"=>":Autor",
					"campo_valor"=>$autor
				],
				[
					"campo_nombre"=>"idEditorial",
					"campo_marcador"=>":Editorial",
					"campo_valor"=>$editorial
				]
				];
			

			$registrar_producto=$this->guardarDatos("producto",$producto_datos_reg);

			if($registrar_producto->rowCount()==1){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Producto registrado",
					"texto"=>"El producto ".$nombre." se registro con exito",
					"icono"=>"success"
				];
			}else{
				
				if(is_file($img_dir.$foto)){
		            chmod($img_dir.$foto,0777);
		            unlink($img_dir.$foto);
		        }

				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No se pudo registrar el producto, por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}


		/*----------  Controlador listar producto  ----------*/
		public function listarProductoControlador($pagina, $registros, $url, $busqueda, $categoria, $subcategoria, $autor, $editorial) {
			// Limpiar y validar datos
		$pagina = $this->limpiarCadena($pagina);
		$registros = $this->limpiarCadena($registros);
		$categoria = $this->limpiarCadena($categoria);
		$subcategoria = $this->limpiarCadena($subcategoria);
		$autor = $this->limpiarCadena($autor);
		$editorial = $this->limpiarCadena($editorial);
		$url = $this->limpiarCadena($url);
		$busqueda = $this->limpiarCadena($busqueda);
	
		// Construir URL base
		$url = ($categoria > 0) ? APP_URL . $url . "/" . $categoria . "/" : APP_URL . $url . "/";
	
		// Calcular paginación
		$pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
		$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
	
		// Campos a seleccionar
		$campos = "producto.producto_id, producto.producto_codigo, producto.producto_nombre, 
		producto.producto_stock_total, producto.producto_tipo_unidad, 
		producto.producto_precio_compra, producto.producto_precio_venta, 
		producto.producto_marca, producto.producto_modelo, producto.producto_estado, 
		producto.producto_foto, 
		categoria.categoria_id, categoria.categoria_nombre, 
		subcategoria.id_subcategoria, IFNULL(subcategoria.nombre, 'Sin subcategoría') AS subcategoria_nombre, 
		autor.idAutor, IFNULL(autor.nombre, 'Sin autor') AS autor_nombre, 
		editorial.idEditorial, IFNULL(editorial.nombre, 'Sin editorial') AS editorial_nombre";
	
		// Consulta base
		$baseQuery = "FROM producto 
					  INNER JOIN categoria ON producto.categoria_id = categoria.categoria_id 
					  LEFT JOIN subcategoria ON producto.id_subcategoria = subcategoria.id_subcategoria 
					  LEFT JOIN autor ON producto.idAutor = autor.idAutor 
					  LEFT JOIN editorial ON producto.idEditorial = editorial.idEditorial";
	
		// Construir condiciones WHERE
		$whereConditions = [];
		if (!empty($busqueda)) {
			$whereConditions[] = "(producto.producto_codigo LIKE '%$busqueda%' OR producto.producto_nombre LIKE '%$busqueda%')";
		}
		if ($categoria > 0) {
			$whereConditions[] = "producto.categoria_id = '$categoria'";
		}
		if ($subcategoria > 0) {
			$whereConditions[] = "producto.id_subcategoria = '$subcategoria'";
		}
		if ($autor > 0) {
			$whereConditions[] = "producto.idAutor = '$autor'";
		}
		if ($editorial > 0) {
			$whereConditions[] = "producto.idEditorial = '$editorial'";
		}
	
		// Combinar condiciones WHERE
		$whereClause = !empty($whereConditions) ? "WHERE " . implode(" AND ", $whereConditions) : "";
	
		// Consulta para obtener datos
		$consulta_datos = "SELECT $campos $baseQuery $whereClause ORDER BY producto.producto_nombre ASC LIMIT $inicio, $registros";
	
		// Consulta para contar el total de registros
		$consulta_total = "SELECT COUNT(producto.producto_id) $baseQuery $whereClause";
	
		// Ejecutar consultas
		$datos = $this->ejecutarConsulta($consulta_datos)->fetchAll();
		$total = (int) $this->ejecutarConsulta($consulta_total)->fetchColumn();
		$numeroPaginas = ceil($total / $registros);
	
		// Iniciar la tabla
		$tabla = '
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<thead class="table-dark">
					<tr class="text-center">
						<th class="text-th">Codigo</th>
						<th class="text-th">Nombre</th>
						<th class="text-th">Precio C.</th>
						<th class="text-th">Precio V. </th>
						<th class="text-th">Stk.</th>
						<th class="text-th">Tipo.</th>
						<th class="text-th">Prov.</th>
						<th class="text-th">Tel.</th>
						<th class="text-th">Cat.</th>
						<th class="text-th">Subcat.</th>
						<th class="text-th">Autor.</th>
						<th class="text-th">Ed.</th>
						<th class="text-th">Img.</th>
						<th class="text-th">Menú</th>
					</tr>
				</thead>
				<tbody>
		';
	
		if ($total >= 1 && $pagina <= $numeroPaginas) {
			$contador = 1; // Inicializar contador
			$pag_inicio = $contador; // Inicializar valor de pag_inicio
			foreach ($datos as $rows) {
				$tabla .= '
				<tr class="tr-main text-center">
					<td class="text-td">' . $rows['producto_codigo'] . '</td>
					<td class="text-td">' . $rows['producto_nombre'] . '</td>
					<td class="text-td">$' . number_format($rows['producto_precio_compra'], 2) . '</td>
					<td class="text-td">$' . number_format($rows['producto_precio_venta'], 2) . '</td>
					<td class="text-td">' . $rows['producto_stock_total'] . '</td>
					<td class="text-td">' . $rows['producto_tipo_unidad'] . '</td>
					<td class="text-td">' . $rows['producto_marca'] . '</td>
					<td class="text-td">' . $rows['producto_modelo'] . '</td>
					<td class="text-td">' . $rows['categoria_nombre'] . '</td>
					<td class="text-td">' . $rows['subcategoria_nombre'] . '</td>
					<td class="text-td">' . $rows['autor_nombre'] . '</td>
					<td class="text-td">' . $rows['editorial_nombre'] . '</td>
					<td class="text-td">
						<img src="' . APP_URL . 'app/views/productos/' . (!empty($rows['producto_foto']) ? $rows['producto_foto'] : 'default.png') . '" width="50">
					</td>
					<td class="text-td">
						<button class="btn btn-success btn-sm rounded-pill" onclick="abrirModalEditarProducto({
						  	producto_id: \'' . $rows['producto_id'] . '\',
							producto_codigo: \'' . $rows['producto_codigo'] . '\',
							producto_nombre: \'' . addslashes($rows['producto_nombre']) . '\',
							producto_precio_compra: \'' . $rows['producto_precio_compra'] . '\',
							producto_precio_venta: \'' . $rows['producto_precio_venta'] . '\',
							producto_stock_total: \'' . $rows['producto_stock_total'] . '\',
							producto_tipo_unidad: \'' . $rows['producto_tipo_unidad'] . '\',
							producto_marca: \'' . $rows['producto_marca'] . '\',
							producto_modelo: \'' . $rows['producto_modelo'] . '\',
							categoria_id: \'' . $rows['categoria_id'] . '\',
							categoria_nombre: \'' . $rows['categoria_nombre'] . '\',
							id_subcategoria: \'' . $rows['id_subcategoria'] . '\',
							subcategoria_nombre: \'' . $rows['subcategoria_nombre'] . '\',
							idAutor: \'' . $rows['idAutor'] . '\',
							autor_nombre: \'' . $rows['autor_nombre'] . '\',
							idEditorial: \'' . $rows['idEditorial'] . '\',
							editorial_nombre: \'' . $rows['editorial_nombre'] . '\',
							producto_foto: \'' . $rows['producto_foto'] . '\'
						})">
							<i class="bi bi-arrow-repeat"></i> 
						</button>
						<button onclick="eliminarProducto(' . $rows['producto_id'] . ')" class="btn btn-danger btn-sm rounded-pill">
							<i class="bi bi-trash"></i> 
						</button>
					</td>
				</tr>';
				$contador++;
			}
			$pag_final = $contador - 1;
		} else {
			if ($total >= 1) {
				$tabla .= '
				<tr class="has-text-centered text-td">
					<td colspan="14">
						<a href="' . $url . '1/" class="btn btn-link">
							Haga clic acá para recargar el listado
						</a>
					</td>
				</tr>
				';
			} else {
				$tabla .= '
				<tr class="has-text-centered text-td">
					<td colspan="14">
						No hay productos registrados con los filtros seleccionados
					</td>
				</tr>
				';
			}
		}
	
		$tabla .= '</tbody></table></div>';
	
		// Paginación
		if ($total > 0 && $pagina <= $numeroPaginas) {
			$tabla .= '<p class="has-text-right">Mostrando productos <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
			$tabla .= $this->paginadorTablas($pagina, $numeroPaginas, $url, 7);
		}
	
		return $tabla;
	}
		


		/*----------  Controlador eliminar producto  ----------*/
		public function eliminarProductoControlador(){

			$id=$this->limpiarCadena($_POST['producto_id']);

			# Verificando producto #
		    $datos=$this->ejecutarConsulta("SELECT * FROM producto WHERE producto_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el producto en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Verificando ventas #
		    $check_ventas=$this->ejecutarConsulta("SELECT producto_id FROM venta_detalle WHERE producto_id='$id' LIMIT 1");
		    if($check_ventas->rowCount()>0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos eliminar el producto del sistema ya que tiene ventas asociadas",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    $eliminarProducto=$this->eliminarRegistro("producto","producto_id",$id);

		    if($eliminarProducto->rowCount()==1){

		    	if(is_file("../views/productos/".$datos['producto_foto'])){
		            chmod("../views/productos/".$datos['producto_foto'],0777);
		            unlink("../views/productos/".$datos['producto_foto']);
		        }

		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Producto eliminado",
					"texto"=>"El producto '".$datos['producto_nombre']."' ha sido eliminado del sistema correctamente",
					"icono"=>"success"
				];

		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido eliminar el producto '".$datos['producto_nombre']."' del sistema, por favor intente nuevamente",
					"icono"=>"error"
				];
		    }

		    return json_encode($alerta);
		}


		/*----------  Controlador actualizar producto  ----------*/
		public function actualizarProductoControlador(){
			$id = $this->limpiarCadena($_POST['producto_id']);
		
			// Verificar si el producto existe
			$datos = $this->ejecutarConsulta("SELECT * FROM producto WHERE producto_id='$id'");
			if($datos->rowCount() <= 0){
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "No hemos encontrado el producto en el sistema",
					"icono" => "error"
				];
				return json_encode($alerta);
				exit();
			} else {
				$datos = $datos->fetch();
			}
		
			// Almacenar datos del formulario
			$codigo = $this->limpiarCadena($_POST['producto_codigo']);
			$nombre = $this->limpiarCadena($_POST['producto_nombre']);
			$precio_compra = $this->limpiarCadena($_POST['producto_precio_compra']);
			$precio_venta = $this->limpiarCadena($_POST['producto_precio_venta']);
			$stock = $this->limpiarCadena($_POST['producto_stock']);
			$marca = $this->limpiarCadena($_POST['producto_marca']);
			$modelo = $this->limpiarCadena($_POST['producto_modelo']);
			$unidad = $this->limpiarCadena($_POST['producto_unidad']);
			$categoria = $this->limpiarCadena($_POST['producto_categoria']);
			$subcategoria = $this->limpiarCadena($_POST['producto_subcategoria']);
			$autor = isset($_POST['idAutor']) ? $this->limpiarCadena($_POST['idAutor']) : "";
			$editorial = isset($_POST['editorial_id']) ? $this->limpiarCadena($_POST['editorial_id']) : "";
			$foto_actual = $this->limpiarCadena($_POST['producto_foto_actual']);
    
  			 // Verificar existencia del producto
			$check_producto = $this->ejecutarConsulta("SELECT * FROM producto WHERE producto_id='$id'");
			if($check_producto->rowCount()<=0){
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Error",
					"texto" => "El producto no existe en la base de datos",
					"icono" => "error"
				];
				return json_encode($alerta);
			}

		    # Verificando campos obligatorios #
            if($codigo=="" || $nombre=="" || $precio_compra=="" || $precio_venta=="" || $stock==""){
            	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }

            # Verificando integridad de los datos #
		    if($this->verificarDatos("[a-zA-Z0-9- ]{1,77}",$codigo)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El CODIGO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,100}",$nombre)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[0-9.]{1,25}",$precio_compra)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El PRECIO DE COMPRA no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[0-9.]{1,25}",$precio_venta)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El PRECIO DE VENTA no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[0-9]{1,22}",$stock)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El STOCK O EXISTENCIAS no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($marca!=""){
		    	if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,30}",$marca)){
			    	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La MARCA no coincide con el formato solicitado",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
		    }

		    if($modelo!=""){
		    	if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,30}",$modelo)){
			    	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"El MODELO no coincide con el formato solicitado",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
		    }

		    # Comprobando presentacion del producto #
			if(!in_array($unidad, PRODUCTO_UNIDAD)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"La PRESENTACION DEL PRODUCTO no es correcta o no la ha seleccionado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			# Verificando categoria #
			if($datos['categoria_id']!=$categoria){
			    $check_categoria=$this->ejecutarConsulta("SELECT categoria_id FROM categoria WHERE categoria_id='$categoria'");
			    if($check_categoria->rowCount()<=0){
			        $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La categoría seleccionada no existe en el sistema",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
			}

			# Verificando subcategoria #
		if($subcategoria>0){
			$check_subcategoria=$this->ejecutarConsulta("SELECT id_subcategoria FROM subcategoria WHERE id_subcategoria='$subcategoria'");
			if($check_subcategoria->rowCount()<=0){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado", 
					"texto"=>"La subcategoría seleccionada no existe en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}
		}

					# Verificando autor #
			if(isset($_POST['idAutor']) && $_POST['idAutor']!=""){
				$autor=$this->limpiarCadena($_POST['idAutor']);
				if($datos['idAutor']!=$autor){
					$check_autor=$this->ejecutarConsulta("SELECT idAutor FROM autor WHERE idAutor='$autor'");
					if($check_autor->rowCount()<=0){
						$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error inesperado",
							"texto"=>"El autor seleccionado no existe en el sistema",
							"icono"=>"error"
						];
						return json_encode($alerta);
						exit();
					}
				}
			} else {
				$autor = "";
			}

			# Verificando editorial #
			if(isset($_POST['editorial_id']) && $_POST['editorial_id']!=""){
				$editorial=$this->limpiarCadena($_POST['editorial_id']);
				if($datos['idEditorial']!=$editorial){
					$check_editorial=$this->ejecutarConsulta("SELECT idEditorial FROM editorial WHERE idEditorial='$editorial'");
					if($check_editorial->rowCount()<=0){
						$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error inesperado",
							"texto"=>"La editorial seleccionada no existe en el sistema",
							"icono"=>"error"
						];
						return json_encode($alerta);
						exit();
					}
				}
			} else {
				$editorial = "";
			}

		    # Verificando stock total o existencias #
            if($stock<=0){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No puedes registrar un producto con stock o existencias en 0, debes de agregar al menos una unidad",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }

            # Comprobando precio de compra del producto #
            $precio_compra=number_format($precio_compra,MONEDA_DECIMALES,'.','');
            if($precio_compra<=0){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El PRECIO DE COMPRA no puede ser menor o igual a 0",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }

            # Comprobando precio de venta del producto #
            $precio_venta=number_format($precio_venta,MONEDA_DECIMALES,'.','');
            if($precio_venta<=0){
                $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El PRECIO DE VENTA no puede ser menor o igual a 0",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			# Comprobando precio de compra y venta del producto #
			if($precio_compra>$precio_venta){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El precio de compra del producto no puede ser mayor al precio de venta",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			# Comprobando codigo de producto #
			if($datos['producto_codigo']!=$codigo){
			    $check_codigo=$this->ejecutarConsulta("SELECT producto_codigo FROM producto WHERE producto_codigo='$codigo'");
			    if($check_codigo->rowCount()>=1){
			        $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"El código de producto que ha ingresado ya se encuentra registrado en el sistema",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
			}

		    # Comprobando nombre de producto #
		    if($datos['producto_nombre']!=$nombre){
			    $check_nombre=$this->ejecutarConsulta("SELECT producto_nombre FROM producto WHERE producto_codigo='$codigo' AND producto_nombre='$nombre'");
			    if($check_nombre->rowCount()>=1){
			        $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Ya existe un producto registrado con el mismo nombre y código de barras",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
		    }

    // Actualizar los datos del producto
    $producto_datos_up = [
        [
            "campo_nombre" => "producto_codigo",
            "campo_marcador" => ":Codigo",
            "campo_valor" => $codigo
        ],
        [
            "campo_nombre" => "producto_nombre",
            "campo_marcador" => ":Nombre",
            "campo_valor" => $nombre
        ],
        [
            "campo_nombre" => "producto_stock_total",
            "campo_marcador" => ":Stock",
            "campo_valor" => $stock
        ],
        [
            "campo_nombre" => "producto_tipo_unidad",
            "campo_marcador" => ":Unidad",
            "campo_valor" => $unidad
        ],
        [
            "campo_nombre" => "producto_precio_compra",
            "campo_marcador" => ":PrecioCompra",
            "campo_valor" => $precio_compra
        ],
        [
            "campo_nombre" => "producto_precio_venta",
            "campo_marcador" => ":PrecioVenta",
            "campo_valor" => $precio_venta
        ],
        [
            "campo_nombre" => "producto_marca",
            "campo_marcador" => ":Marca",
            "campo_valor" => $marca
        ],
        [
            "campo_nombre" => "producto_modelo",
            "campo_marcador" => ":Modelo",
            "campo_valor" => $modelo
        ],
        [
            "campo_nombre" => "categoria_id",
            "campo_marcador" => ":Categoria",
            "campo_valor" => $categoria
        ],
        [
            "campo_nombre" => "id_subcategoria",
            "campo_marcador" => ":Subcategoria",
            "campo_valor" => $subcategoria
        ],
        [
            "campo_nombre" => "idAutor",
            "campo_marcador" => ":Autor",
            "campo_valor" => $autor
        ],
        [
            "campo_nombre" => "idEditorial",
            "campo_marcador" => ":Editorial",
            "campo_valor" => $editorial
        ]
    ];

    $condicion = [
        "condicion_campo" => "producto_id",
        "condicion_marcador" => ":ID",
        "condicion_valor" => $id
    ];

    if($this->actualizarDatos("producto", $producto_datos_up, $condicion)){
        $alerta = [
            "tipo" => "recargar",
            "titulo" => "Producto actualizado",
            "texto" => "Los datos del producto '".$datos['producto_nombre']."' se actualizaron correctamente",
            "icono" => "success"
        ];
    } else {
        $alerta = [
            "tipo" => "simple",
            "titulo" => "Ocurrió un error inesperado",
            "texto" => "No hemos podido actualizar los datos del producto '".$datos['producto_nombre']."', por favor intente nuevamente",
            "icono" => "error"
        ];
    }

    return json_encode($alerta);
}


		/*----------  Controlador eliminar foto producto  ----------*/
		public function eliminarFotoProductoControlador(){

			$id=$this->limpiarCadena($_POST['producto_id']);

			# Verificando producto #
		    $datos=$this->ejecutarConsulta("SELECT * FROM producto WHERE producto_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el producto en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Directorio de imagenes #
    		$img_dir="../views/productos/";

    		chmod($img_dir,0777);

    		if(is_file($img_dir.$datos['producto_foto'])){

		        chmod($img_dir.$datos['producto_foto'],0777);

		        if(!unlink($img_dir.$datos['producto_foto'])){
		            $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Error al intentar eliminar la foto del producto, por favor intente nuevamente",
						"icono"=>"error"
					];
					return json_encode($alerta);
		        	exit();
		        }
		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la foto del producto en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    $producto_datos_up=[
				[
					"campo_nombre"=>"producto_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>""
				]
			];

			$condicion=[
				"condicion_campo"=>"producto_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("producto",$producto_datos_up,$condicion)){
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"La foto del producto '".$datos['producto_nombre']."' se elimino correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"No hemos podido actualizar algunos datos del producto '".$datos['producto_nombre']."', sin embargo la foto ha sido eliminada correctamente",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}

/*----------  Controlador actualizar foto producto  ----------*/
public function actualizarFotoProductoControlador(){

    $id = $this->limpiarCadena($_POST['producto_id']);

    # Verificando producto #
    $datos = $this->ejecutarConsulta("SELECT * FROM producto WHERE producto_id='$id'");
    if ($datos->rowCount() <= 0) {
        $alerta = [
            "tipo" => "simple",
            "titulo" => "Ocurrió un error inesperado",
            "texto" => "No hemos encontrado el producto en el sistema",
            "icono" => "error"
        ];
        return json_encode($alerta);
        exit();
    } else {
        $datos = $datos->fetch();
    }

    # Directorio de imagenes #
    $img_dir = "../views/productos/";

    # Creando directorio #
    if (!file_exists($img_dir)) {
        if (!mkdir($img_dir, 0777)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "Error al crear el directorio",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
    }

    # Inicializar la variable de la foto #
    $foto = $datos['producto_foto']; // Mantener la foto actual por defecto

    # Verificar si se seleccionó una nueva imagen #
    if ($_FILES['producto_foto']['name'] != "" && $_FILES['producto_foto']['size'] > 0) {
        # Verificando formato de imagenes #
        if (mime_content_type($_FILES['producto_foto']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['producto_foto']['tmp_name']) != "image/png") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "La imagen que ha seleccionado es de un formato no permitido",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        # Verificando peso de imagen #
        if (($_FILES['producto_foto']['size'] / 1024) > 5120) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "La imagen que ha seleccionado supera el peso permitido",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        # Nombre de la foto #
        if ($datos['producto_foto'] != "") {
            $foto = explode(".", $datos['producto_foto']);
            $foto = $foto[0];
        } else {
            $foto = $datos['producto_codigo'] . "_" . rand(0, 100);
        }

        # Extension de la imagen #
        switch (mime_content_type($_FILES['producto_foto']['tmp_name'])) {
            case 'image/jpeg':
                $foto = $foto . ".jpg";
                break;
            case 'image/png':
                $foto = $foto . ".png";
                break;
        }

        chmod($img_dir, 0777);

        # Moviendo imagen al directorio #
        if (!move_uploaded_file($_FILES['producto_foto']['tmp_name'], $img_dir . $foto)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No podemos subir la imagen al sistema en este momento",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        # Eliminando imagen anterior #
        if (is_file($img_dir . $datos['producto_foto']) && $datos['producto_foto'] != $foto) {
            chmod($img_dir . $datos['producto_foto'], 0777);
            unlink($img_dir . $datos['producto_foto']);
        }
    }

    # Actualizar la foto en la base de datos #
    $producto_datos_up = [
        [
            "campo_nombre" => "producto_foto",
            "campo_marcador" => ":Foto",
            "campo_valor" => $foto
        ]
    ];

    $condicion = [
        "condicion_campo" => "producto_id",
        "condicion_marcador" => ":ID",
        "condicion_valor" => $id
    ];

    if ($this->actualizarDatos("producto", $producto_datos_up, $condicion)) {
        $alerta = [
            "tipo" => "recargar",
            "titulo" => "Foto actualizada",
            "texto" => "La foto del producto '" . $datos['producto_nombre'] . "' se actualizó correctamente",
            "icono" => "success"
        ];
    } else {
        $alerta = [
            "tipo" => "recargar",
            "titulo" => "Foto actualizada",
            "texto" => "No hemos podido actualizar algunos datos del producto '" . $datos['producto_nombre'] . "', sin embargo la foto ha sido actualizada",
            "icono" => "warning"
        ];
    }

    return json_encode($alerta);
}
	}