<?php
  if ($_POST) {
    header('Location:inicio.php');
  }
?>

<!doctype html>
<html lang="en">

<head>
  <title>Admin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
  <div class="container"> <!--b4-grid-default-->
    <div class="row md-4">
      <div class="col-md-4">
        
      </div>
      <div class="col-md-4">
        <br><br><br><br><br><br>
        <div class="card"> <!--b4-card-head-foot-->
          <div class="card-header">
            Login
          </div>
          <div class="card-body">
            <form action="" method="POST"> <!--!crt-form-login-->
              <div class="form-group">
                <label>Usuario</label>
                <input type="text" class="form-control" name="usernameAdmin" placeholder="Ingrese su nombre de usuario">
              </div>
              <div class="form-group">
                <label>Contraseña</label>
                <input type="password" class="form-control" name="passwordAdmin" placeholder="Ingrese su contraseña">
              </div>
              <button type="submit" class="btn btn-primary">Entrar al administrador</button>
            </form>


          </div>
        </div>
      </div>

    </div>
  </div>
</body>

</html>