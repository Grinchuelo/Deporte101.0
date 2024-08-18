<?php include("./template/header.php");?>

<?php
    include('admin/config/conexion.php');

    $sentenciaSQL = $conexion -> prepare("SELECT * FROM pelotas");
    $sentenciaSQL -> execute();
    $listaPelotas = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach($listaPelotas as $pelota) { ?>

<div class="col-md-3">
    <div class="card">
        <img class="card-img-top" src="<?php echo './img/'.$pelota['imagen']; ?>" alt="">
        <div class="card-body">
            <h4 class="card-title"><?php echo $pelota['nombre'] ?></h4>
            <p class="card-text text-success">Nuevo</p>
            <a name="" id="" class="btn btn-primary" href="#" role="button">Ver más</a>
        </div>
    </div>
</div>

<?php } ?>


<?php include("./template/footer.php"); ?>