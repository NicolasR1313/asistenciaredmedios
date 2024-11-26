<?php
$servername = "localhost";
$username = "u566651163_Nicolas";
$password = "Semeolvido1011.";
$database = "u566651163_reconocimiento";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $hora_salida = $_POST['hora_salida'];
        $imagen = $_POST['imagen'];

        if (!empty($email) && !empty($hora_salida) && !empty($imagen)) {
            $sql = "INSERT INTO registro_imagen (email, hora_salida, imagen) VALUES (:email, :hora_salida, :imagen)";
            $stmt = $conn->prepare($sql);
            
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':hora_salida', $hora_salida);
            $stmt->bindParam(':imagen', $imagen);
            
            $stmt->execute();

            header("Location: inicio_sesion.php");
            exit();
        } else {
            echo "Por favor, complete todos los campos.";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
