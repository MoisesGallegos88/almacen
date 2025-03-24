<?php
function verificarRol($rolesPermitidos) {
    if (!isset($_SESSION['logged_in']) || !in_array($_SESSION['rol'], $rolesPermitidos)) {
        header("Location: acceso_denegado.php");
        exit();
    }
}
?>