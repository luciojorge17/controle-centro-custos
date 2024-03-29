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

function getIdEmpresa($idFilial)
{
  require '../../config/database.php';
  $sql = "SELECT CD_EMPRESA FROM TBL_EMPRESAS_FILIAIS WHERE CD_FILIAL = $idFilial";
  $consulta = odbc_exec($conexao, $sql);
  $filial = odbc_fetch_object($consulta);
  return $filial->CD_EMPRESA;
}
