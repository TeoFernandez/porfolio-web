<xaiArtifact artifact_id="62198dac-bd2d-4600-a630-1be8a5a3865f" artifact_version_id="c1f115c2-2fb0-4cbb-a540-46c9830b6a9a" title="contacto.php" contentType="text/php">
```php
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar el campo honeypot (debe estar vacío)
    if (!empty($_POST['honeypot'])) {
        http_response_code(403);
        header("Location: index.html?status=spam");
        exit;
    }

    // Sanitizar y validar los datos
    $nombre = filter_var(trim($_POST["nombre"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $mensaje = filter_var(trim($_POST["mensaje"]), FILTER_SANITIZE_STRING);

    if (empty($nombre) || empty($mensaje) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        header("Location: index.html?status=invalid");
        exit;
    }

    // Configuración del correo
    $destinatario = "teofernandez.work@gmail.com";
    $asunto = "Nuevo mensaje desde tu portafolio web";

    // Contenido del correo con codificación UTF-8
    $contenido = "Nombre: $nombre\n";
    $contenido .= "Email: $email\n\n";
    $contenido .= "Mensaje:\n$mensaje\n";

    // Cabeceras seguras
    $cabeceras = "MIME-Version: 1.0\r\n";
    $cabeceras .= "Content-type: text/plain; charset=UTF-8\r\n";
    $cabeceras .= "From: teofernandez@teofernandez.com.ar\r\n"; // Reemplaza con un email de tu dominio
    $cabeceras .= "Reply-To: $email\r\n";

    // Intentar enviar el correo
    if (mail($destinatario, $asunto, $contenido, $cabeceras)) {
        header("Location: index.html?status=success");
        exit;
    } else {
        // Registrar el error (opcional, para depuración en Hostinger)
        error_log("Error al enviar correo desde contacto.php: " . date('Y-m-d H:i:s'), 3, "error_log.txt");
        header("Location: index.html?status=error");
        exit;
    }
} else {
    http_response_code(403);
    header("Location: index.html?status=invalid");
    exit;
}
?>