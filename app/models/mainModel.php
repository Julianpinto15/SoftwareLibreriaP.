<?php
	
	namespace app\models;
	use \PDO;

	if(file_exists(__DIR__."/../../config/server.php")){
		require_once __DIR__."/../../config/server.php";
	}

	class mainModel{

		private $server=DB_SERVER;
		private $db=DB_NAME;
		private $user=DB_USER;
		private $pass=DB_PASS;


		/*----------  Funcion conectar a BD  ----------*/
		protected function conectar(){
			$conexion = new PDO("mysql:host=".$this->server.";dbname=".$this->db,$this->user,$this->pass);
			$conexion->exec("SET CHARACTER SET utf8");
			return $conexion;
		}


		/*----------  Funcion ejecutar consultas  ----------*/
		protected function ejecutarConsulta($consulta){
			$sql=$this->conectar()->prepare($consulta);
			$sql->execute();
			return $sql;
		}


		/*----------  Funcion limpiar cadenas  ----------*/
		public function limpiarCadena($cadena){

			$palabras=["<script>","</script>","<script src","<script type=","SELECT * FROM","SELECT "," SELECT ","DELETE FROM","INSERT INTO","DROP TABLE","DROP DATABASE","TRUNCATE TABLE","SHOW TABLES","SHOW DATABASES","<?php","?>","--","^","<",">","==",";","::"];

			$cadena=trim($cadena);
			$cadena=stripslashes($cadena);

			foreach($palabras as $palabra){
				$cadena=str_ireplace($palabra, "", $cadena);
			}

			$cadena=trim($cadena);
			$cadena=stripslashes($cadena);

			return $cadena;
		}


		/*---------- Funcion verificar datos (expresion regular) ----------*/
		protected function verificarDatos($filtro,$cadena){
			if(preg_match("/^".$filtro."$/", $cadena)){
				return false;
            }else{
                return true;
            }
		}


		/*----------  Funcion para ejecutar una consulta INSERT preparada  ----------*/
		protected function guardarDatos($tabla,$datos){

			$query="INSERT INTO $tabla (";

			$C=0;
			foreach ($datos as $clave){
				if($C>=1){ $query.=","; }
				$query.=$clave["campo_nombre"];
				$C++;
			}
			
			$query.=") VALUES(";

			$C=0;
			foreach ($datos as $clave){
				if($C>=1){ $query.=","; }
				$query.=$clave["campo_marcador"];
				$C++;
			}

			$query.=")";
			$sql=$this->conectar()->prepare($query);

			foreach ($datos as $clave){
				$sql->bindParam($clave["campo_marcador"],$clave["campo_valor"]);
			}

			$sql->execute();

			return $sql;
		}


		/*---------- Funcion seleccionar datos ----------*/
        public function seleccionarDatos($tipo,$tabla,$campo,$id){
			$tipo=$this->limpiarCadena($tipo);
			$tabla=$this->limpiarCadena($tabla);
			$campo=$this->limpiarCadena($campo);
			$id=$this->limpiarCadena($id);

            if($tipo=="Unico"){
                $sql=$this->conectar()->prepare("SELECT * FROM $tabla WHERE $campo=:ID");
                $sql->bindParam(":ID",$id);
            }elseif($tipo=="Normal"){
                $sql=$this->conectar()->prepare("SELECT $campo FROM $tabla");
            }
            $sql->execute();

            return $sql;
		}


		/*----------  Funcion para ejecutar una consulta UPDATE preparada  ----------*/
		protected function actualizarDatos($tabla,$datos,$condicion){

			$query="UPDATE $tabla SET ";

			$C=0;
			foreach ($datos as $clave){
				if($C>=1){ $query.=","; }
				$query.=$clave["campo_nombre"]."=".$clave["campo_marcador"];
				$C++;
			}

			$query.=" WHERE ".$condicion["condicion_campo"]."=".$condicion["condicion_marcador"];

			$sql=$this->conectar()->prepare($query);

			foreach ($datos as $clave){
				$sql->bindParam($clave["campo_marcador"],$clave["campo_valor"]);
			}

			$sql->bindParam($condicion["condicion_marcador"],$condicion["condicion_valor"]);

			$sql->execute();

			return $sql;
		}


		/*---------- Funcion eliminar registro ----------*/
        protected function eliminarRegistro($tabla,$campo,$id){
            $sql=$this->conectar()->prepare("DELETE FROM $tabla WHERE $campo=:id");
            $sql->bindParam(":id",$id);
            $sql->execute();
            
            return $sql;
        }


        /*---------- Funcion el ----------*/
protected function paginadorTablas($pagina, $numeroPaginas, $url, $botones) {
    $tabla = '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';
    
    // Botón Anterior
    if ($pagina <= 1) {
        $tabla .= '
        <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1" aria-disabled="true"><i class="fas fa-arrow-alt-circle-left"></i> &nbsp; Anterior</a>
        </li>';
    } else {
        $tabla .= '
        <li class="page-item">
            <a class="page-link" href="' . $url . ($pagina - 1) . '/"><i class="fas fa-arrow-alt-circle-left"></i> &nbsp; Anterior</a>
        </li>';
    }
    
    // Primera página
    if ($pagina > 2) {
        $tabla .= '<li class="page-item"><a class="page-link" href="' . $url . '1/">1</a></li>';
        
        // Mostrar ellipsis si no estamos cerca del inicio
        if ($pagina > 3) {
            $tabla .= '<li class="page-item disabled"><span class="page-link">&hellip;</span></li>';
        }
    }
    
    // Páginas centrales
    $inicio = max(1, $pagina - floor($botones / 2));
    $fin = min($numeroPaginas, $inicio + $botones - 1);
    
    // Ajuste si alcanzamos el final
    if ($fin == $numeroPaginas) {
        $inicio = max(1, $fin - $botones + 1);
    }
    
    for ($i = $inicio; $i <= $fin; $i++) {
        if ($pagina == $i) {
            $tabla .= '<li class="page-item active" aria-current="page"><a class="page-link" href="' . $url . $i . '/">' . $i . '</a></li>';
        } else {
            $tabla .= '<li class="page-item"><a class="page-link" href="' . $url . $i . '/">' . $i . '</a></li>';
        }
    }
    
    // Última página
    if ($pagina < $numeroPaginas - 1) {
        // Mostrar ellipsis si no estamos cerca del final
        if ($pagina < $numeroPaginas - 2) {
            $tabla .= '<li class="page-item disabled"><span class="page-link">&hellip;</span></li>';
        }
        
        $tabla .= '<li class="page-item"><a class="page-link" href="' . $url . $numeroPaginas . '/">' . $numeroPaginas . '</a></li>';
    }
    
    // Botón Siguiente
    if ($pagina >= $numeroPaginas) {
        $tabla .= '
        <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1" aria-disabled="true"><i class="fas fa-arrow-alt-circle-right"></i> &nbsp; Siguiente</a>
        </li>';
    } else {
        $tabla .= '
        <li class="page-item">
            <a class="page-link" href="' . $url . ($pagina + 1) . '/"><i class="fas fa-arrow-alt-circle-right"></i> &nbsp; Siguiente</a>
        </li>';
    }
    
    $tabla .= '</ul></nav>';
    return $tabla;
}


	    /*----------  Funcion generar select ----------*/
		public function generarSelect($datos,$campo_db){
			$check_select='';
			$text_select='';
			$count_select=1;
			$select='';
			foreach($datos as $row){

				if($campo_db==$row){
					$check_select='selected=""';
					$text_select=' (Actual)';
				}

				$select.='<option value="'.$row.'" '.$check_select.'>'.$count_select.' - '.$row.$text_select.'</option>';

				$check_select='';
				$text_select='';
				$count_select++;
			}
			return $select;
		}

		/*----------  Funcion generar codigos aleatorios  ----------*/
		protected function generarCodigoAleatorio($longitud,$correlativo){
			$codigo="";
			$caracter="Letra";
			for($i=1; $i<=$longitud; $i++){
				if($caracter=="Letra"){
					$letra_aleatoria=chr(rand(ord("a"),ord("z")));
					$letra_aleatoria=strtoupper($letra_aleatoria);
					$codigo.=$letra_aleatoria;
					$caracter="Numero";
				}else{
					$numero_aleatorio=rand(0,9);
					$codigo.=$numero_aleatorio;
					$caracter="Letra";
				}
			}
			return $codigo."-".$correlativo;
		}


		/*----------  Limitar cadenas de texto  ----------*/
		public function limitarCadena($cadena,$limite,$sufijo){
			if(strlen($cadena)>$limite){
				return substr($cadena,0,$limite).$sufijo;
			}else{
				return $cadena;
			}
		}

		
	    /*----------  Función para obtener libros con información del autor  ----------*/
// Función para obtener libros con autor y editorial (uso principal)
public function obtenerLibrosConAutoresYEditoriales() {
    $consulta = "SELECT 
                    i.codigo,
                    i.tituloLibro,
                    a.nombre AS autor, 
                    e.nombre AS editorial,
                    i.anioPublicacion,
                    i.genero,
                    i.precioVenta,
                    i.cantidad,
                    i.formato
                 FROM 
                    inventario i
                 INNER JOIN 
                    autor a
                 ON 
                    i.idAutor = a.idAutor
                 INNER JOIN 
                    editorial e
                 ON 
                    i.idEditorial = e.idEditorial";

    $sql = $this->ejecutarConsulta($consulta);
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}
		/*----------  Función para obtener categorías con subcategorías  ----------*/
			public function obtenerCategoriasConSubcategorias() {
				$consulta = "SELECT 
								c.categoria_id, 
								c.categoria_nombre AS categoria, 
								s.id_subcategoria, 
								s.nombre AS subcategoria
							FROM 
								categoria c
							LEFT JOIN 
								subcategoria s
							ON 
								c.categoria_id = s.categoria_id";

				$sql = $this->ejecutarConsulta($consulta);
				return $sql->fetchAll(PDO::FETCH_ASSOC); // Devuelve los resultados como un array asociativo
			}

		
	}