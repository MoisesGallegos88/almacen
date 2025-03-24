    <?php
    // cabecera.php
    if (!isset($_SESSION)) session_start();
    ?>
    <header class="cabecera">
        <a href="index.php" class="logo">GestAlmacén</a>
        <nav class="navegacion">
            <a href="index.php">Inicio</a>
            <a href="buscar_articulos.php">Buscar Artículos</a>
            <a href="materiales.php">Gestión de Materiales</a>
            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                <a href="admin/registro.php">Registrar Usuarios</a>
            <?php endif; ?>
        </nav>
        <div class="usuario-info">
            <?php if (isset($_SESSION['username'])): ?>
                <span>Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?></span>
                <a href="logout.php">Cerrar Sesión</a>
            <?php endif; ?>
        </div>
    </header>