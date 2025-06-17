<div class="registration-container">
        <div class="form-header">
            <center>
                <?php 
                    $id=$insLogin->limpiarCadena($url[1]);
                    
                    if($_SESSION['cargo']=="Cajero" && $id!=$_SESSION['id']){
                        include "./app/views/content/logOut-view.php";
                    }
                    if($id==$_SESSION['id']){ 
                ?>
                <h1>Mi foto de perfil</h1>
                <h2>Actualizar foto de perfil</h2>
                <?php }else{ ?>
                <h1>Usuarios</h1>
                <h2>Actualizar foto de perfil</h2>
                <?php } ?>
            </center>
        </div>

        <?php
        		include "./app/views/inc/btn_back.php";

            $datos=$insLogin->seleccionarDatos("Unico","usuario","usuario_id",$id);
            if($datos->rowCount()==1){
                $datos=$datos->fetch();
        ?>

        <div class="user-info text-center mb-4">
            <h2><?php echo $datos['usuario_nombre']." ".$datos['usuario_apellido']; ?></h2>
            <p>
                <strong>Usuario creado:</strong> <?php echo date("d-m-Y h:i:s A", strtotime($datos['usuario_creado'])); ?> 
                &nbsp; 
                <strong>Usuario actualizado:</strong> <?php echo date("d-m-Y h:i:s A", strtotime($datos['usuario_actualizado'])); ?>
            </p>
        </div>

        <div class="row">
            <div class="col-md-5 text-center">
                <?php if(is_file("./app/views/fotos/".$datos['usuario_foto'])){ ?>
                    <div class="mb-4">
                        <img src="<?php echo APP_URL; ?>app/views/fotos/<?php echo $datos['usuario_foto']; ?>" 
                             class="img-fluid rounded-circle mb-3" style="max-width: 250px; max-height: 250px; object-fit: cover;">
                        
                        <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" autocomplete="off">
                            <input type="hidden" name="modulo_usuario" value="eliminarFoto">
                            <input type="hidden" name="usuario_id" value="<?php echo $datos['usuario_id']; ?>">
                            <button type="submit" class="btn btn-danger rounded-pill">Eliminar foto</button>
                        </form>
                    </div>
                <?php }else{ ?>
                    <div class="mb-4">
                        <img src="<?php echo APP_URL; ?>app/views/fotos/default.png" 
                             class="img-fluid rounded-circle mb-3" style="max-width: 250px; max-height: 250px; object-fit: cover;">
                    </div>
                <?php }?>
            </div>

            <div class="col-md-7">
                <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" 
                      enctype="multipart/form-data" autocomplete="off">
                    <input type="hidden" name="modulo_usuario" value="actualizarFoto">
                    <input type="hidden" name="usuario_id" value="<?php echo $datos['usuario_id']; ?>">
                    
                    <label class="form-label">Foto o imagen del usuario</label>
                    
                    <div class="file-input-container mb-4">
                        <input class="form-control" type="file" name="usuario_foto" 
                               accept=".jpg, .png, .jpeg" id="usuario_foto">
                        <small class="text-muted">Formatos: JPG, JPEG, PNG (Máximo 5MB)</small>
                    </div>
                    
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary rounded-pill">Actualizar foto</button>
                    </div>
                </form>
            </div>
        </div>

        <?php
            }else{
                include "./app/views/inc/error_alert.php";
            }
        ?>
    </div>