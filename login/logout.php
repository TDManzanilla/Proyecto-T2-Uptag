<?php

session_start();
include ('../app/config.php');
session_unset();
session_destroy();
header('Location: '.APP_URL.'/login');
