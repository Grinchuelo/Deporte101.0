<!--Gestionar los productos CRUD (Create-Read-Update-Delete)-->
<?php include("../template/header.php"); ?>
<?php
    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
    $txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
    $txtImg = (isset($_FILES['txtImg']['name'])) ? $_FILES['txtImg']['name'] : "";
    $accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

    include("../config/conexion.php");

    switch($accion) {
        case "Agregar": 
            // INSERT INTO `pelotas` (`id`, `nombre`, `imagen`) VALUES (NULL, 'Pelota de basquet', 'basquet.jpg');
            $sentenciaSQL = $conexion -> prepare("INSERT INTO pelotas (nombre, imagen) VALUES (:nombre, :imagen);");
            $sentenciaSQL -> bindParam(':nombre', $txtNombre);

            // Subir archivo a carpeta local
            $fecha = new DateTime();
            $nombreArchivo = ($txtImg != "") ? $fecha -> getTimestamp()."_".$_FILES['txtImg']['name'] : "imagen.jpg";

            $tmpImg = $_FILES['txtImg']['tmp_name'];
            if ($tmpImg != "") {
                move_uploaded_file($tmpImg, "../../img/".$nombreArchivo);
            }

            $sentenciaSQL -> bindParam(':imagen', $nombreArchivo);
            //
            $sentenciaSQL -> execute();
            break;
        case "Modificar": 
            $sentenciaSQL = $conexion -> prepare("UPDATE pelotas SET nombre = :nombre WHERE id = :id;");
            $sentenciaSQL -> bindParam(':nombre', $txtNombre);
            $sentenciaSQL -> bindParam(':id', $txtID);
            $sentenciaSQL -> execute();
            
            if ($txtImg != "") {
                $sentenciaSQL = $conexion -> prepare("UPDATE pelotas SET imagen = :imagen WHERE id = :id;");
                $sentenciaSQL -> bindParam(':imagen', $txtImg);
                $sentenciaSQL -> bindParam(':id', $txtID);
                $sentenciaSQL -> execute();
            }


            break;
        case "Cancelar": 
            
            break;
        case "Seleccionar": 
            $sentenciaSQL = $conexion -> prepare("SELECT * FROM pelotas WHERE id = :id");
            $sentenciaSQL -> bindParam(':id', $txtID);
            $sentenciaSQL -> execute();

            $pelota = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
            $txtID = $pelota['id'];
            $txtNombre = $pelota['nombre'];
            $txtImg = $pelota['imagen'];

            break;
        case "Borrar": 
            // Obtiene la imagen
            $sentenciaSQL = $conexion -> prepare("SELECT imagen FROM pelotas WHERE id = :id");
            $sentenciaSQL -> bindParam(':id', $txtID);
            $sentenciaSQL -> execute();
            // Guarda el registro de ese ID dentro de $pelota
            $pelota = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            // Pregunta si existe la imagen
            if (isset($pelota['imagen']) && $pelota['imagen'] != "imagen.jpg") {
                // Busca la imagen en la carpeta
                if (file_exists("../../img/".$pelota['imagen'])) {
                    // Borra la imagen
                    unlink("../../img/".$pelota['imagen']);
                }
            }

            // Borrar el registro completo
            $sentenciaSQL = $conexion -> prepare("DELETE FROM pelotas WHERE id = :id");
            $sentenciaSQL -> bindParam(':id', $txtID);
            $sentenciaSQL -> execute();
            break;
    }

    $sentenciaSQL = $conexion -> prepare("SELECT * FROM pelotas");
    $sentenciaSQL -> execute();
    $listaPelotas = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="col-md-5">
    <!--Formulario para agregar productos-->
    <div class="card">
        <div class="card-header">
            Datos del producto
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="txtId">ID:</label>
                    <input type="text" value="<?php echo $txtID; ?>" class="form-control" name="txtID" id="txtID" placeholder="Ingrese el ID del producto">
                </div>
                <div class="form-group">
                    <label for="txtNombre">Nombre del producto:</label>
                    <input type="text" value="<?php echo $txtNombre; ?>" class="form-control" name="txtNombre" id="txtNombre" placeholder="Ingrese el nombre del producto">
                </div>
                <div class="form-group">
                    <label for="txtImg">Imágen:</label>
                    <?php echo $txtImg; ?>
                    <input type="file" class="form-control" name="txtImg" id="txtImg">
                </div>

                <div class="btn-group" role="group" aria-label=""> <!--b4-bgroup-default-->
                    <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" value="Modificar" class="btn btn-warning text-light">Modificar</button>
                    <button type="submit" name="accion" value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

</div>
<div class="col-md-7">
    <!--Mostrar la lista de los productos-->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imágenes</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaPelotas as $pelota) { ?>
            <tr>
                <td><?php echo $pelota['id']; ?></td>
                <td><?php echo $pelota['nombre']; ?></td>
                <td><?php echo $pelota['imagen']; ?></td>
                <td>

                <form method="post">
                    <input type="hidden" name="txtID" id="txtID" value="<?php echo $pelota['id']; ?>">
                    <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">
                    <input type="submit" name="accion" value="Borrar" class="btn btn-danger">
                </form>
            
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include("../template/footer.php"); ?>