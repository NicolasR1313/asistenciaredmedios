<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Captura de Imagen y Registro</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }
        .container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        video {
            width: 320px;
            height: 240px;
            border: 2px solid #007BFF;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        canvas {
            display: none;
        }
        button, input {
            display: block;
            margin: 10px auto;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
        }
        button {
            background-color: #007BFF;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        input {
            width: 90%;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Captura de Imagen</h2>
        <video id="video" autoplay></video>
        <button id="capture">Capturar Imagen</button>
        <canvas id="canvas" width="320" height="240"></canvas>

        <h2>Formulario de Registro</h2>
        <form id="formRegistro" method="POST" action="registro.php">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="apellido" placeholder="Apellido" required>
            <input type="text" name="documento" placeholder="Documento" required>
            <input type="text" name="programa" placeholder="Programa" required>
            <input type="text" name="ficha" placeholder="Ficha" required>
            <input type="text" name="estado" placeholder="Estado" required>
            <input type="number" name="id_area" placeholder="ID del Área" required>
            <input type="email" name="email" placeholder="Correo Electrónico" required>
            <input type="text" name="hora_registro" id="horaRegistro" readonly required>
            <input type="hidden" name="imagen" id="imagenInput">
            <button type="submit">Registrar</button>
        </form>

        
        <button onclick="window.location.href='inicio_sesion.php'">Registrar salida</button>
    </div>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureButton = document.getElementById('capture');
        const imagenInput = document.getElementById('imagenInput');

     
        navigator.mediaDevices.getUserMedia({ video: true })
            .then((stream) => {
                video.srcObject = stream;
            })
            .catch((error) => {
                console.error("Error al acceder a la cámara:", error);
                alert("No se pudo acceder a la cámara.");
            });

        
        captureButton.addEventListener('click', async () => {
    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

   
    const imageBlob = await new Promise(resolve => canvas.toBlob(resolve, 'image/png'));

  
    const formData = new FormData();
    formData.append('image', imageBlob, 'captura.png');

    try {
        const response = await fetch('subir_imagen.php', {
            method: 'POST',
            body: formData,
        });
        const result = await response.json();

        if (result.success) {
            imagenInput.value = result.url;  // Aquí se guarda la URL de la imagen
            alert("Imagen capturada y subida con éxito.");
        } else {
            alert("Error al subir la imagen: " + result.message);
        }
    } catch (error) {
        console.error("Error al subir la imagen:", error);
        alert("Hubo un error al intentar subir la imagen.");
    }
});
    
        const fecha = new Date();
        const formatoHora = `${fecha.getFullYear()}-${(fecha.getMonth() + 1).toString().padStart(2, '0')}-${fecha.getDate().toString().padStart(2, '0')} ${fecha.getHours().toString().padStart(2, '0')}:${fecha.getMinutes().toString().padStart(2, '0')}:${fecha.getSeconds().toString().padStart(2, '0')}`;
        document.getElementById('horaRegistro').value = formatoHora;
    </script>
</body>
</html>
