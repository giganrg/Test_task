<!-- Connection for database -->

<?php
session_start();
$_SESSION['skus'] = array();
$conn = mysqli_connect("localhost", "root", "root", "scandiweb_db");
?>