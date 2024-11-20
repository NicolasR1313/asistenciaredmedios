<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "u566651163_Nicolas";
$password = "Semeolvido1011.";
$database = "u566651163_reconocimiento";

try {
    // Crear conexión
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // Establecer el modo de error de PDO a excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recibir los datos del formulario
        $email = $_POST['email'];
        $hora_salida = $_POST['hora_salida'];
        $imagen = $_POST['imagen'];

        // Verificar que los campos no estén vacíos
        if (!empty($email) && !empty($hora_salida) && !empty($imagen)) {
            // Insertar datos en la tabla 'registro_imagen'
            $sql = "INSERT INTO registro_imagen (email, hora_salida, imagen) VALUES (:email, :hora_salida, :imagen)";
            $stmt = $conn->prepare($sql);
            
            // Asignar los valores a los parámetros
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':hora_salida', $hora_salida);
            $stmt->bindParam(':imagen', $imagen);
            
            // Ejecutar la consulta
            $stmt->execute();

            // Redirigir al índice después de registrar
            header("Location: inicio_sesion.php");
            exit();  // Asegúrate de que no se siga ejecutando el código después de la redirección
        } else {
            echo "Por favor, complete todos los campos.";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión
$conn = null;
?>
