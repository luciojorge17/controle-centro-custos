<?php
function getAnos()
{
  require '../../config/database.php';
  $sql = "SELECT DT_ANO FROM TBL_NEWNORTE_ORCAMENTO_ANUAL GROUP BY DT_ANO";
  $consulta = odbc_exec($conexao, $sql);
  $anos = [];
  while ($ano = odbc_fetch_object($consulta)) {
    array_push($anos, $ano);
  }
  return $anos;
}
