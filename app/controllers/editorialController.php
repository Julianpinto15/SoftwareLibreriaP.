<?php

namespace app\controllers;
use app\models\mainModel;

class editorialController extends mainModel {

    /*----------  Controlador registrar editorial  ----------*/
    public function registrarEditorialControlador(){

        # Almacenando datos #
        $codigo = $this->limpiarCadena($_POST['editorial_codigo']);
        $nombre = $this->limpiarCadena($_POST['editorial_nombre']);
        $informacioncontacto = $this->limpiarCadena($_POST['editorial_informacioncontacto']);
        $pais = $this->limpiarCadena($_POST['editorial_pais']);

        # Verificando campos obligatorios #
        if($codigo=="" || $nombre==""){
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
        if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}",$nombre)){
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Ocurrió un error inesperado",
                "texto"=>"El NOMBRE no coincide con el formato solicitado",
                "icono"=>"error"
            ];
            return json_encode($alerta);
            exit();
        }

        # Verificando código único #
        $check_codigo = $this->ejecutarConsulta("SELECT codigo FROM editorial WHERE codigo='$codigo'");
        if($check_codigo->rowCount()>0){
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Ocurrió un error inesperado",
                "texto"=>"El CÓDIGO ingresado ya se encuentra registrado",
                "icono"=>"error"
            ];
            return json_encode($alerta);
            exit();
        }

        $editorial_datos_reg=[
            [
                "campo_nombre"=>"codigo",
                "campo_marcador"=>":Codigo",
                "campo_valor"=>$codigo
            ],
            [
                "campo_nombre"=>"nombre",
                "campo_marcador"=>":Nombre",
                "campo_valor"=>$nombre
            ],
            [
                "campo_nombre"=>"informacioncontacto",
                "campo_marcador"=>":InformacionContacto",
                "campo_valor"=>$informacioncontacto
            ],
            [
                "campo_nombre"=>"pais",
                "campo_marcador"=>":Pais",
                "campo_valor"=>$pais
            ]
        ];

        $registrar_editorial = $this->guardarDatos("editorial", $editorial_datos_reg);

        if($registrar_editorial->rowCount()==1){
            $alerta=[
                "tipo"=>"limpiar",
                "titulo"=>"Editorial registrada",
                "texto"=>"La editorial ".$nombre." se registró con éxito",
                "icono"=>"success"
            ];
        }else{
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Ocurrió un error inesperado",
                "texto"=>"No se pudo registrar la editorial, por favor intente nuevamente",
                "icono"=>"error"
            ];
        }

        return json_encode($alerta);
    }

    /*----------  Controlador listar editorial  ----------*/
    public function listarEditorialControlador($pagina, $registros, $url, $busqueda){
        $pagina = $this->limpiarCadena($pagina);
        $registros = $this->limpiarCadena($registros);
        $url = $this->limpiarCadena($url);
        $url = APP_URL.$url."/";
        $busqueda = $this->limpiarCadena($busqueda);
        $tabla = "";

        $pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
        $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

        $pag_inicio = 0;
        $pag_final = 0;

        if(isset($busqueda) && $busqueda!=""){
            $consulta_datos = "SELECT * FROM editorial WHERE (nombre LIKE '%$busqueda%' OR codigo LIKE '%$busqueda%') ORDER BY nombre ASC LIMIT $inicio,$registros";
            $consulta_total = "SELECT COUNT(idEditorial) FROM editorial WHERE (nombre LIKE '%$busqueda%' OR codigo LIKE '%$busqueda%')";
        }else{
            $consulta_datos = "SELECT * FROM editorial ORDER BY nombre ASC LIMIT $inicio,$registros";
            $consulta_total = "SELECT COUNT(idEditorial) FROM editorial";
        }

        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $total = $this->ejecutarConsulta($consulta_total);
        $total = (int) $total->fetchColumn();

        $numeroPaginas = ceil($total/$registros);

        $tabla.='
        <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-dark">
                <tr class="text-center">
                    <th class="text-th">#</th>
                    <th class="text-th">Código</th>
                    <th class="text-th">Nombre</th>
                    <th class="text-th">País</th>
                    <th class="text-th">Información de Contacto</th>
                    <th class="text-th" colspan="2">Opciones</th>
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
                        <td class="text-td">'.$contador.'</td>
                        <td class="text-td">'.$rows['codigo'].'</td>
                        <td class="text-td">'.$rows['nombre'].'</td>
                        <td class="text-td">'.$rows['pais'].'</td>
                        <td class="text-td">'.$rows['informacioncontacto'].'</td>
                        <td class="text-td">
                            <button class="text-td btn btn-success btn-sm rounded-pill" onclick="abrirModalEditareditorial({
                                idEditorial: \''.$rows['idEditorial'].'\',
                                codigo: \''.$rows['codigo'].'\',
                                nombre: \''.addslashes($rows['nombre']).'\',
                                informacioncontacto: \''.addslashes($rows['informacioncontacto']).'\',
                                pais: \''.addslashes($rows['pais']).'\'
                            })"><i class=" bi bi-arrow-repeat"></i>
                        <span class="text-icono">
                        Actualizar
                        </span>
                        </button>
                        
                            <button onclick="eliminarEditorial('.$rows['idEditorial'].')" class="text-td btn btn-danger btn-sm rounded-pill">
                            <i class="bi bi-trash"></i>
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
                    <tr class="has-text-centered">
                        <td colspan="7">
                            <a href="'.$url.'1/" class="button is-link is-rounded is-small mt-4 mb-4">
                                Haga clic acá para recargar el listado
                            </a>
                        </td>
                    </tr>
                ';
            }else{
                $tabla.='
                    <tr class="has-text-centered">
                        <td colspan="7">
                            No hay registros en el sistema
                        </td>
                    </tr>
                ';
            }
        }

        $tabla.='</tbody></table></div>';

        if($total>0 && $pagina<=$numeroPaginas){
            $tabla.='<p class="text-end">Mostrando editoriales <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
            $tabla.=$this->paginadorTablas($pagina,$numeroPaginas,$url,7);
        }

        return $tabla;
    }

    /*----------  Controlador eliminar editorial  ----------*/
    public function eliminarEditorialControlador(){
        $id = $this->limpiarCadena($_POST['editorial_id']);

        # Verificando editorial #
        $datos = $this->ejecutarConsulta("SELECT * FROM editorial WHERE idEditorial='$id'");
        if($datos->rowCount()<=0){
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Ocurrió un error inesperado",
                "texto"=>"No hemos encontrado la editorial en el sistema",
                "icono"=>"error"
            ];
            return json_encode($alerta);
            exit();
        }

        # Eliminando editorial #
        $eliminar = $this->ejecutarConsulta("DELETE FROM editorial WHERE idEditorial='$id'");
        
        if($eliminar->rowCount()==1){
            $alerta=[
                "tipo"=>"recargar",
                "titulo"=>"Editorial eliminada",
                "texto"=>"La editorial ha sido eliminada exitosamente",
                "icono"=>"success"
            ];
        }else{
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Ocurrió un error inesperado",
                "texto"=>"No se pudo eliminar la editorial, por favor intente nuevamente",
                "icono"=>"error"
            ];
        }

        return json_encode($alerta);
    }

    /*----------  Controlador actualizar editorial  ----------*/
    public function actualizarEditorialControlador(){
        $id = $this->limpiarCadena($_POST['editorial_id']);

        # Verificando editorial #
        $datos = $this->ejecutarConsulta("SELECT * FROM editorial WHERE idEditorial='$id'");
        if($datos->rowCount()<=0){
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Ocurrió un error inesperado",
                "texto"=>"No hemos encontrado la editorial en el sistema",
                "icono"=>"error"
            ];
            return json_encode($alerta);
            exit();
        }else{
            $datos = $datos->fetch();
        }

        # Almacenando datos #
        $codigo = $this->limpiarCadena($_POST['editorial_codigo']);
        $nombre = $this->limpiarCadena($_POST['editorial_nombre']);
        $informacioncontacto = $this->limpiarCadena($_POST['editorial_informacioncontacto']);
        $pais = $this->limpiarCadena($_POST['editorial_pais']);

        # Verificando campos obligatorios #
        if($codigo=="" || $nombre==""){
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Ocurrió un error inesperado",
                "texto"=>"No has llenado todos los campos que son obligatorios",
                "icono"=>"error"
            ];
            return json_encode($alerta);
            exit();
        }

        # Verificando código único #
        if($datos['codigo'] != $codigo){
            $check_codigo = $this->ejecutarConsulta("SELECT codigo FROM editorial WHERE codigo='$codigo'");
            if($check_codigo->rowCount()>0){
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Ocurrió un error inesperado",
                    "texto"=>"El CÓDIGO ingresado ya se encuentra registrado",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }
        }

        $editorial_datos_up=[
            [
                "campo_nombre"=>"codigo",
                "campo_marcador"=>":Codigo",
                "campo_valor"=>$codigo
            ],
            [
                "campo_nombre"=>"nombre",
                "campo_marcador"=>":Nombre",
                "campo_valor"=>$nombre
            ],
            [
                "campo_nombre"=>"informacioncontacto",
                "campo_marcador"=>":InformacionContacto",
                "campo_valor"=>$informacioncontacto
            ],
            [
                "campo_nombre"=>"pais",
                "campo_marcador"=>":Pais",
                "campo_valor"=>$pais
            ]
        ];

        $condicion=[
            "condicion_campo"=>"idEditorial",
            "condicion_marcador"=>":ID",
            "condicion_valor"=>$id
        ];

        if($this->actualizarDatos("editorial",$editorial_datos_up,$condicion)){
            $alerta=[
                "tipo"=>"recargar",
                "titulo"=>"Editorial actualizada",
                "texto"=>"Los datos de la editorial ".$nombre." se actualizaron correctamente",
                "icono"=>"success"
            ];
        }else{
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Ocurrió un error inesperado",
                "texto"=>"No hemos podido actualizar los datos de la editorial ".$nombre.", por favor intente nuevamente",
                "icono"=>"error"
            ];
        }

        return json_encode($alerta);
    }
}