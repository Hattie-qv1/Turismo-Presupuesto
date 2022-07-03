<?php include("template/cabecera.php"); ?>

<?php
include("administrador/config/bd.php");
?>

    <div class="col-12 grid-margin">
        <div class="card">
            <h4 class="card-title">Buscador</h4>
            <form  method="POST" action="">
                <div class="col-12 row">
                    <div class="mb-3">
                        <label  class="form-label">Ingrese cantidad:</label>
                        <input type="text" class="form-control" name="buscar" value="">  
                        <input type="submit" class="btn btn-success" name="enviar" value="Ver" >   
                        </div>
                    </div>
            </form>
        </div>
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
                                        <option value="<?php echo $regiones['Id']; ?>" name="buscarR"><?php echo $regiones['Nombre']; ?></option>
                            <?php
                                        }
                                    }else{
                                        echo "No existe";
                                    }
                            ?>                
                <input type="submit" class="btn btn-success" name="enviar" value="Buscar" >  
            </select>
            </div>
<?php

    if ($_POST) {
        $buscar= $_POST['buscar'];
        $sentenciaSQL= $conn->prepare("SELECT * FROM lugares WHERE Costo<=:buscar");
        $result=$sentenciaSQL->execute(array(':buscar'=>$buscar));
        $row=$sentenciaSQL->fetchAll(\PDO::FETCH_BOTH);
        
        if (count($row)) {

            foreach ($row as $lugares) {
?>
        <div class="col-md-3">
        <div class="card">
        <img class="card-img-top" src="./images/<?php echo $lugares['Imagen']; ?>" alt="">
            <div class="card-body">
            <h4 class="card-title"><?php echo $lugares['Nombre']; ?></h4>
            <h2 class="card-title">$<?php echo $lugares['Costo']; ?></h2>
            <a name="" id="" class="btn btn-primary" href="#" role="button">Seleccionar</a>
        </div>
        </div>
        </div>
<?php
            }
        }else{
            echo "No existe";
        }
    }


?>






<?php include("template/pie.php"); ?>