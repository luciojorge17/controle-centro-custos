<?php
session_start();
require_once '../model/usuariosModel.php';
$action = $_POST['action'];
switch ($action) {
  case 'buscarUsuarios':
    $campo = (isset($_POST['slcUsuarioCampo'])) ? $_POST['slcUsuarioCampo'] : null;
    $texto = (isset($_POST['txtUsuarioTexto'])) ? $_POST['txtUsuarioTexto'] : null;
    if (empty($texto)) {
      $condicao = null;
    } else {
      $condicao = ($campo == 'login') ? "DS_LOGIN LIKE '%$texto%'" : "DS_USUARIO LIKE '%$texto%'";
    }
    $queryUsuarios = getUsuarios($condicao);
    echo json_encode($queryUsuarios);
    break;
}
