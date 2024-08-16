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
            $sentenciaSQL = $conexion -> prepare("INSERT INTO `pelotas` (nombre, imagen) VALUES (:nombre, :imagen);");
            $sentenciaSQL -> bindParam(':nombre', $txtNombre);
            $sentenciaSQL -> bindParam(':imagen', $txtImg);
            $sentenciaSQL -> execute();
            break;
        case "Modificar": 

            break;
        case "Cancelar": 
            
            break;
        case "Seleccionar": 
            break;
        case "Borrar": 
            $sentenciaSQL = $conexion -> prepare("DELETE FROM `pelotas` WHERE `pelotas`.`id` = :id");
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
                    <input type="hidden" class="form-control" name="txtID" id="txtID" placeholder="Ingrese el ID del producto">
                </div>
                <div class="form-group">
                    <label for="txtNombre">Nombre del producto:</label>
                    <input type="text" class="form-control" name="txtNombre" id="txtNombre" placeholder="Ingrese el nombre del producto" required>
                </div>
                <div class="form-group">
                    <label for="txtImg">Imágen:</label>
                    <input type="file" class="form-control" name="txtImg" id="txtImg" required>
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