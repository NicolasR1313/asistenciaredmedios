<?php
$servername = "localhost";
$username = "u566651163_Nicolas";
$password = "Semeolvido1011.";
$database = "u566651163_reconocimiento";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$sql = "SELECT id, email, hora_salida, imagen FROM registro_imagen ORDER BY hora_salida DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros de Salida</title>
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

        .record-card {
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

        .record-card img {
            border-radius: 8px;
            border: 2px solid #007BFF;
            margin-bottom: 15px;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        .record-card h3 {
            font-size: 24px;
            color: #333;
        }

        .record-card p {
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

        .btn {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h1>Registros de Salida</h1>

    <div class="container">
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="record-card">';

                $imageUrl = !empty($row['imagen']) 
                    ? $row['imagen'] 
                    : 'default-avatar.png';

                echo '<img src="' . htmlspecialchars($imageUrl) . '" alt="Imagen del Usuario">';

                echo "<h3>Correo Electrónico: " . htmlspecialchars($row['email']) . "</h3>";
                echo "<p>Hora de Salida: " . htmlspecialchars($row['hora_salida']) . "</p>";

                echo '</div>';
            }
        } else {
            echo "<p>No se encontraron registros de salida.</p>";
        }

        $conn->close();
        ?>
        <a href="mostrar.php" class="btn">Ver registros de entrada</a>
    </div>

    <div class="footer">
        <p>© 2024 Todos los derechos reservados</p>
    </div>

</body>
</html>
