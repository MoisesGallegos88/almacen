<?php
session_start();
include 'conexion_db.php';

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Almacén</title>
    <style>
        :root {
            --color-primario: #2c3e50;
            --color-secundario: #3498db;
            --color-texto: #ffffff;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding-top: 60px;
            background-color: #f4f6f8;
        }

        .cabecera {
            position: fixed;
            top: 0;
            width: 100%;
            background: var(--color-primario);
            padding: 15px 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: var(--color-texto);
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
        }

        .navegacion {
            display: flex;
            gap: 25px;
            align-items: center;
        }

        .navegacion a {
            color: var(--color-texto);
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .navegacion a:hover {
            background: var(--color-secundario);
            transform: translateY(-2px);
        }

        .usuario-info {
            color: var(--color-texto);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .contenido-principal {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        .tarjeta {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .formulario-articulo {
            max-width: 600px;
            margin: 0 auto;
        }

        .campo-formulario {
            margin-bottom: 20px;
        }

        .campo-formulario label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #34495e;
        }

        .campo-formulario input,
        .campo-formulario select,
        .campo-formulario textarea {
            width: 100%;
            padding: 10px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .campo-formulario input:focus,
        .campo-formulario select:focus,
        .campo-formulario textarea:focus {
            border-color: var(--color-secundario);
            outline: none;
        }

        .boton-primario {
            background: #28a745;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .boton-primario:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0,0,0,0.2);
        }

        .mensaje-error {
            color: #dc3545;
            padding: 10px;
            margin: 15px 0;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            background: #f8d7da;
        }

        .mensaje-exito {
            color: #28a745;
            padding: 10px;
            margin: 15px 0;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            background: #d4edda;
        }
    </style>
</head>
<body>
    <header class="cabecera">
        <a href="index.php" class="logo">GestAlmacén</div>
        
        <nav class="navegacion">
            <a href="index.php">Inicio</a>
            <a href="buscar_articulos.php">Buscar Artículos</a>
            <a href="materiales.php">Gestión de Materiales</a>
            <?php if ($_SESSION['rol'] === 'admin'): ?>
                <a href="admin/registro.php">Registrar Usuarios</a>
            <?php endif; ?>
        </nav>

        <div class="usuario-info">
            <span>Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="logout.php" style="color: var(--color-texto);">Cerrar Sesión</a>
        </div>
    </header>

    <main class="contenido-principal">
        <div class="tarjeta">
            <h2>Registro de Nuevo Artículo</h2>
            
            <?php if (isset($_GET['success'])): ?>
                <div class="mensaje-exito">¡Artículo guardado correctamente!</div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="mensaje-error">Error: <?= htmlspecialchars($_GET['error']) ?></div>
            <?php endif; ?>

            <form class="formulario-articulo" action="guardar_articulo.php" method="POST">
                <div class="campo-formulario">
                    <label>Material:</label>
                    <select name="id_material" required>
                        <?php
                        try {
                            $sql = "SELECT id, nombre_material FROM Materiales";
                            $stmt = $conn->query($sql);
                            
                            if ($stmt->rowCount() > 0) {
                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='".htmlspecialchars($row['id'])."'>"
                                        .htmlspecialchars($row['nombre_material'])."</option>";
                                }
                            } else {
                                echo "<option value=''>No hay materiales registrados</option>";
                            }
                        } catch(PDOException $e) {
                            echo "<option value=''>Error cargando materiales: ".$e->getMessage()."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="campo-formulario">
                    <label>Nombre del artículo:</label>
                    <input type="text" name="nombre_articulo" required>
                </div>

                <div class="campo-formulario">
                    <label>Descripción:</label>
                    <textarea name="descripcion" rows="3"></textarea>
                </div>

                <div class="campo-formulario">
                    <label>Costo de compra:</label>
                    <input type="number" step="0.01" name="costo_compra" required>
                </div>

                <div class="campo-formulario">
                    <label>Peso (gramos):</label>
                    <input type="number" step="0.01" name="peso_articulo" required>
                </div>

                <button type="submit" class="boton-primario">Guardar Artículo</button>
            </form>
        </div>
    </main>
</body>
</html>