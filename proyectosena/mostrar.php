<?php
$servername = "localhost";
$username = "u566651163_Nicolas";
$password = "Semeolvido1011.";
$database = "u566651163_reconocimiento";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener todos los datos de la base de datos
$sql = "SELECT id, documento, nombre, apellido, programa, ficha, estado, id_area FROM usuarios";
$result = $conn->query($sql);

// Consulta para obtener las URLs de las imágenes desde la tabla 'imagenes'
$imageQuery = "SELECT usuario_id, url FROM imagenes";
$imageResult = $conn->query($imageQuery);
$imagenes = [];

// Guardar las URLs de las imágenes en un arreglo asociativo
if ($imageResult->num_rows > 0) {
    while ($imageRow = $imageResult->fetch_assoc()) {
        $imagenes[$imageRow['usuario_id']] = $imageRow['url'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
        }

        h1 {
            color: #333;
            font-size: 32px;
            text-align: center;
            margin-bottom: 40px;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 80%;
            max-width: 900px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .user-card {
            background-color: #fff;
            border-radius: 10px;
            border: 1px solid #ccc;
            padding: 20px;
            margin: 20px 0;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .user-card img {
            border-radius: 50%;
            border: 2px solid #007BFF;
            margin-bottom: 15px;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        .user-card h3 {
            font-size: 24px;
            color: #333;
        }

        .user-card p {
            font-size: 18px;
            color: #555;
            margin: 10px 0;
        }

        .footer {
            margin-top: 40px;
            font-size: 14px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>

    <h1>Usuarios Registrados</h1>

    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="user-card">';
                // Verifica si existe una URL de imagen para el usuario
                if (isset($imagenes[$row['id']]) && !empty($imagenes[$row['id']])) {
                    echo '<img src="' . $imagenes[$row['id']] . '" alt="Imagen del Usuario">';
                } else {
                    echo '<img src="default-avatar.png" alt="Imagen por defecto">';
                }
                // Mostrar todos los datos del usuario
                echo "<h3>Nombre: " . $row['nombre'] . " " . $row['apellido'] . "</h3>";
                echo "<p>Documento: " . $row['documento'] . "</p>";
                echo "<p>Programa: " . $row['programa'] . "</p>";
                echo "<p>Ficha: " . $row['ficha'] . "</p>";
                echo "<p>Estado: " . $row['estado'] . "</p>";
                echo "<p>ID Área: " . $row['id_area'] . "</p>";
                echo '</div>';
            }
        } else {
            echo "<p>No se encontraron usuarios.</p>";
        }
        $conn->close();
        ?>
    </div>

    <div class="footer">
        <p>© 2024 Todos los derechos reservados</p>
    </div>

</body>
</html>
