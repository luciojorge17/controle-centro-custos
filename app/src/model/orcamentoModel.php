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

function getOrcamentoAnual($condicao = null)
{
  require '../../config/database.php';
  $where = (!empty($condicao)) ? 'WHERE ' . $condicao : '';
  $sql = "SELECT *
            FROM TBL_NEWNORTE_ORCAMENTO_ANUAL
                WHERE $condicao";
  $consulta = odbc_exec($conexao, $sql);
  $contasGerenciais = [];
  while ($cg = odbc_fetch_object($consulta)) {
    array_push($contasGerenciais, [
      'cd_empresa' => $cg->CD_EMPRESA,
      'cd_filial' => $cg->CD_FILIAL,
      'cd_centro_custo' => $cg->CD_CENTRO_CUSTO,
      'cd_conta_gerencial' => $cg->CD_CONTA_GERENCIAL,
      'ds_obs' => utf8_encode($cg->DS_OBS),
      'vl_total_ano' => number_format($cg->VL_TOTAL_ANO, 2, '.', ''),
      'vl_mes_jan' => number_format($cg->VL_MES_JAN, 2, '.', ''),
      'vl_mes_fev' => number_format($cg->VL_MES_FEV, 2, '.', ''),
      'vl_mes_mar' => number_format($cg->VL_MES_MAR, 2, '.', ''),
      'vl_mes_abr' => number_format($cg->VL_MES_ABR, 2, '.', ''),
      'vl_mes_mai' => number_format($cg->VL_MES_MAI, 2, '.', ''),
      'vl_mes_jun' => number_format($cg->VL_MES_JUN, 2, '.', ''),
      'vl_mes_jul' => number_format($cg->VL_MES_JUL, 2, '.', ''),
      'vl_mes_ago' => number_format($cg->VL_MES_AGO, 2, '.', ''),
      'vl_mes_set' => number_format($cg->VL_MES_SET, 2, '.', ''),
      'vl_mes_out' => number_format($cg->VL_MES_OUT, 2, '.', ''),
      'vl_mes_nov' => number_format($cg->VL_MES_NOV, 2, '.', ''),
      'vl_mes_dez' => number_format($cg->VL_MES_DEZ, 2, '.', '')
    ]);
  }
  return $contasGerenciais;
}

function insertContaOrcamento($dados)
{
  require '../../config/database.php';
  $sql =
    "INSERT INTO dbo.TBL_NEWNORTE_ORCAMENTO_ANUAL
    (CD_USUARIO,
    CD_USUARIOAT,
    CD_EMPRESA,
    CD_FILIAL,
    DT_ATUALIZACAO,
    DT_CADASTRO,
    DT_ANO,
    VL_TOTAL_ANO,
    VL_MES_JAN,
    VL_MES_FEV,
    VL_MES_MAR,
    VL_MES_ABR,
    VL_MES_MAI,
    VL_MES_JUN,
    VL_MES_JUL,
    VL_MES_AGO,
    VL_MES_SET,
    VL_MES_OUT,
    VL_MES_NOV,
    VL_MES_DEZ,
    CD_CENTRO_CUSTO,
    CD_CONTA_GERENCIAL,
    DS_OBS)
VALUES
    ($dados[0]
    ,$dados[1]
    ,$dados[2]
    ,$dados[3]
    ,'$dados[4]'
    ,'$dados[5]'
    ,'$dados[6]'
    ,'$dados[7]'
    ,'$dados[8]'
    ,'$dados[9]'
    ,'$dados[10]'
    ,'$dados[11]'
    ,'$dados[12]'
    ,'$dados[13]'
    ,'$dados[14]'
    ,'$dados[15]'
    ,'$dados[16]'
    ,'$dados[17]'
    ,'$dados[18]'
    ,'$dados[19]'
    ,$dados[20]
    ,$dados[21]
    ,'$dados[22]')";
  odbc_exec($conexao, $sql);
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
