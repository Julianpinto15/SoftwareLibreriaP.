<?php

	namespace app\controllers;
	use app\models\mainModel;

	class categoryController extends mainModel{

		/*----------  Controlador registrar categoria  ----------*/
		public function registrarCategoriaControlador(){

			# Almacenando datos#
		    $nombre=$this->limpiarCadena($_POST['categoria_nombre']);
		    $ubicacion=$this->limpiarCadena($_POST['categoria_ubicacion']);

		    # Verificando campos obligatorios #
            if($nombre==""){
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
		    if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}",$nombre)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($ubicacion!=""){
		    	if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}",$ubicacion)){
			    	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La UBICACION no coincide con el formato solicitado",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
		    }

		    # Verificando nombre #
		    $check_nombre=$this->ejecutarConsulta("SELECT categoria_nombre FROM categoria WHERE categoria_nombre='$nombre'");
		    if($check_nombre->rowCount()>0){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE ingresado ya se encuentra registrado, por favor elija otro",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }


		    $categoria_datos_reg=[
				[
					"campo_nombre"=>"categoria_nombre",
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				[
					"campo_nombre"=>"categoria_ubicacion",
					"campo_marcador"=>":Ubicacion",
					"campo_valor"=>$ubicacion
				]
			];

			$registrar_categoria=$this->guardarDatos("categoria",$categoria_datos_reg);

			if($registrar_categoria->rowCount()==1){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Categoría registrada",
					"texto"=>"La categoría ".$nombre." se registro con exito",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No se pudo registrar la categoría, por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}


		public function listarCategoriaControlador($pagina,$registros,$url,$busqueda){

    $pagina=$this->limpiarCadena($pagina);
    $registros=$this->limpiarCadena($registros);

    $url=$this->limpiarCadena($url);
    $url=APP_URL.$url."/";

    $busqueda=$this->limpiarCadena($busqueda);
    $tabla="";

    $pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
    $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

    if(isset($busqueda) && $busqueda!=""){

        $consulta_datos="SELECT * FROM categoria WHERE categoria_nombre LIKE '%$busqueda%' OR categoria_ubicacion LIKE '%$busqueda%' ORDER BY categoria_nombre ASC LIMIT $inicio,$registros";

        $consulta_total="SELECT COUNT(categoria_id) FROM categoria WHERE categoria_nombre LIKE '%$busqueda%' OR categoria_ubicacion LIKE '%$busqueda%'";

    }else{

        $consulta_datos="SELECT * FROM categoria ORDER BY categoria_nombre ASC LIMIT $inicio,$registros";

        $consulta_total="SELECT COUNT(categoria_id) FROM categoria";

    }

    $datos = $this->ejecutarConsulta($consulta_datos);
    $datos = $datos->fetchAll();

    $total = $this->ejecutarConsulta($consulta_total);
    $total = (int) $total->fetchColumn();

    $numeroPaginas =ceil($total/$registros);

    $tabla.='
    <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead class="table-dark">
            <tr class="text-center">
                <th class="text-th">Nombre</th>
                <th class="text-th">Ubicación</th>
                <th class="text-th">Opciones</th>
            </tr>
        </thead>
        <tbody>
    ';

    if($total>=1 && $pagina<=$numeroPaginas){
        $contador=$inicio+1;
        $pag_inicio=$inicio+1;
        foreach($datos as $rows){
            $tabla.='
                <tr class="tr-main text-center">
                    <td class="text-td">'.$rows['categoria_nombre'].'</td>
                    <td class="text-td">'.$rows['categoria_ubicacion'].'</td>
                    <td class="text-td">
                        <button class="text-td btn btn-success btn-sm rounded-pill" onclick="abrirModalEditarCategoria({
                            categoria_id: \''.$rows['categoria_id'].'\',
                            categoria_nombre: \''.addslashes($rows['categoria_nombre']).'\',
                            categoria_ubicacion: \''.addslashes($rows['categoria_ubicacion']).'\'
                        })">
                            <i class="bi bi-arrow-repeat"></i>
                            <span class="text-icono">Actualizar</span>
                        </button>
                
                        <button onclick="eliminarCategoria('.$rows['categoria_id'].')" class="text-td btn btn-danger btn-sm rounded-pill">
                            <i class="bi bi-trash"></i>
                            <span class="text-icono">Eliminar</span>
                        </button>
                    </td>
                </tr>
            ';
            $contador++;
        }
        $pag_final=$contador-1;
    }else{
        if($total>=1){
            $tabla.='
                <tr class="text-center">
                    <td colspan="4">
                        <a href="'.$url.'1/" class="btn btn-link rounded-pill mt-4 mb-4">
                            Haga clic acá para recargar el listado
                        </a>
                    </td>
                </tr>
            ';
        }else{
            $tabla.='
                <tr class="text-center">
                    <td colspan="4">
                        No hay registros en el sistema
                    </td>
                </tr>
            ';
        }
    }

    $tabla.='</tbody></table></div>';

			### Paginacion ###
			if($total>0 && $pagina<=$numeroPaginas){
				$tabla.='<p class="text-end">Mostrando categorías <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';

				$tabla.=$this->paginadorTablas($pagina,$numeroPaginas,$url,7);
			}

			return $tabla;
		}


		/*----------  Controlador eliminar categoria  ----------*/
		public function eliminarCategoriaControlador(){

			$id=$this->limpiarCadena($_POST['categoria_id']);

			# Verificando categoria #
		    $datos=$this->ejecutarConsulta("SELECT * FROM categoria WHERE categoria_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la categoría en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Verificando productos #
		    $check_productos=$this->ejecutarConsulta("SELECT categoria_id FROM producto WHERE categoria_id='$id' LIMIT 1");
		    if($check_productos->rowCount()>0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos eliminar la categoría del sistema ya que tiene productos asociados",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    $eliminarCategoria=$this->eliminarRegistro("categoria","categoria_id",$id);

		    if($eliminarCategoria->rowCount()==1){

		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Categoría eliminada",
					"texto"=>"La categoría ".$datos['categoria_nombre']." ha sido eliminada del sistema correctamente",
					"icono"=>"success"
				];

		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido eliminar la categoría ".$datos['categoria_nombre']." del sistema, por favor intente nuevamente",
					"icono"=>"error"
				];
		    }

		    return json_encode($alerta);
		}


		/*----------  Controlador actualizar categoria  ----------*/
		public function actualizarCategoriaControlador(){

			$id=$this->limpiarCadena($_POST['categoria_id']);

			# Verificando categoria #
		    $datos=$this->ejecutarConsulta("SELECT * FROM categoria WHERE categoria_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la categoría en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Almacenando datos#
		    $nombre=$this->limpiarCadena($_POST['categoria_nombre']);
		    $ubicacion=$this->limpiarCadena($_POST['categoria_ubicacion']);

		    # Verificando campos obligatorios #
            if($nombre==""){
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
		    if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}",$nombre)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($ubicacion!=""){
		    	if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}",$ubicacion)){
			    	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La UBICACION no coincide con el formato solicitado",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
		    }

		    # Verificando nombre #
		    if($datos['categoria_nombre']!=$nombre){
			    $check_nombre=$this->ejecutarConsulta("SELECT categoria_nombre FROM categoria WHERE categoria_nombre='$nombre'");
			    if($check_nombre->rowCount()>0){
			    	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"El NOMBRE ingresado ya se encuentra registrado, por favor elija otro",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
		    }


		    $categoria_datos_up=[
				[
					"campo_nombre"=>"categoria_nombre",
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				[
					"campo_nombre"=>"categoria_ubicacion",
					"campo_marcador"=>":Ubicacion",
					"campo_valor"=>$ubicacion
				]
			];

			$condicion=[
				"condicion_campo"=>"categoria_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("categoria",$categoria_datos_up,$condicion)){
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Categoría actualizada",
					"texto"=>"Los datos de la categoría ".$datos['categoria_nombre']." se actualizaron correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido actualizar los datos de la categoría ".$datos['categoria_nombre'].", por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}

	}