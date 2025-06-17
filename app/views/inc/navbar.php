<header class="header-main">
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <!-- Logo -->
      <a class="navbar-brand" href="<?php echo APP_URL; ?>dashboard/">
        <img src="<?php echo APP_URL; ?>app/views/img/allBooksC.jpeg" alt="logo libreria" width="160" height="80">
      </a>
      
      <!-- Hamburger button -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar content -->
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <!-- Dashboard link -->
          <li class="menu-item">
            <a class="navbar-item" href="<?php echo APP_URL; ?>dashboard/">Dashboard</a>
          </li>
          
          <!-- Users dropdown (solo para Administrador) -->
          <?php if ($_SESSION['cargo'] == "Administrador") { ?>
          <li class="menu-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Usuarios
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?php echo APP_URL; ?>userNew/">Nuevo</a></li>
              <li><a class="dropdown-item" href="<?php echo APP_URL; ?>userList/">Lista</a></li>
            </ul>
          </li>
          <?php } ?>
        </ul>

        <!-- User profile dropdown -->
        <div class="dropdown perfil_despegable">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="me-2">
              <?php
                if(is_file("./app/views/fotos/".$_SESSION['foto'])){
                  echo '<img class="rounded-circle" src="'.APP_URL.'app/views/fotos/'.$_SESSION['foto'].'" width="32" height="32">';
                }else{
                  echo '<img class="rounded-circle" src="'.APP_URL.'app/views/fotos/default.png" width="32" height="32">';
                }
              ?>
            </span>
            <?php echo $_SESSION['usuario']; ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="<?php echo APP_URL."userUpdate/".$_SESSION['id']."/"; ?>">Mi cuenta</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL."userPhoto/".$_SESSION['id']."/"; ?>">Mi foto</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL."logOut/"; ?>" id="btn_exit">Salir</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</header>