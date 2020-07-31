<?php
session_start();
require_once '../model/loginModel.php';
$action = $_POST['action'];
switch ($action) {
  case 'login':
    $usuario = $_POST['txtUsuario'];
    $senha = $_POST['txtSenha'];
    $queryUsuario = login($usuario, $senha);
    if ($queryUsuario !== false) {
      $_SESSION['idUsuario'] = $queryUsuario->CD_CODUSUARIO;
      $_SESSION['nomeUsuario'] = $queryUsuario->DS_LOGIN;
      $_SESSION['filial'] = 0;
      echo json_encode(['status' => 1]);
    } else {
      echo json_encode(['status' => 0, 'mensagem' => 'Usuário não encontrado']);
    }
    break;
  case 'logoff':
    session_destroy();
    break;
  case 'trocarFilial':
    $filial = $_POST['filial'];
    $_SESSION['filial'] = $filial;
    break;
}
