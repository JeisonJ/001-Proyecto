<?php
session_start();
echo "Bienvenido! ".$_SESSION["reseller_name"];
echo "\nTu password super segura es: ".$_SESSION["reseller_pass"];