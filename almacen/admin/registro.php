<?php
session_start();
include '../conexion_db.php';

// Verificar si es admin
if (!isset($_SESSION['logged_in']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$errores = [];
$exito = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $rol = $_POST['rol'];

    // Validaciones
    if (empty($username)) {
        $errores[] = "El nombre de usuario es requerido";
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido";
    }
    
    if (strlen($password) < 8) {
        $errores[] = "La contraseña debe tener al menos 8 caracteres";
    }
    
    if ($password !== $confirm_password) {
        $errores[] = "Las contraseñas no coinciden";
    }

    if (empty($errores)) {
        try {
            $stmt = $conn->prepare("SELECT id FROM usuarios WHERE nombre_usuario = :username OR email = :email");
            $stmt->execute([':username' => $username, ':email' => $email]);
            
            if ($stmt->rowCount() > 0) {
                $errores[] = "El usuario o email ya existen";
            } else {
                $password_hash = password_hash($password, PASSWORD_BCRYPT);
                
                $sql = "INSERT INTO usuarios (nombre_usuario, email, contrasena, rol) 
                        VALUES (:username, :email, :password, :rol)";
                
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':username' => $username,
                    ':email' => $email,
                    ':password' => $password_hash,
                    ':rol' => $rol
                ]);
                
                $exito = "Usuario registrado exitosamente";
            }
        } catch(PDOException $e) {
            $errores[] = "Error al registrar: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuarios (Admin)</title>
    <link rel="stylesheet" href="../estilos.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 20px;
        }

        .contenedor {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #34495e;
            font-weight: 500;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
            border-color: #3498db;
            box-shadow: 0 0 8px rgba(52, 152, 219, 0.2);
            outline: none;
        }

        button[type="submit"] {
            background: #3498db;
            color: white;
            padding: 14px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
        }

        button[type="submit"]:hover {
            background: #2874a6;
            transform: translateY(-2px);
        }

        .error {
            background: #fee;
            color: #e74c3c;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }

        .success {
            background: #e8f6ef;
            color: #28a745;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }

        .volver {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
        }
    </style>
</head>
<body>

<nav class="navegacion">
    <!-- Agrega "../" para subir un nivel desde admin/ -->
    <a href="../../index.php">Inicio</a>
    <a href="../../buscar_articulos.php">Buscar Artículos</a>
    <a href="../../materiales.php">Gestión de Materiales</a>
    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
        <a href="registro.php">Registrar Usuarios</a> <!-- Ya está en admin/ -->
    <?php endif; ?>
</nav>


    <div class="contenedor">
        <h2>Registro de Nuevo Usuario</h2>
        
        <?php if (!empty($errores)): ?>
            <div class="error">
                <?php foreach ($errores as $error): ?>
                    <p>• <?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($exito): ?>
            <div class="success">✔ <?= $exito ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label>Nombre de usuario</label>
                <input type="text" name="username" placeholder="Ingrese el nombre de usuario" required>
            </div>
            
            <div class="form-group">
                <label>Correo electrónico</label>
                <input type="email" name="email" placeholder="ejemplo@dominio.com" required>
            </div>
            
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" placeholder="Mínimo 8 caracteres" required>
            </div>
            
            <div class="form-group">
                <label>Confirmar Contraseña</label>
                <input type="password" name="confirm_password" placeholder="Repita la contraseña" required>
            </div>
            
            <div class="form-group">
                <label>Rol del usuario</label>
                <select name="rol" required>
                    <option value="admin">Administrador</option>
                    <option value="editor">Editor</option>
                    <option value="lector">Lector</option>
                </select>
            </div>
            
            <button type="submit">Registrar Usuario</button>
        </form>
        
        <a href="../dashboard.php" class="volver">← Volver al Panel de Control</a>
    </div>
</body>
</html>