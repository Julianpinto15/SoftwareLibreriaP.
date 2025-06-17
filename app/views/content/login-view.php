<div class="body">
 <div class="container contenido-principal min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="col-11 col-sm-8 col-md-6 col-lg-4">
            <div class="text-center mb-4">
            </div>
            
            <div class="login-card">
                <div class="card-header py-3">
                    <h3 class="text-center m-0">INICIO DE SESIÓN</h3>
                </div>

                <div class="card-body p-4">
                    <form class="login" action="" method="POST" autocomplete="off">
                        <div class="form-group text-center mb-4">
                            <label class="label-text form-label fw-bold mb-2">Usuario</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-user text-muted"></i>
                                </span>
                                <input 
                                    type="text" 
                                    name="login_usuario" 
                                    class="form-input form-control border-start-0 ps-3" 
                                    placeholder="Ingrese su usuario"
                                    pattern="[a-zA-Z0-9]{4,20}" 
                                    maxlength="20" 
                                    required
                                >
                            </div>
                        </div>

                        <div class="text-center form-group mb-4">
                            <label class="label-text form-label fw-bold mb-2">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input 
                                    type="password" 
                                    name="login_clave" 
                                    class="form-input form-control border-start-0 ps-3" 
                                    placeholder="Ingrese su contraseña"
                                    pattern="[a-zA-Z0-9$@.-]{7,100}" 
                                    maxlength="100" 
                                    required
                                >
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-2">
                            <button type="submit" class="btn-inicio btn btn-primaryInicio">
                                INICIAR SESIÓN
                            </button>
                        </div>
                    </form>

                    <?php if(isset($_SESSION['login_error'])): ?>
                        <div class="alert alert-danger mt-3 text-center">
                            <?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="text-center mt-3 text-black">
                <h5>&copy; <?php echo date('Y'); ?> Sistema  All Books. Todos los derechos reservados.</h5>
            </div>
        </div>
    </div>

    <?php
        if(isset($_POST['login_usuario']) && isset($_POST['login_clave'])){
            $insLogin->iniciarSesionControlador();
        }
    ?>
 </div>

