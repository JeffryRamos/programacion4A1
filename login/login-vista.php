<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca Digital</title>
    
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    
    <link rel="shortcut icon" href="imagenes/logolink.png"/>
    <link rel="apple-touch-icon" href="imagenes/logolink.png">
    <link rel="stylesheet" href="icon/style.css">
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
    
<div class="container-form">
        <div class="header">
            <div class="logo-title">
                <img src="imagenes/logolink.png" alt="">
                <h2>Biblioteca Digital</h2>
            </div>
            <div class="menu">
            <a href="index.php"><li class="module-index">Pagina Principal</li></a>
            </div>
        </div>
        
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form">
            <div class="welcome-form"><h1>Iniciar Sesión</h1></div>
            <div class="user line-input">
                <label class="lnr lnr-user"></label>
                <input type="text" placeholder="Nombre Usuario" name="usuario">
            </div>
            <div class="password line-input">
                <label class="lnr lnr-lock"></label>
                <input type="password" placeholder="Contraseña" name="password">
            </div>
            
             <?php if(!empty($error)): ?>
            <div class="mensaje">
                <?php echo $error; ?>
            </div>
            <?php endif; ?>

            <a href="contra.html"><li class="contra">Se te olvidó la contraseña?</li></a>
            <button type="submit">Iniciar Sesión<label class="lnr lnr-chevron-right"></label></button>
        </form>
    </div>
    
    <script src="js/jquery.js"></script>
    <script src="js/script.js"></script>
</body>
</html>