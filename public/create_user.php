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

        <div class="columna col-12">
          <!-- Modal -->
          <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Aviso!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <h5 id="modal-body-text"></h5> 
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="barra-lateral col-12 col-sm-auto">
          <div class="logo">
            <h2>Dashboard</h2>
          </div>
          <nav class="menu d-flex d-sm-block justify-content-center flex-wrap">
            <a href="dashboard.php"> <i class="icon-home"></i><span>Home</span></a>
            <a href="read_users.php"> <i class="icon-users"></i><span>Users</span></a>
            <a href="#"> <i class="icon-cog"></i><span>Configuration</span></a>
            <a href="#"> <i class="icon-login"></i><span>Logout</span></a></nav>
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
            </div>
            <div class="columna col-lg-7">
              <div class="widget nueva_entrada">
                <h3 class="titulo">Generate end users</h3>
                <hr/>
                <div class="alert alert-info">
                  <p>Enter the number of users to generate and the credits you want to assign.</p>
                </div>
              </div>
            </div>
            <div class="columna col-lg-5">
              <div class="widget estadisticas">
                <h4 class="titulo">Available credits</h4>
                <div class="contenedor d-flex flex-wrap">
                  <div class="caja">
                    <h3 id="reseller_credits">
                      <?php 
                          // PHP_HERE 
                          echo $_SESSION['reseller_credits'];
                      ?>
                    </h3>
                    <p>Credits</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="columna col-lg-12">
              <div class="form-content">
                <form id="create_users_form" action="#" method="post">
                  <div class="form-row d-flex justify-content-center flex-wrap">
                    <div class="col-auto ml-2 mb-2">
                      <label class="sr-only" for="">Cantidad</label>
                      <input class="form-control" type="number" min="1" value="1" id="u_quantity" name="users_quantity" placeholder="number of users"/><small class="form-text text-muted" id="emailHelp">How many users do you want to create?</small>
                    </div>
                    <div class="col-auto ml-2 mb-2">
                      <label class="sr-only" for="">Credits</label>
                      <input class="form-control" type="number" min="1" value="1" id="a_credits" name="assigned_credits" placeholder="credits"/><small class="form-text text-muted" id="emailHelp">How many credits do you want to assign?</small>
                    </div>
                      <input class="form-control invisible" type="hidden" value='<?php echo $_SESSION["reseller_name"]; ?>' name="reseller_name" />
                    <div class="col-auto ml-2 mb-2">
                      <label class="sr-only" for="">Cantidad</label>
                      <button class="btn btn-primary" id="btn_create_users" type="submit">Generate</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="columna col-lg-12">
              <div class="widget nueva_entrada mt-4">
                <h4 class="titulo">Last 5 users created </h4>
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
              <nav aria-label="Page navigation">
                <ul class="pagination">
                  <li class="page-item"><a class="page-link" href="">Previous</a></li>
                  <li class="page-item"><a class="page-link" href="">1</a></li>
                  <li class="page-item"><a class="page-link" href="">2</a></li>
                  <li class="page-item"><a class="page-link" href="">Next</a></li>
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
      var r_credits ='<?php echo isset($_SESSION["reseller_credits"]) ? $_SESSION["reseller_credits"] : null; ?>';
  </script>
  <script src="assets/js/app.js"></script>
  <script src="assets/js/create_user.js"></script>
</html>