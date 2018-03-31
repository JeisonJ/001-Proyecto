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
    include_once '../user/read_one.php';
    $last_users_added = json_decode(get_last_users_added($_SESSION["reseller_name"], 5));

?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <title>Portfolio | Home</title>
        <meta name="viewport" content="width=device-width,user-scalable=no, initial-scale=1" />
        <link rel="stylesheet" href="http://localhost:4000/assets/css/bootstrap.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Roboto:300,400,500" />
        <link rel="stylesheet" href="assets/css/fontello.css" />
        <link rel="stylesheet" href="assets/css/styles2.css" />
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
                        <a href="#"> <i class="icon-cog"></i><span>Configuration</span></a>
                        <a href="#"> <i class="icon-login"></i><span>Logout</span></a>
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
                        <div class="columna col-lg-7">
                            <div class="widget nueva_entrada">
                                <h3 class="titulo">Information panel</h3>
                                <hr/>
                                <div class="information">
                                    <p>By using this portal you can create end-users for our services.</p>
                                </div>
                                <h4 class="titulo">Last 5 users created </h4>
                                <hr/>
                                <div class="tabla">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Username</th>
                                                <th scope="col">Password</th>
                                                <th scope="col">Credits</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                // PHP_HERE 
                                                foreach ($last_users_added as $user) {
                                                    echo "
                                                        <tr>
                                                            <td scope='row'>$user->user_id</td>
                                                            <td>$user->user_name</td>
                                                            <td>$user->user_pass</td>
                                                            <td>$user->user_credits</td>
                                                        </tr>
                                                    ";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="columna col-lg-5">
                            <div class="widget estadisticas">
                                <h4 class="titulo">Statistics</h4>
                                <div class="contenedor d-flex flex-wrap">
                                    <div class="caja">
                                        <h3>
                                            <?php 
                                                // PHP_HERE 
                                                echo $_SESSION['reseller_credits'];
                                            ?>
                                        </h3>
                                        <p>Credits</p>
                                    </div>
                                    <div class="caja">
                                        <h3>
                                            <?php 
                                                // PHP_HERE 
                                                echo $_SESSION['users_created'];
                                            ?>
                                        </h3>
                                        <p>Created users</p>
                                    </div>
                                </div>
                            </div>
                            <div class="widget comentarios">
                                <h4 class="titulo">Log (Last 5)</h4>
                                <div class="contenedor">
                                    <div class="comentario d-flex flex-wrap">
                                        <div class="texto alert alert-danger">
                                            <p class="texto-comentario">26-03-2018 1:31:36;::1;reseller: Failed to Login on the portal Failed to Login on the portal</p>
                                        </div>
                                        <div class="texto alert alert-success">
                                            <p class="texto-comentario">26-03-2018 2:30:51;186.95.192.103;jose;add;23;SAMUSER0143</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
    <script src="http://localhost:4000/assets/js/jquery-3.1.1.min.js"></script>
    <script src="http://localhost:4000/assets/js/tether.min.js"></script>
    <script src="http://localhost:4000/assets/js/bootstrap.js"></script>

    </html>