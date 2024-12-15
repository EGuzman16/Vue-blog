<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Maneja las solicitudes OPTIONS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Conecta a la base de datos con usuario, contraseña y nombre de la BD
$servidor = "localhost"; 
$usuario = "root"; 
$contrasenia = ""; 
$nombreBaseDatos = "vue_blog";
$conexionBD = new mysqli($servidor, $usuario, $contrasenia, $nombreBaseDatos);

// Verifica la conexión a la base de datos
if ($conexionBD->connect_error) {
    die("Conexión fallida: " . $conexionBD->connect_error);
}

// Función para manejar la respuesta JSON
function responder($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
}

// Función para generar un nombre de archivo único
function generarNombreArchivo($nombreOriginal) {
    $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
    $nombreBase = pathinfo($nombreOriginal, PATHINFO_FILENAME);
    $timestamp = date("YmdHis");
    return $nombreBase . "_" . $timestamp . "." . $extension;
}

// Autenticación de usuario
if (isset($_GET["tabla"]) && $_GET["tabla"] == "auth") {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $mail = $_POST['mail'];
        $password = $_POST['password'];

        $sql = mysqli_query($conexionBD, "SELECT * FROM user WHERE mail='$mail'");
        if (mysqli_num_rows($sql) > 0) {
            $usuario = mysqli_fetch_assoc($sql);
            if (password_verify($password, $usuario['password'])) {
                responder(["success" => 1, "message" => "Autenticación exitosa", "user" => $usuario]);
            } else {
                responder(["success" => 0, "message" => "Correo o contraseña incorrectos"]);
            }
        } else {
            responder(["success" => 0, "message" => "Correo o contraseña incorrectos"]);
        }
    }
}

// CRUD para la tabla `user`
if (isset($_GET["tabla"]) && $_GET["tabla"] == "user") {
    // Listar todos los usuarios
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET["id"])) {
        $sql = mysqli_query($conexionBD, "SELECT * FROM user");
        if (mysqli_num_rows($sql) > 0) {
            $usuarios = mysqli_fetch_all($sql, MYSQLI_ASSOC);
            responder($usuarios);
        } else {
            responder(["success" => 0, "message" => "No se encontraron usuarios"]);
        }
    }

    // Ver un usuario específico
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["id"])) {
        $id = $_GET["id"];
        $sql = mysqli_query($conexionBD, "SELECT * FROM user WHERE ID=$id");
        if (mysqli_num_rows($sql) > 0) {
            $usuario = mysqli_fetch_assoc($sql);
            responder($usuario);
        } else {
            responder(["success" => 0, "message" => "Usuario no encontrado"]);
        }
    }

    // Crear un nuevo usuario
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET["crear"])) {
        $nombre = $_POST['nombre'];
        $mail = $_POST['mail'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $avatar = $_FILES['avatar'];

        if ($nombre != "" && $mail != "" && $password != "" && $avatar['name'] != "") {
            $target_dir = "uploads/";
            $nombreArchivo = generarNombreArchivo($avatar["name"]);
            $target_file = $target_dir . $nombreArchivo;
            if (move_uploaded_file($avatar["tmp_name"], $target_file)) {
                $sql = mysqli_query($conexionBD, "INSERT INTO user(nombre, mail, password, avatar) VALUES('$nombre', '$mail', '$password', '$target_file')");
                if ($sql) {
                    responder(["success" => 1]);
                } else {
                    responder(["success" => 0, "message" => "Error al insertar en la base de datos: " . mysqli_error($conexionBD)]);
                }
            } else {
                responder(["success" => 0, "message" => "Error al subir el avatar"]);
            }
        } else {
            responder(["success" => 0, "message" => "Datos incompletos"]);
        }
    }

    // Actualizar un usuario
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET["actualizar"])) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $mail = $_POST['mail'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $avatar = isset($_FILES['avatar']) ? $_FILES['avatar'] : null;

        if ($avatar && $avatar['name'] != "") {
            $target_dir = "uploads/";
            $nombreArchivo = generarNombreArchivo($avatar["name"]);
            $target_file = $target_dir . $nombreArchivo;
            if (move_uploaded_file($avatar["tmp_name"], $target_file)) {
                // Obtener el avatar anterior
                $sqlImagen = mysqli_query($conexionBD, "SELECT avatar FROM user WHERE ID=$id");
                $avatarAnterior = mysqli_fetch_assoc($sqlImagen)['avatar'];

                // Actualizar el registro en la base de datos
                $sql = mysqli_query($conexionBD, "UPDATE user SET nombre='$nombre', mail='$mail', password='$password', avatar='$target_file' WHERE ID=$id");
                if ($sql) {
                    // Borrar el avatar anterior del servidor
                    if (file_exists($avatarAnterior)) {
                        unlink($avatarAnterior);
                    }
                    responder(["success" => 1]);
                } else {
                    responder(["success" => 0, "message" => "Error al actualizar en la base de datos: " . mysqli_error($conexionBD)]);
                }
            } else {
                responder(["success" => 0, "message" => "Error al subir el avatar"]);
            }
        } else {
            $sql = mysqli_query($conexionBD, "UPDATE user SET nombre='$nombre', mail='$mail', password='$password' WHERE ID=$id");
            if ($sql) {
                responder(["success" => 1]);
            } else {
                responder(["success" => 0, "message" => "Error al actualizar en la base de datos: " . mysqli_error($conexionBD)]);
            }
        }
    }

    // Borrar un usuario
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE' && isset($_GET["id"])) {
        $id = $_GET["id"];
        // Obtener el avatar antes de borrar
        $sqlImagen = mysqli_query($conexionBD, "SELECT avatar FROM user WHERE ID=$id");
        $avatar = mysqli_fetch_assoc($sqlImagen)['avatar'];

        // Borrar el registro de la base de datos
        $sql = mysqli_query($conexionBD, "DELETE FROM user WHERE ID=$id");
        if ($sql) {
            // Borrar el avatar del servidor
            if (file_exists($avatar)) {
                unlink($avatar);
            }
            responder(["success" => 1]);
        } else {
            responder(["success" => 0, "message" => "Error al borrar el usuario: " . mysqli_error($conexionBD)]);
        }
    }
}

// CRUD para la tabla `post`
if (isset($_GET["tabla"]) && $_GET["tabla"] == "post") {
    // Listar todos los posts
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET["id"])) {
        $sql = mysqli_query($conexionBD, "SELECT * FROM post");
        if (mysqli_num_rows($sql) > 0) {
            $posts = mysqli_fetch_all($sql, MYSQLI_ASSOC);
            responder($posts);
        } else {
            responder(["success" => 0, "message" => "No se encontraron posts"]);
        }
    }

    // Ver un post específico
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["id"])) {
        $id = $_GET["id"];
        $sql = mysqli_query($conexionBD, "SELECT * FROM post WHERE ID=$id");
        if (mysqli_num_rows($sql) > 0) {
            $post = mysqli_fetch_assoc($sql);
            responder($post);
        } else {
            responder(["success" => 0, "message" => "Post no encontrado"]);
        }
    }

    // Crear un nuevo post
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET["crear"])) {
        $titulo = $_POST['titulo'];
        $imagen = $_FILES['imagen'];
        $resumen = $_POST['resumen'];
        $descripcion = $_POST['descripcion'];
        $categoria = $_POST['categoria'];

        if ($titulo != "" && $resumen != "" && $descripcion != "" && $categoria != "" && $imagen['name'] != "") {
            $target_dir = "uploads/";
            $nombreArchivo = generarNombreArchivo($imagen["name"]);
            $target_file = $target_dir . $nombreArchivo;
            if (move_uploaded_file($imagen["tmp_name"], $target_file)) {
                $sql = mysqli_query($conexionBD, "INSERT INTO post(titulo, imagen, resumen, descripcion, categoria, fecha) VALUES('$titulo', '$target_file', '$resumen', '$descripcion', '$categoria', NOW())");
                if ($sql) {
                    responder(["success" => 1]);
                } else {
                    responder(["success" => 0, "message" => "Error al insertar en la base de datos: " . mysqli_error($conexionBD)]);
                }
            } else {
                responder(["success" => 0, "message" => "Error al subir la imagen"]);
            }
        } else {
            responder(["success" => 0, "message" => "Datos incompletos"]);
        }
    }

    // Actualizar un post
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET["actualizar"])) {
        $id = $_POST['id'];
        $titulo = $_POST['titulo'];
        $resumen = $_POST['resumen'];
        $descripcion = $_POST['descripcion'];
        $categoria = $_POST['categoria'];
        $imagen = isset($_FILES['imagen']) ? $_FILES['imagen'] : null;

        if ($imagen && $imagen['name'] != "") {
            $target_dir = "uploads/";
            $nombreArchivo = generarNombreArchivo($imagen["name"]);
            $target_file = $target_dir . $nombreArchivo;
            if (move_uploaded_file($imagen["tmp_name"], $target_file)) {
                // Obtener la imagen anterior
                $sqlImagen = mysqli_query($conexionBD, "SELECT imagen FROM post WHERE ID=$id");
                $imagenAnterior = mysqli_fetch_assoc($sqlImagen)['imagen'];

                // Actualizar el registro en la base de datos
                $sql = mysqli_query($conexionBD, "UPDATE post SET titulo='$titulo', resumen='$resumen', descripcion='$descripcion', categoria='$categoria', imagen='$target_file', fecha=NOW() WHERE ID=$id");
                if ($sql) {
                    // Borrar la imagen anterior del servidor
                    if (file_exists($imagenAnterior)) {
                        unlink($imagenAnterior);
                    }
                    responder(["success" => 1]);
                } else {
                    responder(["success" => 0, "message" => "Error al actualizar en la base de datos: " . mysqli_error($conexionBD)]);
                }
            } else {
                responder(["success" => 0, "message" => "Error al subir la imagen"]);
            }
        } else {
            $sql = mysqli_query($conexionBD, "UPDATE post SET titulo='$titulo', resumen='$resumen', descripcion='$descripcion', categoria='$categoria', fecha=NOW() WHERE ID=$id");
            if ($sql) {
                responder(["success" => 1]);
            } else {
                responder(["success" => 0, "message" => "Error al actualizar en la base de datos: " . mysqli_error($conexionBD)]);
            }
        }
    }

    // Borrar un post
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE' && isset($_GET["id"])) {
        $id = $_GET["id"];
        // Obtener la imagen antes de borrar
        $sqlImagen = mysqli_query($conexionBD, "SELECT imagen FROM post WHERE ID=$id");
        $imagen = mysqli_fetch_assoc($sqlImagen)['imagen'];

        // Borrar el registro de la base de datos
        $sql = mysqli_query($conexionBD, "DELETE FROM post WHERE ID=$id");
        if ($sql) {
            // Borrar la imagen del servidor
            if (file_exists($imagen)) {
                unlink($imagen);
            }
            responder(["success" => 1]);
        } else {
            responder(["success" => 0, "message" => "Error al borrar el post: " . mysqli_error($conexionBD)]);
        }
    }
}

// Si no se especifica una tabla, devolver un error
responder(["success" => 0, "message" => "Tabla no especificada"]);
?>