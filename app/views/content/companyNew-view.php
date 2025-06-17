<div class="container py-4">
    <div class="mb-4">
        <h1 class="display-5">Empresa</h1>
        <h2 class="h4 text-muted">
            <i class="fas fa-store-alt me-2"></i>Datos de empresa
        </h2>
    </div>

    <?php
        $datos = $insLogin->seleccionarDatos("Normal", "empresa LIMIT 1", "*", 0);
        if ($datos->rowCount() == 1) {
            $datos = $datos->fetch();
    ?>

    <div class="text-center mb-4">
        <h2 class="h3"><?php echo $datos['empresa_nombre']; ?></h2>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/empresaAjax.php" method="POST" autocomplete="off">
                <input type="hidden" name="modulo_empresa" class="fs-3" value="actualizar">
                <input type="hidden" name="empresa_id" value="<?php echo $datos['empresa_id']; ?>">

                <!-- Sección de la imagen del logo -->
                <div class="row mb-4">
                    <div class="col-md-12 mb-3 mb-md-0 text-center">
                        <?php if (is_file("./app/views/img/" . $datos['empresa_foto'])) { ?>
                            <figure class="company-image">
                                <img src="<?php echo APP_URL; ?>app/views/img/<?php echo $datos['empresa_foto']; ?>" 
                                     class="img-fluid rounded" 
                                     alt="Logo de la empresa">
                            </figure>
                        <?php } else { ?>
                            <figure class="company-image">
                                <img src="<?php echo APP_URL; ?>app/views/img/logo.png" 
                                     class="img-fluid rounded" 
                                     alt="Logo predeterminado">
                            </figure>
                        <?php } ?>
                        <p class="mt-3">
                            <a href="<?php echo APP_URL . "companyImage/" . $datos['empresa_id']; ?>" 
                               class="btn btn-outline-primary">
                                <i class="far fa-image me-2"></i>Cambiar logo o imagen
                            </a>
                        </p>
                    </div>
                </div>

                <!-- Campos del formulario -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="form-group">
                            <label for="empresa_nombre" class="form-label fs-4">Nombre *</label>
                            <input type="text" 
                                   class="form-control fs-3" 
                                   id="empresa_nombre" 
                                   name="empresa_nombre" 
                                   pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ., ]{4,85}" 
                                   maxlength="85" 
                                   value="<?php echo $datos['empresa_nombre']; ?>" 
                                   required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="empresa_telefono" class="form-label fs-4">Teléfono</label>
                            <input type="text" 
                                   class="form-control fs-3" 
                                   id="empresa_telefono" 
                                   name="empresa_telefono" 
                                   pattern="[0-9()+]{8,20}" 
                                   maxlength="20" 
                                   value="<?php echo $datos['empresa_telefono']; ?>">
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="form-group">
                            <label for="empresa_email" class="form-label fs-4">Email</label>
                            <input type="email" 
                                   class="form-control fs-3" 
                                   id="empresa_email" 
                                   name="empresa_email" 
                                   maxlength="50" 
                                   value="<?php echo $datos['empresa_email']; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="empresa_direccion" class="form-label fs-4">Dirección</label>
                            <input type="text" 
                                   class="form-control fs-3" 
                                   id="empresa_direccion" 
                                   name="empresa_direccion" 
                                   pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,97}" 
                                   maxlength="97" 
                                   value="<?php echo $datos['empresa_direccion']; ?>">
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-4">Actualizar</button>
                </div>
            </form>
        </div>
    </div>

    <?php } else { ?>
    <div class="alert alert-danger text-center" role="alert">
        No se encontraron datos de la empresa.
    </div>
    <?php } ?>
</div>