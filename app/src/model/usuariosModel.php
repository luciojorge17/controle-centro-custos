<?php
function getUsuarios($condicao = NULL)
{
  require '../../config/database.php';
  $where = (!empty($condicao)) ? 'WHERE X_ATIVO = 1 AND ' . $condicao : 'WHERE X_ATIVO = 1';
  $sql = "SELECT CD_CODUSUARIO, DS_USUARIO FROM TBL_USUARIOS $where ORDER BY CD_CODUSUARIO ASC";
  $consulta = odbc_exec($conexao, $sql);
  $usuarios = [];
  while ($usuario = odbc_fetch_object($consulta)) {
    array_push($usuarios, [
      'cd_codusuario' => $usuario->CD_CODUSUARIO,
      'ds_usuario' => utf8_encode($usuario->DS_USUARIO)
    ]);
  }
  return $usuarios;
}

function getUsuarioById($id)
{
  require '../../config/database.php';
  $where = 'WHERE X_ATIVO = 1 AND CD_CODUSUARIO = ' . $id;
  $sql = "SELECT CD_CODUSUARIO, DS_USUARIO FROM TBL_USUARIOS $where ORDER BY CD_CODUSUARIO ASC";
  $consulta = odbc_exec($conexao, $sql);
  $dados = [];
  $usuario = odbc_fetch_object($consulta);
  if (!empty($usuario)) {
    $dados['status'] = 1;
    $dados['cd_codusuario'] = $usuario->CD_CODUSUARIO;
    $dados['ds_usuario'] = utf8_encode($usuario->DS_USUARIO);
  } else {
    $dados['status'] = 0;
  }
  return $dados;
}
