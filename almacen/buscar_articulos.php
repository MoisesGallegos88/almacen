<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'conexion_db.php';

try {
    $search = isset($_POST['search']) ? "%{$_POST['search']}%" : '%';
    
    $sql = "SELECT a.*, m.nombre_material, a.activo 
    FROM Articulos a
    INNER JOIN Materiales m ON a.id_material = m.id
    WHERE a.nombre_articulo LIKE :search 
    OR a.id LIKE :search
    ORDER BY a.id DESC";
            
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':search', $search);
    $stmt->execute();
    
    $articulos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
        header('Content-Type: application/json');
        echo json_encode($articulos);
        exit;
    }
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscador de Artículos</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1200px; margin: 20px auto; padding: 20px; }
        .search-container { margin-bottom: 20px; }
        #searchInput { width: 300px; padding: 10px; font-size: 16px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .user-info { position: absolute; top: 20px; right: 20px; }
        .logout { color: #dc3545; text-decoration: none; }



        /* Agregar al CSS */
.btn-estado {
    padding: 5px 15px;
    border-radius: 15px;
    text-decoration: none;
    color: white;
    display: inline-block;
    text-align: center;
    min-width: 80px;
}

.en-stock { background-color: #28a745; }
.vendido { background-color: #dc3545; }


    </style>
</head>
<body>
    <div class="user-info">
        Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?>! 
        <a href="logout.php" class="logout">Cerrar Sesión</a>
    </div>

    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Buscar por ID, nombre o material...">
    </div>


    <div id="results">
        <table>
                    <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Material</th>
                    <th>Descripción</th>
                    <th>Fecha de ingreso</th>
                    <th>Costo</th> 
                    <th>Peso (g)</th> 
                    <th>Fecha Salida</th> 
                    <th>Estado</th> 

                </tr>
            </thead>


    <!-- En la sección PHP (parte estática) -->
    <tbody id="tableBody">
        <?php foreach ($articulos as $articulo): ?>
        <tr>
            <td><?= htmlspecialchars($articulo['id']) ?></td>
            <td><?= htmlspecialchars($articulo['nombre_articulo']) ?></td>
            <td><?= htmlspecialchars($articulo['nombre_material']) ?></td>
            <td><?= htmlspecialchars($articulo['descripcion']) ?></td>
            <td><?= date('d/m/Y H:i', strtotime($articulo['fecha_ingreso'])) ?></td>
            <td>$<?= number_format($articulo['costo_compra'], 2) ?></td>
            <td><?= number_format($articulo['peso_articulo'], 2) ?></td>
            <td><?= $articulo['fecha_salida'] ? date('d/m/Y H:i', strtotime($articulo['fecha_salida'])) : 'Pendiente' ?></td>
            <td>
                <a href="detalle_articulo.php?id=<?= $articulo['id'] ?>" 
                class="btn-estado <?= $articulo['activo'] ? 'en-stock' : 'vendido' ?>">
                    <?= $articulo['activo'] ? 'En stock' : 'Vendido' ?>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>



        </table>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('tableBody');
        
        function loadResults(search = '') {
            fetch('buscar_articulos.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `search=${encodeURIComponent(search)}&ajax=1`
            })
                        .then(response => response.json())
            // En la sección JavaScript (actualización dinámica)
            .then(data => {
                tableBody.innerHTML = data.map(articulo => `
                    <tr>
                        <td>${articulo.id}</td>
                        <td>${articulo.nombre_articulo}</td>
                        <td>${articulo.nombre_material}</td>
                        <td>${articulo.descripcion}</td>
                        <td>${articulo.fecha_ingreso ? new Date(articulo.fecha_ingreso).toLocaleString('es-MX') : 'N/A'}</td>
                        <td>$${parseFloat(articulo.costo_compra).toFixed(2)}</td>
                        <td>${parseFloat(articulo.peso_articulo).toFixed(2)}</td>
                        <td>${articulo.fecha_salida ? new Date(articulo.fecha_salida).toLocaleString('es-MX') : 'Pendiente'}</td>
                        <td>
                            <a href="detalle_articulo.php?id=${articulo.id}" 
                            class="btn-estado ${articulo.activo ? 'en-stock' : 'vendido'}">
                                ${articulo.activo ? 'En stock' : 'Vendido'}
                            </a>
                        </td>
                    </tr>
                `).join('');
            });
        }
        // Búsqueda en tiempo real
        searchInput.addEventListener('input', function() {
            loadResults(this.value);
        });
            // Actualizar cada 30 segundos
        setInterval(() => {
            if (!searchInput.value) loadResults();
        }, 3000);
    });
    </script>
</body>
</html>