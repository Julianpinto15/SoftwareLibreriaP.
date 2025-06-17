<div class="sidebar">

    <!-- Ventas -->
    <div class="menu-item has-dropdown">
        <span class="emoji"><i class="fas fa-shopping-cart"></i></span>
        <span class="menu-text">Venta</span>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="<?php echo APP_URL; ?>saleNew/">
                <span class="emoji"><i class="fas fa-cart-plus"></i></span> Nueva venta
            </a>
            <a class="dropdown-item" href="<?php echo APP_URL; ?>saleList/">
                <span class="emoji"><i class="fas fa-clipboard-list"></i></span> Lista de ventas
            </a>
        </div>
    </div>

    <!-- Productos -->
    <?php if ($_SESSION['cargo'] == "Administrador") { ?>
    <div class="menu-item has-dropdown">
        <span class="emoji"><i class="fas fa-cubes"></i></span>
        <span class="menu-text">Producto</span>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="<?php echo APP_URL; ?>productNew/">
                <span class="emoji"><i class="fas fa-box"></i></span> Nuevo producto
            </a>
            <a class="dropdown-item" href="<?php echo APP_URL; ?>autor/">
               <span class="emoji"><i class="bi bi-person-lines-fill"></i></span> Autor
            </a>
            <a class="dropdown-item" href="<?php echo APP_URL; ?>editorial/">
                <span class="emoji"><i class="bi bi-book"></i></span> Editorial
            </a>
        </div>
    </div>
    <?php } ?>

    <!-- Categorias -->
    <?php if ($_SESSION['cargo'] == "Administrador") { ?>
    <div class="menu-item has-dropdown">
        <span class="emoji"><i class="fas fa-tags"></i></span>
        <span class="menu-text">Categoria</span>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="<?php echo APP_URL; ?>categoryList/">
               <span class="emoji"><i class="fas fa-clipboard-list"></i></span> Categoria
            </a>
            <a class="dropdown-item" href="<?php echo APP_URL; ?>subcategoria/">
                <span class="emoji"><i class="bi bi-book"></i></span> Subcategoria
            </a>
        </div>
    </div>
    <?php } ?>

    <!-- Reportes -->
    <?php if ($_SESSION['cargo'] == "Administrador") { ?>
    <div class="menu-item has-dropdown">
        <span class="emoji"><i class="bi bi-file-earmark-text"></i></span>
        <span class="menu-text">Reportes</span>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="<?php echo APP_URL; ?>reportSales/">
               <span class="emoji"><i class="fas fa-clipboard-list"></i></span> Reporte por venta
            </a>
            <a class="dropdown-item" href="<?php echo APP_URL; ?>reportInventory/">
                <span class="emoji"><i class="bi bi-book"></i></span> Reporte inventario
            </a>
        </div>
    </div>
    <?php } ?>

    <!-- Configuraciones -->
    <div class="menu-item has-dropdown">
        <span class="emoji"><i class="fas fa-cogs"></i></span>
        <span class="menu-text">Configuracion</span>
        <div class="dropdown-menu">
            <?php if ($_SESSION['cargo'] == "Administrador") { ?>
            <a class="dropdown-item" href="<?php echo APP_URL; ?>companyNew/">
                <span class="emoji"><i class="fas fa-store-alt"></i></span> Datos de empresa
            </a>
            <?php } ?>
            <a class="dropdown-item" href="<?php echo APP_URL."userUpdate/".$_SESSION['id']."/"; ?>">
                <span class="emoji"><i class="fas fa-user-tie"></i></span> Mi cuenta
            </a>
            <a class="dropdown-item" href="<?php echo APP_URL."userPhoto/".$_SESSION['id']."/"; ?>">
                <span class="emoji"><i class="fas fa-camera"></i></span> Mi foto
            </a>
        </div>
    </div>

    <!-- Clientes -->
    <a class="menu-item" href="<?php echo APP_URL; ?>clientList/">
        <span class="emoji"><i class="fas fa-address-book"></i></span>
        <span class="menu-text">Cliente</span>
    </a>

    <!-- Cajas -->
    <?php if ($_SESSION['cargo'] == "Administrador") { ?>
    <a class="menu-item" href="<?php echo APP_URL; ?>cashierList/">
        <span class="emoji"><i class="fas fa-cash-register"></i></span>
        <span class="menu-text">Caja</span>
    </a>
    <?php } ?>

    <!-- Logout -->
    <a class="menu-item" href="<?php echo APP_URL."logOut/"; ?>">
        <span class="emoji"><i class="fas fa-power-off"></i></span>
        <span class="menu-text text-danger">Cerrar sesión</span>
    </a>
</div>