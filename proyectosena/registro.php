<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "u566651163_Nicolas";
$password = "Semeolvido1011.";
$database = "u566651163_reconocimiento";

try {
    // Crear conexión
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verificar que $_POST no esté vacío
        if (empty($_POST)) {
            throw new Exception("No se recibieron datos en el formulario.");
        }

        // Recibir los datos del formulario
        $nombre = $_POST['nombre'] ?? null;
        $apellido = $_POST['apellido'] ?? null;
        $documento = $_POST['documento'] ?? null;
        $programa = $_POST['programa'] ?? null;
        $ficha = $_POST['ficha'] ?? null;
        $estado = $_POST['estado'] ?? null;
        $id_area = $_POST['id_area'] ?? null;
        $email = $_POST['email'] ?? null;
        $hora_registro = $_POST['hora_registro'] ?? null;
        $imagen_url = $_POST['imagen'] ?? null;

        // Verificar que los campos obligatorios no estén vacíos
        if (!$nombre || !$apellido || !$documento || !$programa || !$ficha || !$estado || !$id_area || !$email || !$hora_registro) {
            throw new Exception("Por favor, complete todos los campos obligatorios.");
        }

        // Iniciar una transacción
        $conn->beginTransaction();

        // Insertar datos en la tabla `usuarios`
        $sqlUsuario = "INSERT INTO usuarios (nombre, apellido, documento, programa, ficha, estado, id_area, email, hora_registro) 
                       VALUES (:nombre, :apellido, :documento, :programa, :ficha, :estado, :id_area, :email, :hora_registro)";
        $stmtUsuario = $conn->prepare($sqlUsuario);
        $stmtUsuario->bindParam(':nombre', $nombre);
        $stmtUsuario->bindParam(':apellido', $apellido);
        $stmtUsuario->bindParam(':documento', $documento);
        $stmtUsuario->bindParam(':programa', $programa);
        $stmtUsuario->bindParam(':ficha', $ficha);
        $stmtUsuario->bindParam(':estado', $estado);
        $stmtUsuario->bindParam(':id_area', $id_area);
        $stmtUsuario->bindParam(':email', $email);
        $stmtUsuario->bindParam(':hora_registro', $hora_registro);

        $stmtUsuario->execute();
        $usuarioId = $conn->lastInsertId(); // Obtener el ID del usuario recién insertado

        // Si hay una imagen, insertar en la tabla `imagenes`
        if ($imagen_url) {
            $sqlImagen = "INSERT INTO imagenes (usuario_id, url) VALUES (:usuario_id, :url)";
            $stmtImagen = $conn->prepare($sqlImagen);
            $stmtImagen->bindParam(':usuario_id', $usuarioId);  // Usar el ID del usuario
            $stmtImagen->bindParam(':url', $imagen_url);
            $stmtImagen->execute();
        }

        // Confirmar la transacción
        $conn->commit();

        // Redirigir al índice después de registrar
        header("Location: index.php");
        exit();
    }
} catch (Exception $e) {
    // Revertir la transacción si ocurrió un error
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión
$conn = null;
?>
