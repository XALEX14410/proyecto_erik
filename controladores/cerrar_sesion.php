<?php
session_start();
session_destroy();
header("Location: /coordinadores_y_testigos/index.php");
exit;
?>