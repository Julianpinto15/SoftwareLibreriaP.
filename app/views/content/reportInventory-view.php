<?php include "./app/views/inc/admin_security.php"; ?>
<div class="container">
  <div class="position-contenido">
    <div></div>
      <div>
        <h1 class="display-5 text-titulo">Reportes</h1>
        <h2 class="h5 text-muted"><i class="fas fa-box-open fa-fw"></i> &nbsp; Reporte general de inventario</h2>
      </div>
   </div>
</div>

<div class="reporte-container">
    <h4 class="reporte-titulo text-center">Generar reporte de inventario personalizado</h4>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="selector-grupo mb-3">
                    <label for="orden_reporte_inventario" class="fecha-label">Ordenar por</label>
                    <select class="selector-inventario" name="orden_reporte_inventario" id="orden_reporte_inventario">
                        <option value="nasc" selected="">Nombre (ascendente)</option>
                        <option value="ndesc">Nombre (descendente)</option>
                        <option value="sasc">Stock (menor - mayor)</option>
                        <option value="sdesc">Stock (mayor - menor)</option>
                        <option value="pasc">Precio (menor - mayor)</option>
                        <option value="pdesc">Precio (mayor - menor)</option>
                    </select>
                </div>
                <p class="text-center mb-4">
                    <button type="button" class="btn-generar-inventario" onclick="generar_reporte_inventario()">
                        <i class="far fa-file-pdf"></i> GENERAR REPORTE
                    </button>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    function generar_reporte_inventario(){
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
                let orden=document.querySelector('#orden_reporte_inventario').value;

                orden.trim();

                if(orden!=""){
                    url="<?php echo APP_URL; ?>app/pdf/report-inventory.php?order="+orden;
                    window.open(url,'Imprimir reporte de inventario','width=820,height=720,top=0,left=100,menubar=NO,toolbar=YES');
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Ocurrió un error inesperado',
                        text: 'Debe de seleccionar un orden para generar el reporte.',
                        confirmButtonText: 'Aceptar'
                    });
                }
            }
        });
    }
</script>