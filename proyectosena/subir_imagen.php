<?php
// Definir la carpeta donde se guardarán las imágenes
$uploadDir = 'uploads/';
$uploadFile = $uploadDir . basename($_FILES['image']['name']);

// Verificar si el archivo fue subido correctamente
if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
    // Devolver la URL del archivo subido
    echo json_encode([
        'success' => true,
        'url' => $uploadFile // La URL donde se guarda la imagen
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error al subir la imagen.'
    ]);
}
?>
