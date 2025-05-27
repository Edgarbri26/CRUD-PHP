<?php
include 'conexion.php';

// Primero procesamos el formulario cuando se envía con POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['id']) && is_numeric($_POST['id']) &&
        isset($_POST['nombre']) && isset($_POST['email'])
    ) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];

        $stmt = $conn->prepare("UPDATE users SET nombre = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nombre, $email, $id);

        if ($stmt->execute()) {
            // Puedes redirigir con un mensaje
            header("Location: index.php?msg=actualizado");
            exit;
        } else {
            echo "Error al actualizar: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Datos inválidos.";
    }
    $conn->close();
    exit;
}

// Si no es POST, cargamos el formulario con datos actuales (GET)
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT nombre, email FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nombre, $email);
    if (!$stmt->fetch()) {
        echo "Usuario no encontrado.";
        exit;
    }
    $stmt->close();
} else {
    echo "ID inválido.";
    exit;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
</head>
<body>
    <h2>Editar Usuario</h2>
    <form method="POST" action="update.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <label for="nombre">Nombre:</label><br>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required><br><br>

        <label for="email">Correo Electrónico:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>

        <button type="submit">Actualizar</button>
    </form>
    <br>
    <a href="index.php">← Volver a la lista</a>
</body>
</html>
