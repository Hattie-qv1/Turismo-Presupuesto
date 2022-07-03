<?php include("template/cabecera.php"); ?>

<?php
include("administrador/config/bd.php");
include("califica.php");
?>

<?php
if (isset($_GET['Id']) AND !empty($_GET['Id'])) {
    print_r("xd");
    $get_id= htmlspecialchars($_GET['id']);

  
    $sentenciaSQL= $conn->prepare("SELECT * FROM lugares WHERE Id=?");
    $sentenciaSQL->execute(array($get_id));
  
    if ($sentenciaSQL->rowCount()==1) {
      $sentenciaSQL=$sentenciaSQL->fetch();
      $id=$sentenciaSQL['Id'];
      $nombre=$sentenciaSQL['Nombre'];
      $costo=$sentenciaSQL['Costo'];

      $likes = $conn->prepare("SELECT Id FROM likes WHERE lugar_id= ?");
      $likes->execute(array($id));
      $likes= $likes->rowCount();

      $dislikes = $conn->prepare("SELECT Id FROM dislikes WHERE lugar_id= ?");
      $dislikes->execute(array($id));
      $dislikes= $dislikes->rowCount();
    }else{
      exit('Error fatal');
    }
  }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Titulo</title>
    <meta charset="UTF-8">
</head>
<body>
    
<img src="./images/<?=$id?>" width="200" alt="" srcset="">
<h4 class="card-title"><?php $nombre ?></h4>
<h2 class="card-title">$<?php $costo ?></h2>

<a href="califica.php?t=1&id=<? $Id ?>">Me gusta</a> (<?= $likes ?>)
<a href="califica.php?t=2&id=<? $Id ?>">No me gusta</a> (<?= $dislikes ?>)

</body>
</html>



