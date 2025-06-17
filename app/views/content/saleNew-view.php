<div class="container py-4">
    <?php
        $check_empresa=$insLogin->seleccionarDatos("Normal","empresa LIMIT 1","*",0);

        if($check_empresa->rowCount()==1){
            $check_empresa=$check_empresa->fetch();
    ?>
    <div class="row">
        <div class="col-md-9 pb-4">
            <form class="py-4 barcode-form-custom" id="sale-barcode-form" autocomplete="off">
                <div class="row">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-primary search-btn-custom" data-bs-toggle="modal" data-bs-target="#modal-js-product">
                            <i class="fas fa-search"></i> &nbsp; Buscar producto
                        </button>
                </div>
                <div class="col">
                    <div class="input-group barcode-group-custom">
                        <input class="form-control barcode-input-custom" type="text" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70" autofocus="autofocus" placeholder="Código de barras" id="sale-barcode-input">
                        <button type="submit" class="btn btn-info add-btn-custom">
                            <i class="far fa-check-circle"></i> &nbsp; Agregar producto
                        </button>
                    </div>
                      </div>
                  </div>
              </form>

           <?php
    if(isset($_SESSION['alerta_producto_agregado']) && $_SESSION['alerta_producto_agregado']!=""){
            ?>
        <script>
        Swal.fire({
            toast: true,
            position: "top-end",
            title: 'Producto Agregado',
            text: '<?php echo $_SESSION['alerta_producto_agregado']; ?>',
            icon: 'success',
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false
        });
        </script>
            <?php
                    unset($_SESSION['alerta_producto_agregado']);
                }
                
                if(isset($_SESSION['venta_codigo_factura']) && $_SESSION['venta_codigo_factura']!=""){
            ?>
        <script>
        Swal.fire({
            toast: true,
            position: "top-end",
            title: 'Venta Realizada',
            text: 'La venta se ha realizado correctamente.',
            icon: 'success',
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false
        });
        </script>

        <div class="alert my-2">
            <h4 class="text-center fw-bold">Venta realizada</h4>
            <p class="text-center mb-2">La venta se realizó con éxito. ¿Que desea hacer a continuación?</p>
            <br>
            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        <button type="button" class="text-td btn-registrar btn btn-primary" onclick="print_ticket('<?php echo APP_URL."app/pdf/ticket.php?code=".$_SESSION['venta_codigo_factura']; ?>')">
                            <i class="fas fa-receipt fa-2x"></i> &nbsp;
                            Imprimir ticket de venta
                        </button>
                    </div>
                    <div class="col text-center">
                        <button type="button" class="text-td btn-registrar btn btn-success" onclick="print_invoice('<?php echo APP_URL."app/pdf/invoice.php?code=".$_SESSION['venta_codigo_factura']; ?>')">
                            <i class="fas fa-file-invoice-dollar fa-2x"></i> &nbsp;
                            Imprimir factura de venta
                        </button>
                    </div>
                </div>
            </div>
        </div>
              <?php
                      unset($_SESSION['venta_codigo_factura']);
                  }
              ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th class="text-th">#</th>
                            <th class="text-th">Codigo</th>
                            <th class="text-th">Producto</th>
                            <th class="text-th">Autor</th>
                            <th class="text-th">Cant.</th>
                            <th class="text-th">Precio</th>
                            <th class="text-th">Total</th>
                            <th class="text-th">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($_SESSION['datos_producto_venta']) && count($_SESSION['datos_producto_venta'])>=1){

                                $_SESSION['venta_total']=0;
                                $cc=1;

                                foreach($_SESSION['datos_producto_venta'] as $productos){
                        ?>
                        <tr class="text-center">
                            <td class="text-td"><?php echo $cc; ?></td>
                            <td class="text-td"><?php echo $productos['producto_codigo']; ?></td>
                            <td class="text-td"><?php echo $productos['venta_detalle_descripcion']; ?></td>
                            <td class="text-td"><?php echo $productos['autor']; ?></td>
                            <td class="text-td">
                                <input class="form-control sale_input-cant text-center mx-auto" style="max-width: 80px;" value="<?php echo $productos['venta_detalle_cantidad']; ?>" id="sale_input_<?php echo str_replace(" ", "_", $productos['producto_codigo']); ?>" type="text">
                            </td>
                            <td class="text-td"><?php echo MONEDA_SIMBOLO.number_format($productos['venta_detalle_precio_venta'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)." ".MONEDA_NOMBRE; ?></td>
                            <td class="text-td"><?php echo MONEDA_SIMBOLO.number_format($productos['venta_detalle_total'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)." ".MONEDA_NOMBRE; ?></td>
                            <td class="text-td">
                                <div class="btn-container">
                                    <button type="button" class="btn btn-success btn-sm rounded-circle btn-tamaño" onclick="actualizar_cantidad('#sale_input_<?php echo str_replace(' ', '_', $productos['producto_codigo']); ?>','<?php echo $productos['producto_codigo']; ?>')">
                                        <i class="fas fa-redo-alt"></i>
                                    </button>

                                    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/ventaAjax.php" method="POST" autocomplete="off">
                                        <input type="hidden" name="producto_codigo" value="<?php echo $productos['producto_codigo']; ?>">
                                        <input type="hidden" name="modulo_venta" value="remover_producto">
                                        <button type="submit" class="btn btn-danger btn-sm rounded-circle btn-tamaño" title="Remover producto">
                                            <i class="fas fa-trash-restore"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                        <?php
                                $cc++;
                                $_SESSION['venta_total']+=$productos['venta_detalle_total'];
                            }
                        ?>
                        <tr class="text-td">
                            <td colspan="5"></td>
                            <td class="text-td fw-bold">
                                TOTAL CALCULADO
                            </td>
                            <td class="text-td">
                                <?php echo MONEDA_SIMBOLO.number_format($_SESSION['venta_total'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)." ".MONEDA_NOMBRE; ?>
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <?php
                            }else{
                                $_SESSION['venta_total']=0;
                        ?>
                        <tr class="text-td">
                            <td colspan="8">
                                No hay productos agregados
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-3">
            <h2 class="text-center">Datos de la venta</h2>
            <hr>

            <?php if($_SESSION['venta_total']>0){ ?>
            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/ventaAjax.php" method="POST" autocomplete="off" name="formsale">
                <input type="hidden" name="modulo_venta" value="registrar_venta">
            <?php }else { ?>
            <form name="formsale">
            <?php } ?>

                <div class="mb-3 div-position">
                    <label class="form-label estilo-label">Fecha</label>
                    <input class="form-control estilo-input" type="date" value="<?php echo date("Y-m-d"); ?>" readonly>
                </div>

                <div class="mb-3 div-position">
                    <label class="form-label estilo-label">Caja de ventas <?php echo CAMPO_OBLIGATORIO; ?></label>
                    <select class="form-select estilo-input" name="venta_caja">
                        <?php
                            $datos_cajas=$insLogin->seleccionarDatos("Normal","caja","*",0);

                            while($campos_caja=$datos_cajas->fetch()){
                                if($campos_caja['caja_id']==$_SESSION['caja']){
                                    echo '<option value="'.$campos_caja['caja_id'].'" selected="">Caja No.'.$campos_caja['caja_numero'].' - '.$campos_caja['caja_nombre'].' (Actual)</option>';
                                }else{
                                    echo '<option value="'.$campos_caja['caja_id'].'">Caja No.'.$campos_caja['caja_numero'].' - '.$campos_caja['caja_nombre'].'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>

                <label class="form-label estilo-label ">Cliente</label>
                <?php
                    if(isset($_SESSION['datos_cliente_venta']) && count($_SESSION['datos_cliente_venta'])>=1 && $_SESSION['datos_cliente_venta']['cliente_id']!=1){
                ?>
                <div class="input-group mb-3 div-position">
                    <input class="form-control estilo-input" type="text" readonly id="venta_cliente" value="<?php echo $_SESSION['datos_cliente_venta']['cliente_nombre']." ".$_SESSION['datos_cliente_venta']['cliente_apellido']; ?>">
                    <button class="btn btn-danger" type="button" title="Remove cliente" id="btn_remove_client" onclick="remover_cliente(<?php echo $_SESSION['datos_cliente_venta']['cliente_id']; ?>)">
                        <i class="fas fa-user-times"></i>
                    </button>
                </div>
                <?php 
                    }else{
                        $datos_cliente=$insLogin->seleccionarDatos("Normal","cliente WHERE cliente_id='1'","*",0);
                        if($datos_cliente->rowCount()==1){
                            $datos_cliente=$datos_cliente->fetch();

                            $_SESSION['datos_cliente_venta']=[
                                "cliente_id"=>$datos_cliente['cliente_id'],
                                "cliente_tipo_documento"=>$datos_cliente['cliente_tipo_documento'],
                                "cliente_numero_documento"=>$datos_cliente['cliente_numero_documento'],
                                "cliente_nombre"=>$datos_cliente['cliente_nombre'],
                                "cliente_apellido"=>$datos_cliente['cliente_apellido']
                            ];

                        }else{
                            $_SESSION['datos_cliente_venta']=[
                                "cliente_id"=>1,
                                "cliente_tipo_documento"=>"N/A",
                                "cliente_numero_documento"=>"N/A",
                                "cliente_nombre"=>"Publico",
                                "cliente_apellido"=>"General"
                            ];
                        }
                ?>
                <div class="input-group mb-3 div-position">
                    <input class="form-control estilo-input" type="text" readonly id="venta_cliente" value="<?php echo $_SESSION['datos_cliente_venta']['cliente_nombre']." ".$_SESSION['datos_cliente_venta']['cliente_apellido']; ?>">
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal-js-client" title="Agregar cliente" id="btn_add_client">
                        <i class="fas fa-user-plus"></i>
                    </button>
                </div>
                <?php } ?>

                <div class="mb-3 div-position">
                    <label class="form-label estilo-label">Total pagado por cliente <?php echo CAMPO_OBLIGATORIO; ?></label>
                    <input class="form-control estilo-input" type="text" name="venta_abono" id="venta_abono" value="0.00" pattern="[0-9.]{1,25}" maxlength="25">
                </div>

                <div class="mb-3 div-position">
                    <label class="form-label fs-5 estilo-label">Cambio devuelto a cliente</label>
                    <input class="form-control estilo-input" type="text" id="venta_cambio" value="0.00" readonly>
                </div>

                <h3 class="text-center fw-bold mb-3">
                    <small>TOTAL A PAGAR: <?php echo MONEDA_SIMBOLO.number_format($_SESSION['venta_total'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)." ".MONEDA_NOMBRE; ?></small>
                </h3>

                <?php if($_SESSION['venta_total']>0){ ?>
                <div class="text-center mb-3 div-position">
                    <button type="submit" class="btn search-btn-custom rounded-pill px-4 py-2">
                        <i class="far fa-save me-2"></i>Guardar venta
                    </button>
                </div>

                <?php } ?>
                <p class="text-center pt-4">
                    <small>Los campos marcados con <?php echo CAMPO_OBLIGATORIO; ?> son obligatorios</small>
                </p>
                <input class="estilo-input" type="hidden" value="<?php echo number_format($_SESSION['venta_total'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,""); ?>" id="venta_total_hidden">
            </form>
        </div>
    </div>
    <?php }else{ ?>
        <div class="alert alert-warning">
            <h4 class="alert-heading">¡Ocurrio un error inesperado!</h4>
            <div class="text-center">
                <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                No hemos podio seleccionar algunos datos sobre la empresa<?php if($_SESSION['cargo']=="Administrador"){ ?>, por favor <a href="<?php echo APP_URL; ?>companyNew/" >verifique aquí los datos de la empresa<?php } ?></div>            </div>
        </div>
    <?php } ?>
</div>

<!-- Modal buscar producto -->
<div class="modal fade" id="modal-js-product" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-model_title">
                    <i class="fas fa-search"></i> Buscar Producto
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-model">Nombre, marca o modelo</label>
                    <div class="input-group">
                        <input class="form-control text-model_input" type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" name="input_codigo" id="input_codigo" maxlength="30">
                    </div>
                </div>
                <div class="container" id="tabla_productos"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success text-model" onclick="buscar_codigo()">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal buscar cliente -->
<div class="modal fade" id="modal-js-client" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-model_title">
                    <i class="fas fa-search"></i> Buscar y Agregar Cliente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-model">Documento, Nombre, Apellido o Teléfono</label>
                    <div class="input-group">
                        <input class="form-control text-model_input" type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" name="input_cliente" id="input_cliente" maxlength="30">
                    </div>
                </div>
                <div class="container" id="tabla_clientes"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success text-model" onclick="buscar_cliente()">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    /* Detectar cuando se envia el formulario para agregar producto */
    let sale_form_barcode = document.querySelector("#sale-barcode-form");
    sale_form_barcode.addEventListener('submit', function(event){
        event.preventDefault();
        setTimeout('agregar_producto()',100);
    });


    /* Detectar cuando escanea un codigo en formulario para agregar producto */
    let sale_input_barcode = document.querySelector("#sale-barcode-input");
    sale_input_barcode.addEventListener('paste',function(){
        setTimeout('agregar_producto()',100);
    });


    /* Agregar producto */
    function agregar_producto(){
        let codigo_producto=document.querySelector('#sale-barcode-input').value;

        codigo_producto=codigo_producto.trim();

        if(codigo_producto!=""){
            let datos = new FormData();
            datos.append("producto_codigo", codigo_producto);
            datos.append("modulo_venta", "agregar_producto");

            fetch('<?php echo APP_URL; ?>app/ajax/ventaAjax.php',{
                method: 'POST',
                body: datos
            })
            .then(respuesta => respuesta.json())
            .then(respuesta =>{
                return alertas_ajax(respuesta);
            });

        }else{
            Swal.fire({
                icon: 'error',
                title: 'Ocurrió un error inesperado',
                text: 'Debes de introducir el código del producto',
                confirmButtonText: 'Aceptar'
            });
        }
    }


    /*----------  Buscar codigo  ----------*/
    function buscar_codigo(){
        let input_codigo=document.querySelector('#input_codigo').value;

        input_codigo=input_codigo.trim();

        if(input_codigo!=""){

            let datos = new FormData();
            datos.append("buscar_codigo", input_codigo);
            datos.append("modulo_venta", "buscar_codigo");

            fetch('<?php echo APP_URL; ?>app/ajax/ventaAjax.php',{
                method: 'POST',
                body: datos
            })
            .then(respuesta => respuesta.text())
            .then(respuesta =>{
                let tabla_productos=document.querySelector('#tabla_productos');
                tabla_productos.innerHTML=respuesta;
            });

        }else{
            Swal.fire({
                icon: 'error',
                title: 'Ocurrió un error inesperado',
                text: 'Debes de introducir el Nombre, Marca o Modelo del producto',
                confirmButtonText: 'Aceptar'
            });
        }
    }


    /*----------  Agregar codigo  ----------*/
    function agregar_codigo($codigo){
        document.querySelector('#sale-barcode-input').value=$codigo;
        setTimeout('agregar_producto()',100);
    }


    /* Actualizar cantidad de producto */
    function actualizar_cantidad(id,codigo){
        let cantidad=document.querySelector(id).value;

        cantidad=cantidad.trim();
        codigo.trim();

        if(cantidad>0){

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Desea actualizar la cantidad de productos",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, actualizar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed){

                    let datos = new FormData();
                    datos.append("producto_codigo", codigo);
                    datos.append("producto_cantidad", cantidad);
                    datos.append("modulo_venta", "actualizar_producto");

                    fetch('<?php echo APP_URL; ?>app/ajax/ventaAjax.php',{
                        method: 'POST',
                        body: datos
                    })
                    .then(respuesta => respuesta.json())
                    .then(respuesta =>{
                        return alertas_ajax(respuesta);
                    });
                }
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Ocurrió un error inesperado',
                text: 'Debes de introducir una cantidad mayor a 0',
                confirmButtonText: 'Aceptar'
            });
        }
    }


    /*----------  Buscar cliente  ----------*/
    function buscar_cliente(){
        let input_cliente=document.querySelector('#input_cliente').value;

        input_cliente=input_cliente.trim();

        if(input_cliente!=""){

            let datos = new FormData();
            datos.append("buscar_cliente", input_cliente);
            datos.append("modulo_venta", "buscar_cliente");

            fetch('<?php echo APP_URL; ?>app/ajax/ventaAjax.php',{
                method: 'POST',
                body: datos
            })
            .then(respuesta => respuesta.text())
            .then(respuesta =>{
                let tabla_clientes=document.querySelector('#tabla_clientes');
                tabla_clientes.innerHTML=respuesta;
            });

        }else{
            Swal.fire({
                icon: 'error',
                title: 'Ocurrió un error inesperado',
                text: 'Debes de introducir el Numero de documento, Nombre, Apellido o Teléfono del cliente',
                confirmButtonText: 'Aceptar'
            });
        }
    }


    /*----------  Agregar cliente  ----------*/
    function agregar_cliente(id){

        Swal.fire({
            title: '¿Quieres agregar este cliente?',
            text: "Se va a agregar este cliente para realizar una venta",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, agregar',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if (result.isConfirmed){

                let datos = new FormData();
                datos.append("cliente_id", id);
                datos.append("modulo_venta", "agregar_cliente");

                fetch('<?php echo APP_URL; ?>app/ajax/ventaAjax.php',{
                    method: 'POST',
                    body: datos
                })
                .then(respuesta => respuesta.json())
                .then(respuesta =>{
                    return alertas_ajax(respuesta);
                });

            }
        });
    }


    /*----------  Remover cliente  ----------*/
    function remover_cliente(id){

        Swal.fire({
            title: '¿Quieres remover este cliente?',
            text: "Se va a quitar el cliente seleccionado de la venta",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, remover',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if (result.isConfirmed){

                let datos = new FormData();
                datos.append("cliente_id", id);
                datos.append("modulo_venta", "remover_cliente");

                fetch('<?php echo APP_URL; ?>app/ajax/ventaAjax.php',{
                    method: 'POST',
                    body: datos
                })
                .then(respuesta => respuesta.json())
                .then(respuesta =>{
                    return alertas_ajax(respuesta);
                });

            }
        });
    }

    /*----------  Calcular cambio  ----------*/
    let venta_abono_input = document.querySelector("#venta_abono");
    venta_abono_input.addEventListener('keyup', function(e){
        e.preventDefault();

        let abono=document.querySelector('#venta_abono').value;
        abono=abono.trim();
        abono=parseFloat(abono);

        let total=document.querySelector('#venta_total_hidden').value;
        total=total.trim();
        total=parseFloat(total);

        if(abono>=total){
            cambio=abono-total;
            cambio=parseFloat(cambio).toFixed(<?php echo MONEDA_DECIMALES; ?>);
            document.querySelector('#venta_cambio').value=cambio;
        }else{
            document.querySelector('#venta_cambio').value="0.00";
        }
    });

</script>

<?php
    include "./app/views/inc/print_invoice_script.php";
?>