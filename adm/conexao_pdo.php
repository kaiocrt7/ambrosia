<?php
$conn = new PDO('mysql:host=localhost;dbname=u768163069_san', "root", "");
$conn -> exec("SET CHARACTER SET utf8");

$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); 
?>