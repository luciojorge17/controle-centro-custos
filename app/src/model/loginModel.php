<?php
function login($usuario, $senha)
{
  require_once '../../../config/database.php';
  $sql = "SELECT TOP 1 CD_CODUSUARIO, DS_LOGIN FROM TBL_USUARIOS WHERE X_ATIVO = 1 AND DS_LOGIN = '$usuario' AND DS_SENHA = '$senha' ORDER BY CD_CODUSUARIO ASC";
  $consulta = odbc_exec($conexao, $sql);
  if (odbc_num_rows($consulta) > 0) {
    return odbc_fetch_object($consulta);
  } else {
    return false;
  }
}
