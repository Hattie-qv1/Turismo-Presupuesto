
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Know-World</title>

    <link rel="stylesheet" href="./css/bootstrap.min.css" />

</head>
<body>
<?php $url="http://".$_SERVER['HTTP_HOST']."/phpmysql" ?>
    <nav class="navbar navbar-expand navbar-dark bg-primary">
        <ul class="nav navbar-nav">

            <li class="nav-item">
                <a class="nav-link" href="#">Know-World </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="index.php">Inicio</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="lugares.php">Lugares</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="nosotros.php">Nosotros</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url;?>/administrador/index.php">Login</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="c.php">Calificacion Lugares</a>
            </li>

        </ul>
    </nav>

    <div class="container">
        <br/><br/>
        <div class="row">