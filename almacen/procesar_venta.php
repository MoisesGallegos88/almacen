<?php
session_start();
include 'conexion_db.php';

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn->beginTransaction();
        
        // Datos de la venta
        $id_articulo = filter_input(INPUT_POST, 'id_articulo', FILTER_VALIDATE_INT);
        $cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_VALIDATE_INT);
        $precio_unitario = filter_input(INPUT_POST, 'precio_unitario', FILTER_VALIDATE_FLOAT);
        $id_usuario = $_SESSION['user_id'];

        // Insertar en Ventas
        $sql = "INSERT INTO Ventas 
                (id_articulo, id_usuario, cantidad, precio_unitario)
                VALUES (:id_articulo, :id_usuario, :cantidad, :precio)";
        
        $stmt = $conn->prepare($sql);
        // Modificar la inserción:
            $stmt->execute([
                ':id_articulo' => $id_articulo,
                ':id_usuario' => $id_usuario,
                ':cantidad' => 1, // Cantidad fija
                ':precio' => $precio_unitario
            ]);

        $conn->commit();
        header("Location: detalle_articulo.php?id=$id_articulo");
        exit();

    } catch(PDOException $e) {
        $conn->rollBack();
        die("Error: " . $e->getMessage());
    }
}