<?php
session_start();
unset($_SESSION['logged']);
unset($_SESSION['loginTime']);
unset($_SESSION['userId']);
session_destroy();
header("location:../");