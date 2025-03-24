<?php
session_start();
include 'conexion_db.php';

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

try {
    $sql = "SELECT * FROM Materiales ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $materiales = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error al cargar materiales: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Materiales</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <?php include 'cabecera.php'; ?>
    
    
    <main class="contenido-principal">
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Buscar por ID, nombre o material...">

    <h2>Materiales Registrados</h2>
    
    <?php if(count($materiales) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Material</th>
                    <th>Peso Total (g)</th>
                    <th>Mínimo (g)</th>
                    <th>Máximo (g)</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($materiales as $material): ?>
                <tr>
                    <td><?= htmlspecialchars($material['id']) ?></td>
                    <td><?= htmlspecialchars($material['nombre_material']) ?></td>
                    <td><?= number_format($material['peso_total'], 2) ?></td>
                    <td><?= number_format($material['minimo_g'], 2) ?></td>
                    <td><?= number_format($material['maximo_g'], 2) ?></td>
                    <td class="acciones">
                        <a href="editar_material.php?id=<?= $material['id'] ?>">Editar</a>
                          <!-- <a href="eliminar_material.php?id=<?= $material['id'] ?>" onclick="return confirm('¿Eliminar este material?')">Eliminar</a>  -->
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay materiales registrados</p>
    <?php endif; ?>

    <br>
    <a href="index.php">← Volver al menú principal</a>
</body>
</html>