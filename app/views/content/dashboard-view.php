<div class="container">
    <!-- Header with profile -->
    <div class="text-center mb-3">
        <h1 class="display-4 mb-4">Dashboard</h1>
        <div class="d-flex justify-content-center mb-3">
            <div class="rounded-circle overflow-hidden" style="width: 128px; height: 128px;">
                <?php
                if(is_file("./app/views/fotos/".$_SESSION['foto'])){
                    echo '<img class="img-fluid" src="'.APP_URL.'app/views/fotos/'.$_SESSION['foto'].'" alt="Profile">';
                }else{
                    echo '<img class="img-fluid" src="'.APP_URL.'app/views/fotos/default.png" alt="Default Profile">';
                }
                ?>
            </div>
        </div>
        <h2 class="h3 text-muted">¡Bienvenido <?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?>!</h2>
    </div>

    <?php 
    $total_cajas=$insLogin->seleccionarDatos("Normal","caja","caja_id",0);
    $total_usuarios=$insLogin->seleccionarDatos("Normal","usuario WHERE usuario_id!='1' AND usuario_id!='".$_SESSION['id']."'","usuario_id",0);
    $total_clientes=$insLogin->seleccionarDatos("Normal","cliente WHERE cliente_id!='1'","cliente_id",0);
    $total_categorias=$insLogin->seleccionarDatos("Normal","categoria","categoria_id",0);
    $total_productos=$insLogin->seleccionarDatos("Normal","producto","producto_id",0);
    $total_ventas=$insLogin->seleccionarDatos("Normal","venta","venta_id",0);
    ?>

    <!-- First row of cards -->
    <div class="row g-4 mb-4">
        <?php if($_SESSION['cargo']=="Administrador"){ ?>
        <!-- Cajas Card -->
        <div class="col-md-4">
            <div class="card h-100">
                <a href="<?php echo APP_URL; ?>cashierList/" class="card-enlace">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-cash-register fa-5x text-primary"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Cajas</h6>
                            <h2 class="card-title mb-0"><?php echo $total_cajas->rowCount(); ?></h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Usuarios Card -->
        <div class="col-md-4">
            <div class="card card-orange h-100 ">
                <a href="<?php echo APP_URL; ?>userList/" class="card-enlace">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-users fa-5x text-success "></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Usuarios</h6>
                            <h2 class="card-title mb-0"><?php echo $total_usuarios->rowCount(); ?></h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <?php } ?>

        <!-- Clientes Card -->
        <div class="col-md-4 ">
            <div class="card card-yellow h-100 p-3">
                <a href="<?php echo APP_URL; ?>clientList/" class="card-enlace">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-address-book fa-5x text-info"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Clientes</h6>
                            <h2 class="card-title mb-0"><?php echo $total_clientes->rowCount(); ?></h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <?php if($_SESSION['cargo']=="Administrador"){ ?>
        <!-- Categorías Card -->
        <div class="col-md-4">
            <div class="card card-orange h-100">
                <a href="<?php echo APP_URL; ?>categoryList/" class="card-enlace">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-tags fa-5x text-warning"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Categorías</h6>
                            <h2 class="card-title mb-0"><?php echo $total_categorias->rowCount(); ?></h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Productos Card -->
        <div class="col-md-4">
            <div class="card card-yellow h-100 p-3">
                <a href="<?php echo APP_URL; ?>productNew/" class="card-enlace">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-cubes fa-5x text-danger"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Productos</h6>
                            <h2 class="card-title mb-0"><?php echo $total_productos->rowCount(); ?></h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <?php } ?>

        <!-- Ventas Card -->
        <div class="col-md-4">
            <div class="card h-100 ">
                <a href="<?php echo APP_URL; ?>saleList/" class="card-enlace">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-shopping-cart fa-5x text-success"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Ventas</h6>
                            <h2 class="card-title mb-0"><?php echo $total_ventas->rowCount(); ?></h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>