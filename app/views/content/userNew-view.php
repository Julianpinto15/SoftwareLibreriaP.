
<div class="registration-container">
        <div class="form-header">
          <center>  <h1>Registro de Usuarios</h1>
            <h2 class="h5 text-muted">Sistema Integral de Gestión de Librería</h2></center>
        </div>

		<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data" >
		<input type="hidden" name="modulo_usuario" value="registrar">

            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label for="usuario_nombre" class="form-label formato-label">Nombres</label>
                    <input type="text" class="form-control formato-input" id="usuario_nombre" name="usuario_nombre" 
                           pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required
                           placeholder="Ingrese sus nombres completos">
                </div>
                <div class="col-md-6">
                    <label for="usuario_apellido" class="form-label  formato-label">Apellidos</label>
                    <input type="text" class="form-control formato-input" id="usuario_apellido" name="usuario_apellido" 
                           pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required
                           placeholder="Ingrese sus apellidos completos">
                </div>
            </div>

            <div class="row mb-4">
            <div class="col-md-4 mb-3 mb-md-0">
            <label for="usuario_usuario" class="form-label formato-label">Nombre de Usuario</label>
                    <input type="text" class="form-control formato-input" id="usuario_usuario" name="usuario_usuario" 
                           pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required
                           placeholder="Elija un nombre de usuario único">
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                        <label for="usuario_email" class="form-label formato-label">Correo Electrónico</label>
                    <input type="email" class="form-control formato-input" id="usuario_email" name="usuario_email" 
                           maxlength="70" placeholder="ejemplo@dominio.com">
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                <label for="usuario_cargo" class="form-label formato-label">Cargo <?php echo CAMPO_OBLIGATORIO; ?></label><br>
				<div class="select" class="form-label"> 
				  	<select class="form-control formato-input" id="usuario_cargo" name="usuario_cargo">">
				    	<option value="" selected="" >Seleccione una opción</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Cajero">Cajero</option>
				  	</select>
				</div>
		  	</div>
</div>

            
            <div class="row mb-4">
                <div class="col-md-4 mb-3 mb-md-0">
                    <label for="usuario_clave_1" class="form-label formato-label">Contraseña</label>
                    <input type="password" class="form-control formato-input" id="usuario_clave_1" name="usuario_clave_1" 
                           pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required
                           placeholder="Mínimo 7 caracteres">
                </div>
                <div class="col-md-4">
                    <label for="usuario_clave_2" class="form-label formato-label">Confirmar Contraseña</label>
                    <input type="password" class="form-control formato-input" id="usuario_clave_2" name="usuario_clave_2" 
                           pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required
                           placeholder="Repita su contraseña">
                </div>
        
            <div class="col-md-4">
                <label for="usuario_caja" class="form-label formato-label">Caja de ventas <?php echo CAMPO_OBLIGATORIO; ?></label>
                <select class="form-control formato-input" id="usuario_caja" name="usuario_caja">
                    <option value="" selected="">Seleccione una opción</option>
                    <?php
                        $datos_cajas = $insLogin->seleccionarDatos("Normal", "caja", "*", 0);
                        while ($campos_caja = $datos_cajas->fetch()) {
                            echo '<option value="' . $campos_caja['caja_id'] . '">Caja No.' . $campos_caja['caja_numero'] . ' - ' . $campos_caja['caja_nombre'] . '</option>';
                        }
                    ?>
                </select>
            </div>
            </div>
	

            <!-- Rest of the form remains the same as previous version -->
			<div class="row mb-4">
		<!-- Replace the existing file input section with this code -->
        <center>  <div class="col-md-6 mb-3 mb-md-0">
                <label for="usuario_foto" class="form-label formato-label">Foto de Perfil</label>
                <div class="file-input-container">
                    <div class="file-input-trigger">
                        <span class="file-input-text">Seleccionar Archivo</span>
                      <input class="form-control formato-input" type="file" id="usuario_foto" name="usuario_foto" 
                            accept=".jpg, .png, .jpeg">
                    </div>
                    <div id="image-preview-container" class="mt-2" style="display: none;">
                        <div class="preview-content">
                            <img id="image-preview" class="preview-image">
                            <span id="file-name" class="file-name"></span>
                        </div>
                    </div>
                </div>
                <small class="text-muted">Formatos: JPG, JPEG, PNG (Máximo 5MB)</small></center>  
            </div>
                    
         
            <!-- Rest of the form and scripts remain the same -->
            <div class="text-center">
                <button type="reset" class="btn btn-outline-secondary me-3">Limpiar Formulario</button>
                <button type="submit" class="btn btn-primary">Registrar Usuario</button>
            </div>
        </form>
    </div>

   
