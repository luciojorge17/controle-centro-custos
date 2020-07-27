<?php
  session_start();
  $usuario = $_POST['txtUsuario'];
  $senha = $_POST['txtSenha'];
  echo json_encode(['status' => 0, 'mensagem' => 'Teste']);
?>