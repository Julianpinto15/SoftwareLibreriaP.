<?php include "./app/views/inc/admin_security.php"; ?>
<div class="container">
   <div class="position-contenido">
    <div></div>
    <div>
      <h1 class="display-5 text-titulo">Reportes</h1>
      <h2 class="h5 text-muted"><i class="fas fa-hand-holding-usd fa-fw"></i> &nbsp; Reporte general de ventas</h2>
    </div>
   </div>
</div>


<div class="container">
    <div id="today-sales">
        <h2 class="text-center my-5">Estadísticas de ventas de hoy (<?php echo date("d-m-Y"); ?>)</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th class="text-th">Ventas realizadas</th>
                        <th class="text-th">Total en ventas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $fecha_hoy=date("Y-m-d");
                        $check_ventas=$insLogin->seleccionarDatos("Normal","venta WHERE venta_fecha='$fecha_hoy'","*",0);

                        $ventas_totales=0;
                        $total_ventas=0;

                        if($check_ventas->rowCount()>=1){
                            $datos_ventas=$check_ventas->fetchAll();

                            foreach($datos_ventas as $ventas){
                                $ventas_totales++;
                                $total_ventas+=$ventas['venta_total'];
                            }
                    ?>
                    <tr class="text-center">
                        <td class="text-td"><?php echo $ventas_totales; ?></td>
                        <td class="text-td"><?php echo MONEDA_SIMBOLO.number_format($total_ventas,MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE; ?></td>
                    </tr>
                    <?php }else{ ?>
                    <tr class="text-center">
                        <td class="text-td" colspan="2">NO HAY VENTAS REALIZADAS EL DÍA DE HOY</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <hr>
   <div class="reporte-container">
    <h2 class="reporte-titulo text-center">Generar reporte personalizado</h2>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="fecha-grupo mb-3">
                    <label for="fecha_inicio" class="fecha-label">Fecha inicial (día/mes/año)</label>
                    <input type="date" class="fecha-input form-control" name="fecha_inicio" id="fecha_inicio" maxlength="30">
                </div>
            </div>
            <div class="col-md-6">
                <div class="fecha-grupo mb-3">
                    <label for="fecha_final" class="fecha-label">Fecha final (día/mes/año)</label>
                    <input type="date" class="fecha-input form-control" name="fecha_final" id="fecha_final" maxlength="30">
                </div>
            </div>
        </div>
        <p class="text-center mb-4">
            <button type="button" class="btn-generar" onclick="generar_reporte()">
                <i class="far fa-file-pdf"></i> GENERAR REPORTE
            </button>
        </p>
    </div>
</div>
</div>

<script>
    function generar_reporte(){
        Swal.fire({
            title: '¿Quieres generar el reporte?',
            text: "La generación del reporte PDF puede tardar unos minutos para completarse",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, generar',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if (result.isConfirmed){
                let fecha_inicio=document.querySelector('#fecha_inicio').value;
                let fecha_final=document.querySelector('#fecha_final').value;

                fecha_inicio.trim();
                fecha_final.trim();

                if(fecha_inicio!="" && fecha_final!=""){
                    url="<?php echo APP_URL; ?>app/pdf/report-sales.php?fi="+fecha_inicio+"&&ff="+fecha_final;
                    window.open(url,'Imprimir reporte de ventas','width=820,height=720,top=0,left=100,menubar=NO,toolbar=YES');
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Ocurrió un error inesperado',
                        text: 'Debe de ingresar la fecha de inicio y final para generar el reporte.',
                        confirmButtonText: 'Aceptar'
                    });
                } 
            }
        });
    }
</script>