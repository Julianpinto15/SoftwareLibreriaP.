<?php
    if($_SESSION['cargo']!="Administrador"){
        include "./app/views/content/logOut-view.php";
    }