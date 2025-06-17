<?php include "./app/views/inc/admin_security.php"; ?>
<div class="container mb-4">
    <?php
        $id=$insLogin->limpiarCadena($url[1]);
    ?>
    <h1 class="mt-4">Empresa</h1>
    <h2 class="h4 text-muted"><i class="far fa-image"></i> &nbsp; Actualizar logo o imagen de empresa</h2>
</div>

<div class="container py-4">
    <?php
        include "./app/views/inc/btn_back.php";
        $datos=$insLogin->seleccionarDatos("Unico","empresa","empresa_id",$id);
        if($datos->rowCount()==1){
            $datos=$datos->fetch();
    ?>

    <h2 class="text-center text-primary"><?php echo $datos['empresa_nombre']; ?></h2>

    <div class="row">
        <div class="col-md-5">
            <h4 class="h4 text-center pb-4">Imagen o logo actual de la empresa</h4>
            <?php if(is_file("./app/views/img/".$datos['empresa_foto'])){ ?>
            <figure class="text-center mb-4">
                <img class="img-fluid" src="<?php echo APP_URL; ?>app/views/img/<?php echo $datos['empresa_foto']; ?>">
            </figure>
            
            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/empresaAjax.php" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_empresa" value="eliminarFoto">
                <input type="hidden" name="empresa_id" value="<?php echo $datos['empresa_id']; ?>">

                <p class="text-center">
                    <button type="submit" class="btn btn-danger rounded-pill"><i class="far fa-trash-alt"></i> &nbsp; Eliminar imagen o logo</button>
                </p>
            </form>
            <?php }else{ ?>
            <figure class="text-center mb-4">
                <img class="img-fluid" src="<?php echo APP_URL; ?>app/views/img/logo.png">
            </figure>
            <?php }?>
        </div>
 
        <div class="col-md-7">
            <h4 class="h4 text-center pb-4">Actualizar imagen o logo de empresa</h4>
            <form class="mb-4 text-center FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/empresaAjax.php" method="POST" enctype="multipart/form-data" autocomplete="off" >
                <input type="hidden" name="modulo_empresa" value="actualizarFoto">
                <input type="hidden" name="empresa_id" value="<?php echo $datos['empresa_id']; ?>">
                
                <label class="mb-3">Tipos de archivos permitidos: .PNG Tamaño máximo 5MB. Resolución recomendada 300px X 300px o superior manteniendo el aspecto cuadrado (1:1)</label><br>

                <div class="mb-4 d-flex justify-content-center">
                    <div class="input-group">
                        <input type="file" class="form-control" name="empresa_foto" accept=".png" id="inputGroupFile">
                        <label class="input-group-text" for="inputGroupFile">.PNG (MAX 5MB)</label>
                    </div>
                </div>
                
                <p class="text-center">
                    <button type="submit" class="btn btn-success rounded-pill"><i class="fas fa-sync-alt"></i> &nbsp; Actualizar imagen o logo</button>
                </p>
            </form>
        </div>
    </div>
    <?php
        }else{
            include "./app/views/inc/error_alert.php";
        }
    ?>
</div>