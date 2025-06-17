<div class="container">
  <div class="position-contenido">
    <div>
      	<?php
	
		include "./app/views/inc/btn_back.php";

		$code=$insLogin->limpiarCadena($url[1]);

		$datos=$insLogin->seleccionarDatos("Normal","venta INNER JOIN cliente ON venta.cliente_id=cliente.cliente_id INNER JOIN usuario ON venta.usuario_id=usuario.usuario_id INNER JOIN caja ON venta.caja_id=caja.caja_id WHERE (venta_codigo='".$code."')","*",0);

		if($datos->rowCount()==1){
			$datos_venta=$datos->fetch();
	?>
    </div>

    <div>
      <h1>Detalle Venta</h1>
      <h2 class="h3 text-muted">Datos de la venta <?php echo " (".$code.")"; ?></h2>
    </div>
  </div>
</div>

<div class="container">
    <div class="row py-4">
        <div class="col-md-4">
            <div class="w-100 sale-details">
                <div class=" estilo-label">Fecha</div>
                <span class="text-primary fw-bold"><?php echo date("d-m-Y", strtotime($datos_venta['venta_fecha']))." ".$datos_venta['venta_hora']; ?></span>
            </div>

            <div class="w-100 sale-details">
                <div class=" estilo-label">Nro. de factura</div>
                <span class="text-primary fw-bold"><?php echo $datos_venta['venta_id']; ?></span>
            </div>

            <div class="w-100 sale-details">
                <div class=" estilo-label">Código de venta</div>
                <span class="text-primary fw-bold"><?php echo $datos_venta['venta_codigo']; ?></span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="w-100 sale-details">
                <div class=" estilo-label">Caja</div>
                <span class="text-primary fw-bold">Nro. <?php echo $datos_venta['caja_numero']." (".$datos_venta['caja_nombre']; ?>)</span>
            </div>

            <div class="w-100 sale-details">
                <div class=" estilo-label">Vendedor</div>
                <span class="text-primary fw-bold"><?php echo $datos_venta['usuario_nombre']." ".$datos_venta['usuario_apellido']; ?></span>
            </div>

            <div class="w-100 sale-details">
                <div class=" estilo-label">Cliente</div>
                <span class="text-primary fw-bold"><?php echo $datos_venta['cliente_nombre']." ".$datos_venta['cliente_apellido']; ?></span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="w-100 sale-details">
                <div class="estilo-label">Total</div>
                <span class="text-primary fw-bold"><?php echo MONEDA_SIMBOLO.number_format($datos_venta['venta_total'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE; ?></span>
            </div>

            <div class="w-100 sale-details">
                <div class=" estilo-label">Pagado</div>
                <span class="text-primary fw-bold"><?php echo MONEDA_SIMBOLO.number_format($datos_venta['venta_pagado'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE; ?></span>
            </div>

            <div class="w-100 sale-details">
                <div class=" estilo-label">Cambio</div>
                <span class="text-primary fw-bold"><?php echo MONEDA_SIMBOLO.number_format($datos_venta['venta_cambio'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE; ?></span>
            </div>
        </div>
    </div>

	<div class="row">
		<div class="col-12">
			<div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th class="text-th">#</th>
                            <th class="text-th">Producto</th>
                            <th class="text-th">Cant.</th>
							<th class="text-th">Autor</th>
                            <th class="text-th">Precio</th>
                            <th class="text-th">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        	$detalle_venta=$insLogin->seleccionarDatos("Normal","venta_detalle WHERE venta_codigo='".$datos_venta['venta_codigo']."'","*",0);

                            if($detalle_venta->rowCount()>=1){

                                $detalle_venta=$detalle_venta->fetchAll();
                            	$cc=1;

                                foreach($detalle_venta as $detalle){
                        ?>
                        <tr class="text-center" >
                            <td class="text-td"><?php echo $cc; ?></td>
                            <td class="text-td"><?php echo $detalle['venta_detalle_descripcion']; ?></td>
                            <td class="text-td"><?php echo $detalle['venta_detalle_cantidad']; ?></td>
							<td class="text-td"><?php echo $detalle['autor']; ?></td>
                            <td class="text-td"><?php echo MONEDA_SIMBOLO.number_format($detalle['venta_detalle_precio_venta'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)." ".MONEDA_NOMBRE; ?></td>
                            <td class="text-td"><?php echo MONEDA_SIMBOLO.number_format($detalle['venta_detalle_total'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)." ".MONEDA_NOMBRE; ?></td>
                        </tr>
                        <?php
                                $cc++;
                            }
                        ?>
                        <tr class="text-center" >
                            <td  class="text-td"colspan="3"></td>
                            <td  class="text-td"class="fw-bold">
                                TOTAL
                            </td>
                            <td class="text-td">
                                <?php echo MONEDA_SIMBOLO.number_format($datos_venta['venta_total'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)." ".MONEDA_NOMBRE; ?>
                            </td>
                        </tr>
                        <?php
                            }else{
                        ?>
                        <tr class="text-center" >
                            <td colspan="8">
                                No hay productos agregados
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
		</div>
	</div>

	<div class="row py-4">
		<div class="col-12 text-center">
			<?php
			echo '<button type="button" class="text-td btn-registrar btn btn-success rounded-pill" onclick="print_invoice(\''.APP_URL.'app/pdf/invoice.php?code='.$datos_venta['venta_codigo'].'\')" title="Imprimir factura Nro. '.$datos_venta['venta_id'].'" >
			<i class="fas fa-file-invoice-dollar fa-fw"></i> Imprimir factura
			</button> &nbsp;&nbsp; 

			<button type="button" class="text-td btn-registrar btn btn-primary rounded-pill" onclick="print_ticket(\''.APP_URL.'app/pdf/ticket.php?code='.$datos_venta['venta_codigo'].'\')" title="Imprimir ticket Nro. '.$datos_venta['venta_id'].'" ><i class="fas fa-receipt fa-fw"></i> Imprimir ticket</button>';
			?>
		</div>
	</div>
	<?php
			include "./app/views/inc/print_invoice_script.php";
		}else{
			include "./app/views/inc/error_alert.php";
		}
	?>
</div>