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

function updateNewnorteOrcamentoAtual($update, $condicao)
{
  require '../../config/database.php';
  $sql = "UPDATE TBL_NEWNORTE_ORCAMENTO_ANUAL SET $update WHERE $condicao";
  $consulta = odbc_exec($conexao, $sql);
}

function atualizaTotalOrcamentoAtual($condicao)
{
  require '../../config/database.php';
  $sql = "UPDATE TBL_NEWNORTE_ORCAMENTO_ANUAL SET VL_TOTAL_ANO = (VL_MES_JAN+VL_MES_FEV+VL_MES_MAR+VL_MES_ABR+VL_MES_MAI+VL_MES_JUN+VL_MES_JUL+VL_MES_AGO+VL_MES_SET+VL_MES_OUT+VL_MES_NOV+VL_MES_DEZ) WHERE $condicao";
  $consulta = odbc_exec($conexao, $sql);
}

function insertManutencao($dados)
{
  require '../../config/database.php';
  $sql =
    "INSERT INTO dbo.TBL_NEWNORTE_MANUTENCAO_ORCAMENTO
    (DS_OPERACAO
    ,CD_CODUSUARIO_REALIZOU
    ,VL_VALOR
    ,DS_JUSTIFICATIVA
    ,CD_CENTRO_CUSTO_ORIGEM
    ,CD_CONTA_GERENCIAL_ORIGEM
    ,CD_CENTRO_CUSTO_DESTINO
    ,CD_CONTA_GERENCIAL_DESTINO)
VALUES
    ('$dados[0]'
    ,$dados[1]
    ,'$dados[2]'
    ,'$dados[3]'
    ,'$dados[4]'
    ,$dados[5]
    ,$dados[6]
    ,$dados[7])";
  odbc_exec($conexao, $sql);
}
