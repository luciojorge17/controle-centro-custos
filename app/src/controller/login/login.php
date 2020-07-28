<?php
session_start();
require_once '../../model/loginModel.php';
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
