<?php
$conn_pedido = new PDO('mysql:host=localhost;dbname=u768163069_sandi', "root", "");
$conn_pedido -> exec("SET CHARACTER SET utf8");

$conn_pedido -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
?>