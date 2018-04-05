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

?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <title>Portfolio | Home</title>
        <meta name="viewport" content="width=device-width,user-scalable=no, initial-scale=1" />
        <link rel="stylesheet" href="assets/css/normalize-8.0.0.css">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
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
                        <a href="configuration.php"> <i class="icon-cog"></i><span>Configuration</span></a>
                        <a href="../reseller/logout.php"> <i class="icon-login"></i><span>Logout</span></a>
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
                                <h3 class="titulo">Configuration panel</h3>
                                <hr/>
                                <div class="information">
                                    <p>Edit Profile</p>
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
                        </div>
                        <div class="columna col-lg-7">
                            <div class="form-content">
                                <form action="#" method="post" id="update-user-form">
                                    <div class="row">
                                        <div class="col-md-5 col-lg-5 pr-1">
                                            <small class="form-group">
                                                <label>Prefix</label>
                                                <input id="text-upper" type="text" class="form-control" placeholder="Example: RTM-" name="user_prefix" maxlength="8" value="<?php echo $_SESSION["reseller_prefix"]; ?>" aria-describedby="prefixHelpBlock">
                                                <small id="prefixHelpBlock" class="form-text text-muted text-info">
                                                    Max length!
                                                </small>
                                                <input class="form-control invisible" type="hidden" id="res_name" value='<?php echo $_SESSION["reseller_name"]; ?>' name="reseller_name" />
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-info">Update Profile</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
    <script src="assets/js/jquery-3.1.1.min.js"></script>
    <script src="assets/js/tether.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>

    <script src="assets/js/app.js"></script>
    <script src="assets/js/configuration.js"></script>
    </html>