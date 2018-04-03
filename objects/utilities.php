<?php

    function export_credits_csv() {}

    // Deberá servir tanto para usuarios como reseller.
    function disable_user(){}

    function logout() {
        session_start();
        $_SESSION['session_start'] = false;
        session_unset();
        session_destroy();
        session_write_close();
        setcookie(session_name(),'',0,'/');
        session_regenerate_id(true);

        header('Location: ../index.php');
    }