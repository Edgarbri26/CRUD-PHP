<?php
include 'conexion.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php?msg=eliminado");
        exit;
    } else {
        echo "❌ Error al eliminar usuario: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "⚠️ ID no válido o no proporcionado.";
}

$conn->close();
?>
