<?php

    // PHP_HERE

    // Recuperando la sesión.
    session_start();

    /**
     * Validar si la variable $_SESSION['session_start'] a sido inicializada a TRUE.
     * 
     * if $_SESSION['session_start'] == TRUE
     *      imprime "Bienvenido"
     * else
     *      redirige al login
     */
    ($_SESSION['session_start']) ?  : header('Location: ../index.php');

    // Datos para la tabla ultimos usuarios.
    // include_once '../user/read_one.php';
    // $last_users_added = json_decode(get_last_users_added($_SESSION["reseller_name"], 5));
    $current_user = $_SESSION['reseller_name'];
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>Portfolio | Home</title>
    <meta name="viewport" content="width=device-width,user-scalable=no, initial-scale=1"/>
    <link rel="stylesheet" href="assets/css/normalize-8.0.0.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Roboto:300,400,500"/>
    <link rel="stylesheet" href="assets/css/fontello.css"/>
    <link rel="stylesheet" href="assets/css/styles2.css"/>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="barra-lateral col-12 col-sm-auto">
          <div class="logo">
            <h2>Dashboard</h2>
          </div>
          <nav class="menu d-flex d-sm-block justify-content-center flex-wrap">
            <a href="dashboard.php"> <i class="icon-home"></i><span>Home</span></a>
            <a href="read_users.php"> <i class="icon-users"></i><span>Users</span></a>
            <a href="configuration.php"> <i class="icon-cog"></i><span>Configuration</span></a>
            <a href="../reseller/logout.php"><i class="icon-login"></i><span>Logout</span></a>
          </nav>
        </div>
        <main class="col">
          <div class="row">
            <div class="col-12 bienvenida mb-5 p-2">
              <h3>Welcome  
                <span id="current user">
                    <strong>
                        <?php 
                            // PHP_HERE 
                            echo $_SESSION["reseller_name"];
                        ?>
                    </strong>
                </span>, to the Reseller Portal...</h3>
            </div>
            <div class="columna col-lg-12">
              <div class="widget nueva_entrada">
                <h3 class="titulo">Users panel</h3>
                <hr/>
                <div class="information d-flex justify-content-between">
                  <p>Create end-users for our Services.</p>
                  <div class="boton"><a class="btn btn-primary" href="create_user.php">Generate users </a></div>
                </div>
                <h4 class="titulo">List of created users</h4>
                <hr/>
                <div class="tabla">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Password</th>
                        <th scope="col">Credits</th>
                      </tr>
                    </thead>
                    <tbody id="users_list">
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="columna col-g-12">
              <nav aria-label="Page navigation" class="pages">
                <ul class="pagination" id="pagination_here">
                </ul>
              </nav>
            </div>
          </div>
        </main>
      </div>
    </div>
  </body>
  <script src="assets/js/jquery-3.1.1.min.js"></script>
  <script src="assets/js/tether.min.js"></script>
  <script src="assets/js/bootstrap.js"></script>

  <!--  -->
  <script>
      // Metodo momentaneo para obtener el nombre del usuario actual.
      var current_user ='<?php echo isset($_SESSION["reseller_name"]) ? $_SESSION["reseller_name"] : null; ?>';
  </script>
  <script src="assets/js/app.js"></script>
  <script src="assets/js/read_users.js"></script>
</html>