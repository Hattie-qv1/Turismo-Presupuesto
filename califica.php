<?php
include("administrador/config/bd.php");
?>

<?php
if (isset($_GET['t'],$_GET['id']) AND !empty($_GET['t']) AND !empty($_GET['id'])) {
  $getid=23;
  $gett=(int) $_GET['t'];
  

  $sentenciaSQL= $conn->prepare("SELECT Id FROM lugares WHERE Id=?");
  $sentenciaSQL->execute(array($getid));

  if ($sentenciaSQL->rowCount()==1) {
    if ($gett == 1) {
      $ins = $conn->prepare("INSERT INTO likes (lugar_id) VALUES (?)");
      $ins->execute(array($getid));
    }elseif ($gett == 2) {
      $ins = $conn->prepare("INSERT INTO dislikes (id_lugar) VALUES (?)");
      $ins->execute(array($getid));
    }
  }else{
    exit('Error fatal');
  }
}else{
  exit('Fatal Error');
}
?>


$sentenciaSQL->bindParam('lugar_id',$txtc);