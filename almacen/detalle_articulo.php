<?php
session_start();
include 'conexion_db.php';

// Verificar autenticación
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

// Obtener ID del artículo
$id_articulo = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id_articulo) {
    die("ID de artículo inválido");
}

try {
    // Obtener datos del artículo
    $sql_articulo = "SELECT a.*, m.nombre_material 
                     FROM Articulos a
                     INNER JOIN Materiales m ON a.id_material = m.id
                     WHERE a.id = :id";
    
    $stmt_articulo = $conn->prepare($sql_articulo);
    $stmt_articulo->execute([':id' => $id_articulo]);
    $articulo = $stmt_articulo->fetch(PDO::FETCH_ASSOC);

    if (!$articulo) {
        throw new Exception("Artículo no encontrado");
    }

    // Obtener ventas relacionadas
    $sql_ventas = "SELECT v.*, u.nombre_usuario 
                   FROM Ventas v
                   INNER JOIN Usuarios u ON v.id_usuario = u.id
                   WHERE v.id_articulo = :id_articulo";
    
    $stmt_ventas = $conn->prepare($sql_ventas);
    $stmt_ventas->execute([':id_articulo' => $id_articulo]);
    $ventas = $stmt_ventas->fetchAll(PDO::FETCH_ASSOC);

    // Calcular precio de venta (10% más)
    $precio_venta = $articulo['costo_compra'] * 1.10;

} catch(PDOException $e) {
    die("Error de base de datos: " . $e->getMessage());
} catch(Exception $e) {
    die($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Artículo</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 20px auto; padding: 20px; }
        .card { border: 1px solid #ddd; padding: 20px; border-radius: 10px; margin-bottom: 20px; }
        .venta-form { background: #f5f5f5; padding: 20px; margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .btn-venta { background: #28a745; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        .vendido { color: #dc3545; font-weight: bold; }

        
    </style>
</head>
<body>
    <div class="user-info">
        Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?>! 
        <a href="logout.php" class="logout">Cerrar Sesión</a>
    </div>

    <div class="card">
        <h2><?= htmlspecialchars($articulo['nombre_articulo']) ?></h2>
        <p><strong>Material:</strong> <?= htmlspecialchars($articulo['nombre_material']) ?></p>
        <p><strong>Descripción:</strong> <?= htmlspecialchars($articulo['descripcion']) ?></p>
        <p><strong>Costo de compra:</strong> $<?= number_format($articulo['costo_compra'], 2) ?></p>
            <?php if($articulo['activo'] == 0): ?>
        <p><strong>Precio de venta:</strong> $<?= number_format($precio_venta, 2) ?> (10% adicional)</p>
    <?php endif; ?>


        <p><strong>Estado:</strong> 
            <span class="<?= $articulo['activo'] ? 'en-stock' : 'vendido' ?>">
                <?= $articulo['activo'] ? 'Disponible' : 'Vendido' ?>
            </span>
        </p>
        
    </div>

    <?php if($articulo['activo'] == 1): ?>
    <div class="venta-form">
        <h3>Realizar Venta</h3>
        <form action="procesar_venta.php" method="POST">
            <input type="hidden" name="id_articulo" value="<?= $articulo['id'] ?>">
            <input type="hidden" name="precio_unitario" value="<?= $precio_venta ?>">
            <input type="hidden" name="cantidad" value="1"> <!-- Cantidad fija en 1 -->
            
            <div class="venta-info">
                <p><strong>Precio de Venta:</strong> $<?= number_format($precio_venta, 2) ?></p>
                <p><strong>Cantidad:</strong> 1 unidad</p>
            </div>
            
            <button type="submit" class="btn-venta">Confirmar Venta</button>
        </form>
    </div>
    <?php else: ?>
        <p class="vendido">Este artículo ya fue vendido</p>
    <?php endif; ?>

    <div class="historial-ventas">
        <h3>Historial de Ventas</h3>
        <?php if(count($ventas) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Vendedor</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($ventas as $venta): ?>
                    <tr>
                        <td><?= date('d/m/Y H:i', strtotime($venta['fecha_venta'])) ?></td>
                        <td><?= htmlspecialchars($venta['nombre_usuario']) ?></td>
                        <td><?= $venta['cantidad'] ?></td>
                        <td>$<?= number_format($venta['precio_unitario'], 2) ?></td>
                        <td>$<?= number_format($venta['total'], 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay ventas registradas para este artículo</p>
        <?php endif; ?>
    </div>

    <a href="buscar_articulos.php">← Volver al listado</a>
</body>
</html>