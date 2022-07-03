<?php include("../template/cabecera.php");  ?>
<?php
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$txtCosto=(isset($_POST['txtCosto']))?$_POST['txtCosto']:"";
$txtRegion=(isset($_POST['txtRegion']))?$_POST['txtRegion']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include("../config/bd.php");

switch ($accion) {
    case "Agregar":
        $sentenciaSQL= $conn->prepare("INSERT INTO lugares (Nombre,Imagen,Costo,Id_regiones) VALUES (:Nombre,:Imagen,:Costo,:Id_regiones);");
        $sentenciaSQL->bindParam(':Nombre',$txtNombre);

        $fecha=new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
        if ($tmpImagen!="") {
            move_uploaded_file($tmpImagen,"../../images/".$nombreArchivo);
        }

        $sentenciaSQL->bindParam(':Imagen',$nombreArchivo);
        $sentenciaSQL->bindParam(':Costo',$txtCosto);
        $sentenciaSQL->bindParam(':Id_regiones',$txtRegion);
        $sentenciaSQL->execute();

        header("Location:lugares.php");
        break;

    case "Modificar":
        //echo "Presionado boton Modificar";
        $sentenciaSQL= $conn->prepare("UPDATE lugares SET Nombre=:Nombre WHERE Id=:Id");
        $sentenciaSQL->bindParam(':Nombre',$txtNombre);
        $sentenciaSQL->bindParam(':Id',$txtID);
        $sentenciaSQL ->execute();

        if ($txtImagen!="") {

            $fecha=new DateTime();
            $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
            move_uploaded_file($tmpImagen,"../../images/".$nombreArchivo);

            $sentenciaSQL= $conn->prepare("SELECT Imagen FROM lugares WHERE Id=:Id");
            $sentenciaSQL->bindParam(':Id',$txtID);
            $sentenciaSQL ->execute();
            $lugares=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if (isset($lugar["Imagen"]) && ($lugar["Imagen"]!="imagen.jpg")) {

                if(file_exists("../../images/".$lugar["Imagen"])){

                    unlink("../../images/".$lugar["Imagen"]);
                }
            }

            $sentenciaSQL= $conn->prepare("UPDATE lugares SET Imagen=:Imagen WHERE Id=:Id");
            $sentenciaSQL->bindParam(':Imagen',$nombreArchivo);
            $sentenciaSQL->bindParam(':Id',$txtID);
            $sentenciaSQL ->execute();
        }

            $sentenciaSQL= $conn->prepare("UPDATE lugares SET Costo=:Costo WHERE Id=:Id");
            $sentenciaSQL->bindParam(':Costo',$txtCosto);
            $sentenciaSQL->bindParam(':Id',$txtID);
            $sentenciaSQL ->execute();

            $sentenciaSQL= $conn->prepare("UPDATE lugares SET Id_regiones=:Id_regiones WHERE Id=:Id");
            $sentenciaSQL->bindParam(':Id_regiones',$txtRegion);
            $sentenciaSQL->bindParam(':Id',$txtID);
            $sentenciaSQL ->execute();

        header("Location:lugares.php");
        break;

    case "Cancelar":
        //echo "Presionado boton cancelar";
        header("Location:lugares.php");
        break;

    case "Seleccionar":
        //echo "Presionado boton Seleccionar";
        $sentenciaSQL= $conn->prepare("SELECT * FROM lugares WHERE Id=:Id");
        $sentenciaSQL->bindParam(':Id',$txtID);
        $sentenciaSQL ->execute();
        $lugares=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre=$lugares['Nombre'];
        $txtImagen=$lugares['Imagen'];
        $txtCosto=$lugares['Costo'];
        $txtRegion=$lugares['Id_regiones'];
        break;

    case "Borrar":
        $sentenciaSQL= $conn->prepare("SELECT Imagen FROM lugares WHERE Id=:Id");
        $sentenciaSQL->bindParam(':Id',$txtID);
        $sentenciaSQL ->execute();
        $lugares=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if (isset($lugar["Imagen"]) && ($lugar["Imagen"]!="imagen.jpg")) {

            if(file_exists("../../images/".$lugar["Imagen"])){

                unlink("../../images/".$lugar["Imagen"]);
            }
        }
        $sentenciaSQL= $conn->prepare("DELETE FROM lugares WHERE Id=:Id");
        $sentenciaSQL->bindParam(':Id',$txtID);
        $sentenciaSQL ->execute();
        header("Location:lugares.php");
        //echo "Presionado boton Borrar";
        break;
}

$sentenciaSQL= $conn->prepare("SELECT * FROM lugares");
$sentenciaSQL ->execute();
$listaLugares=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="col-md-5">
    Formulario de agregar lugares

    <div class="card">
        <div class="card-header">
            Datos de Lugares
        </div>

        <div class="card-body">
        <form method="POST" enctype="multipart/form-data">

            <div class = "form-group">
            <label for="txtID">ID</label>
            <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
            </div>

            <div class = "form-group">
            <label for="txtNombre">Nombre:</label>
            <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtID" placeholder="Nombre">
            </div>

            <div class="form-group">
            <label for="txtImagen">Imagen</label>
            <br/>
            <?php
                if ($txtImagen!="") {
            ?>
                <img class="img-thumbnail rounded" src="../../images/<?php echo $txtImagen; ?>" width="50" alt="" srcset="">
            <?php }?>
            <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Imagen">
            </div>

            <div class = "form-group">
            <label for="txtCosto">Costo:</label>
            <input type="text" required class="form-control" value="<?php echo $txtCosto; ?>" name="txtCosto" id="txtID" placeholder="Costo">
            </div>
            
            <div class = "form-group">
            <label for="txtRegion">Region:</label>
            <select required class="form-control"  name="txtRegion" id="txtID" >
                <option value="">Seleccione Region</option>
                <?php
                    $sentenciaSQL= $conn->prepare("SELECT * FROM regiones");
                    $result=$sentenciaSQL->execute(array());
                    $row=$sentenciaSQL->fetchAll(\PDO::FETCH_BOTH);
                    if (count($row)) {
                        foreach ($row as $regiones) {
                ?>
                                        <option value="<?php echo $regiones['Id']; ?>"><?php echo $regiones['Nombre']; ?></option>
                            <?php
                                        }
                                    }else{
                                        echo "No existe";
                                    }
                            ?>                
                
            </select>
            </div>

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":""; ?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>
        </form>
        </div>
    </div>    
</div>


<div class="col-md-7">
    Tabla de lugares

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Costo</th>
                <th>Region</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php  foreach($listaLugares as $lugares) { ?>
            <tr>
                <td><?php echo $lugares['Id']?></td>
                <td><?php echo $lugares['Nombre']?></td>
                <td>
                    <img class="img-thumbnail rounded" src="../../images/<?php echo $lugares['Imagen']; ?>" width="50" alt="" srcset="">
                </td>
                <td><?php echo $lugares['Costo']?></td>
                <td><?php echo $lugares['Id_regiones']?></td>

                <td>
                    <form method="post">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $lugares['Id'];?>"/>
                        <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>
                        <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include("../template/pie.php");  ?>