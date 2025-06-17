<?php

	namespace app\controllers;
	use app\models\mainModel;

	class companyController extends mainModel{

		/*----------  Controlador registrar empresa  ----------*/
		public function registrarEmpresaControlador(){

			# Almacenando datos#
		    $nombre=$this->limpiarCadena($_POST['empresa_nombre']);

		    $telefono=$this->limpiarCadena($_POST['empresa_telefono']);
		    $email=$this->limpiarCadena($_POST['empresa_email']);

		    $direccion=$this->limpiarCadena($_POST['empresa_direccion']);

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
		    if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ., ]{4,85}",$nombre)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($telefono!=""){
		    	if($this->verificarDatos("[0-9()+]{8,20}",$telefono)){
			    	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"El TELEFONO no coincide con el formato solicitado",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
		    }

		    if($direccion!=""){
		    	if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,97}",$direccion)){
			    	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La DIRECCION no coincide con el formato solicitado",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
		    }

		    # Verificando email #
		    if($email!=""){
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Ha ingresado un correo electrónico no valido",
						"icono"=>"error"
					];
					return json_encode($alerta);
					exit();
				}
            }

            # Directorio de imagenes #
    		$img_dir="../views/img/";

    		# Comprobar si se selecciono una imagen #
    		if($_FILES['empresa_foto']['name']!="" && $_FILES['empresa_foto']['size']>0){

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
		        if(mime_content_type($_FILES['empresa_foto']['tmp_name'])!="image/png"){
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
		        if(($_FILES['empresa_foto']['size']/1024)>5120){
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
		        $foto=$this->generarCodigoAleatorio(10,rand(0,100));
		        $foto=$foto.".png";

		        chmod($img_dir,0777);

		        # Moviendo imagen al directorio #
		        if(!move_uploaded_file($_FILES['empresa_foto']['tmp_name'],$img_dir.$foto)){
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

            $empresa_datos_reg=[
				[
					"campo_nombre"=>"empresa_nombre",
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				[
					"campo_nombre"=>"empresa_telefono",
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
				],
				[
					"campo_nombre"=>"empresa_email",
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				[
					"campo_nombre"=>"empresa_direccion",
					"campo_marcador"=>":Direccion",
					"campo_valor"=>$direccion
				],
				[
					"campo_nombre"=>"empresa_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				]
			];

			$registrar_empresa=$this->guardarDatos("empresa",$empresa_datos_reg);

			if($registrar_empresa->rowCount()==1){
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Empresa registrada",
					"texto"=>"Los datos de la empresa se registraron con exito",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No se pudo registrar los datos de la empresa, por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}


		/*----------  Controlador actualizar empresa  ----------*/
		public function actualizarEmpresaControlador(){

			$id=$this->limpiarCadena($_POST['empresa_id']);

			# Verificando empresa #
		    $datos=$this->ejecutarConsulta("SELECT * FROM empresa WHERE empresa_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la empresa en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Almacenando datos#
		    $nombre=$this->limpiarCadena($_POST['empresa_nombre']);

		    $telefono=$this->limpiarCadena($_POST['empresa_telefono']);
		    $email=$this->limpiarCadena($_POST['empresa_email']);

		    $direccion=$this->limpiarCadena($_POST['empresa_direccion']);

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
		    if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ., ]{4,85}",$nombre)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($telefono!=""){
		    	if($this->verificarDatos("[0-9()+]{8,20}",$telefono)){
			    	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"El TELEFONO no coincide con el formato solicitado",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
		    }

		    if($direccion!=""){
		    	if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,97}",$direccion)){
			    	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La DIRECCION no coincide con el formato solicitado",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
		    }

		    # Verificando email #
		    if($email!=""){
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Ha ingresado un correo electrónico no valido",
						"icono"=>"error"
					];
					return json_encode($alerta);
					exit();
				}
            }

            $empresa_datos_up=[
				[
					"campo_nombre"=>"empresa_nombre",
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				[
					"campo_nombre"=>"empresa_telefono",
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
				],
				[
					"campo_nombre"=>"empresa_email",
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				[
					"campo_nombre"=>"empresa_direccion",
					"campo_marcador"=>":Direccion",
					"campo_valor"=>$direccion
				]
			];

			$condicion=[
				"condicion_campo"=>"empresa_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("empresa",$empresa_datos_up,$condicion)){
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Empresa actualizada",
					"texto"=>"Los datos de la empresa se actualizaron correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido actualizar los datos de la empresa, por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}


		/*----------  Controlador eliminar foto empresa  ----------*/
		public function eliminarFotoEmpresaControlador(){

			$id=$this->limpiarCadena($_POST['empresa_id']);

			# Verificando empresa #
		    $datos=$this->ejecutarConsulta("SELECT * FROM empresa WHERE empresa_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la empresa en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Directorio de imagenes #
    		$img_dir="../views/img/";

    		chmod($img_dir,0777);

    		if(is_file($img_dir.$datos['empresa_foto'])){

		        chmod($img_dir.$datos['empresa_foto'],0777);

		        if(!unlink($img_dir.$datos['empresa_foto'])){
		            $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Error al intentar eliminar la imagen de la empresa, por favor intente nuevamente",
						"icono"=>"error"
					];
					return json_encode($alerta);
		        	exit();
		        }
		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la imagen de la empresa en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    $empresa_datos_up=[
				[
					"campo_nombre"=>"empresa_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>""
				]
			];

			$condicion=[
				"condicion_campo"=>"empresa_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("empresa",$empresa_datos_up,$condicion)){
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Imagen eliminada",
					"texto"=>"La imagen de la empresa se elimino correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Imagen eliminada",
					"texto"=>"No hemos podido actualizar algunos datos de la empresa, sin embargo la imagen ha sido eliminada correctamente",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}


		/*----------  Controlador actualizar foto empresa  ----------*/
		public function actualizarFotoEmpresaControlador(){

			$id=$this->limpiarCadena($_POST['empresa_id']);

			# Verificando empresa #
		    $datos=$this->ejecutarConsulta("SELECT * FROM empresa WHERE empresa_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la empresa en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Directorio de imagenes #
    		$img_dir="../views/img/";

    		# Comprobar si se selecciono una imagen #
    		if($_FILES['empresa_foto']['name']=="" && $_FILES['empresa_foto']['size']<=0){
    			$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No ha seleccionado una imagen o logo para la empresa",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
    		}

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
	        if(mime_content_type($_FILES['empresa_foto']['tmp_name'])!="image/png"){
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
	        if(($_FILES['empresa_foto']['size']/1024)>5120){
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
	        if($datos['empresa_foto']!=""){
		        $foto=$datos['empresa_foto'];
	        }else{
	        	$foto=$this->generarCodigoAleatorio(10,rand(0,100));
		        $foto=$foto.".png";
	        }

	        chmod($img_dir,0777);

	        # Moviendo imagen al directorio #
	        if(!move_uploaded_file($_FILES['empresa_foto']['tmp_name'],$img_dir.$foto)){
	            $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos subir la imagen al sistema en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
	            exit();
	        }

	        # Eliminando imagen anterior #
	        if(is_file($img_dir.$datos['empresa_foto']) && $datos['empresa_foto']!=$foto){
		        chmod($img_dir.$datos['empresa_foto'], 0777);
		        unlink($img_dir.$datos['empresa_foto']);
		    }

		    $empresa_datos_up=[
				[
					"campo_nombre"=>"empresa_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				]
			];

			$condicion=[
				"condicion_campo"=>"empresa_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("empresa",$empresa_datos_up,$condicion)){
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Logo o imagen actualizada",
					"texto"=>"La imagen o logo de la empresa se actualizo correctamente",
					"icono"=>"success"
				];
			}else{

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Logo o imagen actualizada",
					"texto"=>"No hemos podido actualizar algunos datos de la empresa, sin embargo la imagen o logo ha sido actualizada",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}
	}