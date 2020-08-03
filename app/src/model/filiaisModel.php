<?php
function getFiliais()
{
  require '../../config/database.php';
  $sql = "SELECT CD_FILIAL, DS_FILIAL FROM TBL_EMPRESAS_FILIAIS WHERE X_ATIVA = 1 ORDER BY CD_FILIAL ASC";
  $consulta = odbc_exec($conexao, $sql);
  $filiais = [];
  while ($filial = odbc_fetch_object($consulta)) {
    array_push($filiais, $filial);
  }
  return $filiais;
}
