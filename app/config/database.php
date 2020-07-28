<?php
header('charset=utf-8');

$host = 'localhost\SQLEXPRESS';
$database = 'nGestao3';
$user = 'sa';
$password = '0215@aaws';

try {
  $conexao = odbc_connect("Driver={SQL Server Native Client 11.0};Server=$host;Database=$database;", $user, $password);
} catch (Exception $e) {
  echo $e->getMessage();
  exit;
}
