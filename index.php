<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
</head>
    <body>
        <?php 
            include 'conexion.php';
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                $nombre = $_POST['nombre'];
                $email = $_POST['email'];
                $contrasenna = password_hash($_POST['contraseña'], PASSWORD_BCRYPT); // Encriptar la contraseña

                // Validar campos
                if (!empty($nombre) && !empty($email) && !empty($contrasenna)) {
                    // Preparar y ejecutar la consulta
                    $stmt = $conn->prepare("INSERT INTO users (nombre, email, contrasenna) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $nombre, $email, $contrasenna);
                    
                    if ($stmt->execute()) {
                        echo "Usuario registrado exitosamente.";
                    } else {
                        echo "Error al registrar usuario: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    echo "Todos los campos son obligatorios.";
                }
            }
        ?>
        <form method="post" class="contacto-form">
            <!-- Nombre-->
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
            <!-- Email-->
            <label for="email">Correo Electrónico:</label>
            <input type="text" id="email" name="email" required>
            <!-- telefono-->
            <label for="contraseña">contraseña:</label>
            <input type="password" id="contraseña" name="contraseña"  required>
            <!-- boton enviar-->
            <button type="submit" name= "registrar">Enviar</button>
        </form>

        <table>
            <tr-->
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th></th>
                <th></th>
            </tr>
            <?php
            include 'conexion.php';
            $sql = "SELECT id, nombre, email, contrasenna FROM users";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><a href="update.php?id=<?php echo $row['id']; ?>">Editar</a></td>
                        <td><a href="eliminar.php?id=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">Eliminar</a></td>

                <?php
                }
            } else {
                echo "<tr><td colspan='3'>No hay usuarios registrados.</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </body>
</html>