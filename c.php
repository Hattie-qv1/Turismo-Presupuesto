<?php include("template/cabecera.php"); ?>

<?php
include("administrador/config/bd.php");
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtc=(isset($_POST['txtc']))?$_POST['txtc']:"";



$sentenciaSQL= $conn->prepare("SELECT l.*, COUNT(li.lugar_id) as totalLikes, COUNT(dis.id_lugar) as totalDislikes FROM lugares l LEFT OUTER JOIN likes li ON l.Id = li.lugar_id LEFT OUTER JOIN dislike dis ON l.Id = dis.id_lugar GROUP BY l.Id, l.Nombre, l.Imagen, l.Costo, l.Id_regiones;");
$sentenciaSQL ->execute();
$listaLugares=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?>
       
        <?php  
            print_r($txtID);
            $sentenciaSQL= $conn->prepare("SELECT lugar_id, COUNT(lugar_id) as total FROM likes GROUP BY lugar_id");
            $result=$sentenciaSQL->execute();
            $row=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            
                foreach($listaLugares as $lugares) { ?>
            
                        <div class="col-md-3">
                        <div class="card">
                        <img class="card-img-top" src="./images/<?php echo $lugares['Imagen']; ?>" alt="">
                        <div class="card-body">
                        <h4 class="card-title"><?php echo $lugares['Nombre']; ?></h4>
                        <h2 class="card-title">$<?php echo $lugares['Costo']; ?></h2>

                        <a href="#">Me gusta</a> (<?php echo $lugares['totalLikes'] ?>)
                        <a href="#">No Me gusta</a> (<?php echo $lugares['totalDislikes'] ?>)
        </div>
        </div>
        </div>
            <?php }
        
        ?>
