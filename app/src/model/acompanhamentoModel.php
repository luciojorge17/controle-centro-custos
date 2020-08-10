<?php
function getAcompanhamento($condicao, $mes)
{
  require '../../config/database.php';
  $where = "WHERE $condicao";
  $sql =
    "SELECT NNOA.CD_CONTA_GERENCIAL, TCCG.DS_CONTA_GERENCIAL, SUM(SCD.VL_CUSTO) UTILIZADO, NNOA.$mes LIMITE
      FROM TBL_NEWNORTE_ORCAMENTO_ANUAL NNOA
        inner JOIN TBL_CONTABIL_PLANO_CONTAS_GERENCIAL TCCG ON NNOA.CD_CONTA_GERENCIAL = TCCG.CD_CONTA_GERENCIAL
		    inner JOIN SEL_CUSTOS_DESDOBRADOS SCD ON SCD.CD_CONTA_GERENCIAL = NNOA.CD_CONTA_GERENCIAL
		    inner JOIN SEL_COMPRAS_ORDEM_COMPRA SCOC ON SCOC.CD_ORDEM_COMPRA = SCD.CD_LANCAMENTO AND SCD.CD_ORIGEM = 20
          $where
            GROUP BY TCCG.DS_CONTA_GERENCIAL, NNOA.CD_CONTA_GERENCIAL, NNOA.$mes";
  $consulta = odbc_exec($conexao, $sql);
  $dados = [];
  while ($linha = odbc_fetch_object($consulta)) {
    array_push($dados, [
      'cd_conta_gerencial' => $linha->CD_CONTA_GERENCIAL,
      'ds_conta_gerencial' => utf8_encode($linha->DS_CONTA_GERENCIAL),
      'utilizado' => number_format($linha->UTILIZADO, 2, ',', '.'),
      'limite' => number_format($linha->LIMITE, 2, ',', '.')
    ]);
  }
  return $dados;
}
function getAcompanhamentoDetalhes($condicao)
{
  require '../../config/database.php';
  $where = "WHERE $condicao";
  $sql =
    "SELECT SCOC.CD_ORDEM_COMPRA, SCOC.DS_ENTIDADE, SCD.DS_CENTRO_CUSTO, SCD.DS_CONTA_GERENCIAL, SCD.VL_CUSTO
      FROM SEL_COMPRAS_ORDEM_COMPRA SCOC
        INNER JOIN SEL_CUSTOS_DESDOBRADOS SCD ON SCD.CD_ORIGEM = 20 AND SCD.CD_LANCAMENTO = SCOC.CD_ORDEM_COMPRA
          $where";
  $consulta = odbc_exec($conexao, $sql);
  $dados = [];
  while ($linha = odbc_fetch_object($consulta)) {
    if(!isset($dados[utf8_encode($linha->DS_CONTA_GERENCIAL)])){
      $dados[utf8_encode($linha->DS_CONTA_GERENCIAL)] = [];
    }
    array_push($dados[utf8_encode($linha->DS_CONTA_GERENCIAL)], [
      'cd_ordem_compra' => $linha->CD_ORDEM_COMPRA,
      'ds_fornecedor' => utf8_encode($linha->DS_ENTIDADE),
      'valor' => number_format($linha->VL_CUSTO, 2, ',', '.')
    ]);
  }
  return $dados;
}
