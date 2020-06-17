<?php 
    include 'private/login/cod_registro.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="shortcut icon" href="imagenes/logolink.png"/>
    <link rel="apple-touch-icon" href="imagenes/logolink.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/estilos.css">
    <link rel="stylesheet" href="public/alertifyjs/css/alertify.min.css">
    <link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

</head>
<body class="img-background">
    <a href="index.php" class="btn btn-info col-md-1 text-light active" role="button" aria-pressed="true"><i class="fas fa-reply"></i> Volver</a>
    <div class="modal-dialog text-center">
        <div class="col-sm-8 main-section">
            <div class="modal-content">
                <div class=" col-12 user-img">
                    <img src="public/img/usuario.png" alt="">
                </div>
                <div class="text-center bot">
                    <h2>REGISTRO</h2>
                </div>
                <form class="col-12 margin-title" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                          <input type="text" class="form-control" placeholder="Nombre" name="NombreUser">
                          <span class="msg-error"><?php echo $NombreUser_error?></span>
                        </div>
                        <div class="form-group col-md-6">
                          <input type="text" class="form-control" placeholder="Apellido" name="ApellidoUser">
                          <span class="msg-error"></span>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="inputEmail4" placeholder="Correo" name="email">
                            <span class="msg-error"></span>
                        </div>
                        <div class="form-group" id="user-group">
                            <input type="text" class="form-control" placeholder="Nombre de usuario" name="username"/>
                            <span class="msg-error"></span>
                        </div>
                        <div class="form-group" id="contrasena-group">
                            <input type="password" class="form-control" placeholder="Contraseña" name="password"/>
                            <span class="msg-error"></span>
                        </div>
                    </div>
                    <button type="button" class="btn btn-info">REGISTRARSE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.dev.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>