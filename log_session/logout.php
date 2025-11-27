<?php
session_start();
session_destroy();
header("Location: ../game-home.php");
exit;
