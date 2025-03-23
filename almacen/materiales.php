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
    <style>
        body { font-family: Arial, sans-serif; max-width: 1200px; margin: 20px auto; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .user-info { position: absolute; top: 20px; right: 20px; }
        .logout { color: #dc3545; text-decoration: none; }
        .acciones a { margin-right: 10px; }
    </style>
</head>
<body>
    <div class="user-info">
        Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?>! 
        <a href="logout.php" class="logout">Cerrar Sesión</a>
    </div>

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
                        <a href="eliminar_material.php?id=<?= $material['id'] ?>" onclick="return confirm('¿Eliminar este material?')">Eliminar</a>
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