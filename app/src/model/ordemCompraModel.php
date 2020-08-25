<?php
function getOrdensCompra($idUsuario)
{
  require '../../config/database.php';
  $sql =
    "SELECT SCOC.CD_ORDEM_COMPRA, SCOC.CD_FILIAL, SCOC.DT_EMISSAO, SCOC.DS_ENTIDADE, SCOC.VL_TOTAL 
      FROM SEL_COMPRAS_ORDEM_COMPRA AS SCOC 
        LEFT JOIN SEL_CUSTOS_DESDOBRADOS AS SCD ON SCD.CD_LANCAMENTO = SCOC.CD_ORDEM_COMPRA 
        LEFT JOIN TBL_NEWNORTE_CENTRO_CUSTO_USUARIO AS NCCU ON NCCU.CD_CENTRO_CUSTO = SCD.CD_CENTRO_CUSTO 
          WHERE SCD.CD_ORIGEM = 20 AND SCOC.CD_STATUS = 1 AND SCOC.CD_USUARIO_AUTORIZOU IS NULL AND SCOC.CD_USUARIO_REPROVOU IS NULL AND SCD.CD_CENTRO_CUSTO = NCCU.CD_CENTRO_CUSTO AND NCCU.CD_CODUSUARIO = $idUsuario 
            GROUP BY SCOC.CD_ORDEM_COMPRA, SCOC.CD_FILIAL, SCOC.DT_EMISSAO, SCOC.DS_ENTIDADE, SCOC.VL_TOTAL";
  $consulta = odbc_exec($conexao, $sql);
  $ordens = [];
  while ($ordem = odbc_fetch_object($consulta)) {
    array_push($ordens, [
      'cd_ordem_compra' => $ordem->CD_ORDEM_COMPRA,
      'cd_filial' => $ordem->CD_FILIAL,
      'dt_emissao' => date('d/m/Y', strtotime($ordem->DT_EMISSAO)),
      'ds_entidade' => utf8_encode($ordem->DS_ENTIDADE),
      'vl_total' => number_format($ordem->VL_TOTAL, 2, ',', '.')
    ]);
  }
  return $ordens;
}

function getObservacaoOrdemCompra($idOrdem)
{
  require '../../config/database.php';
  $sql = "SELECT DS_OBS FROM TBL_COMPRAS_ORDEM_COMPRA WHERE CD_ORDEM_COMPRA = $idOrdem";
  $consulta = odbc_exec($conexao, $sql);
  $ordem = odbc_fetch_object($consulta);
  $observacao = utf8_encode($ordem->DS_OBS);
  return $observacao;
}

function getItensOrdemCompra($idOrdem)
{
  require '../../config/database.php';
  $sql = "SELECT CD_ITEM, CD_MATERIAL, DS_MATERIAL, NR_QUANTIDADE, VL_UNITARIO, VL_TOTAL FROM SEL_COMPRAS_ORDEM_COMPRA_ITENS WHERE CD_ORDEM_COMPRA = $idOrdem";
  $consulta = odbc_exec($conexao, $sql);
  $itens = [];
  while ($item = odbc_fetch_object($consulta)) {
    array_push($itens, [
      'cd_item' => $item->CD_ITEM,
      'cd_material' => $item->CD_MATERIAL,
      'ds_material' => utf8_encode($item->DS_MATERIAL),
      'nr_quantidade' => number_format($item->NR_QUANTIDADE, 2, '.', ''),
      'vl_unitario' => number_format($item->VL_UNITARIO, 2, ',', '.'),
      'vl_total' => number_format($item->VL_TOTAL, 2, ',', '.')
    ]);
  }
  return $itens;
}

function getContasGerenciaisOrdemCompra($idOrdem)
{
  require '../../config/database.php';
  $sql =
    "SELECT 
      SCD.CD_ITEM, 
      SCD.CD_CENTRO_CUSTO, 
      SCD.DS_CENTRO_CUSTO,
      SCD.CD_CONTA_GERENCIAL, 
      CPCG.DS_CLASSIFICACAO, 
      CPCG.DS_CONTA_GERENCIAL,
        (SELECT TOP 1 
          CASE 
            WHEN MONTH(SCOC.DT_EMISSAO)=1 THEN VL_MES_JAN
            WHEN MONTH(SCOC.DT_EMISSAO)=2 THEN VL_MES_FEV
            WHEN MONTH(SCOC.DT_EMISSAO)=3 THEN VL_MES_MAR
            WHEN MONTH(SCOC.DT_EMISSAO)=4 THEN VL_MES_ABR
            WHEN MONTH(SCOC.DT_EMISSAO)=5 THEN VL_MES_MAI
            WHEN MONTH(SCOC.DT_EMISSAO)=6 THEN VL_MES_JUN
            WHEN MONTH(SCOC.DT_EMISSAO)=7 THEN VL_MES_JUL
            WHEN MONTH(SCOC.DT_EMISSAO)=8 THEN VL_MES_AGO
            WHEN MONTH(SCOC.DT_EMISSAO)=9 THEN VL_MES_SET
            WHEN MONTH(SCOC.DT_EMISSAO)=10 THEN VL_MES_OUT
            WHEN MONTH(SCOC.DT_EMISSAO)=11 THEN VL_MES_NOV
            WHEN MONTH(SCOC.DT_EMISSAO)=12 THEN VL_MES_DEZ
              END 
                FROM TBL_NEWNORTE_ORCAMENTO_ANUAL WHERE SCOC.CD_ORDEM_COMPRA = $idOrdem AND CPCG.CD_CONTA_GERENCIAL = CD_CONTA_GERENCIAL AND SCD.CD_CENTRO_CUSTO = CD_CENTRO_CUSTO) VL_LIMITE,
            ISNULL((SELECT 
              SUM(SCD01.VL_CUSTO) 
                FROM SEL_COMPRAS_ORDEM_COMPRA AS SCOC01
                  LEFT JOIN SEL_CUSTOS_DESDOBRADOS AS SCD01 ON SCD01.CD_LANCAMENTO = SCOC01.CD_ORDEM_COMPRA
                  LEFT JOIN SEL_CONTABIL_PLANO_CONTAS_GERENCIAL AS CPCG01 ON CPCG01.CD_CONTA_GERENCIAL = SCD01.CD_CONTA_GERENCIAL
                    WHERE SCOC01.CD_USUARIO_AUTORIZOU IS NOT NULL AND SCOC01.CD_USUARIO_REPROVOU IS NULL AND SCD01.CD_ORIGEM = 20 AND SCD01.CD_CONTA_GERENCIAL = SCD.CD_CONTA_GERENCIAL AND MONTH(SCOC01.DT_EMISSAO) = MONTH(SCOC.DT_EMISSAO)
                    GROUP BY SCD01.CD_CONTA_GERENCIAL),0) VL_UTILIZADO,
                ((SELECT TOP 1 
                  CASE 
                    WHEN MONTH(SCOC.DT_EMISSAO)=1 THEN VL_MES_JAN
                    WHEN MONTH(SCOC.DT_EMISSAO)=2 THEN VL_MES_FEV
                    WHEN MONTH(SCOC.DT_EMISSAO)=3 THEN VL_MES_MAR
                    WHEN MONTH(SCOC.DT_EMISSAO)=4 THEN VL_MES_ABR
                    WHEN MONTH(SCOC.DT_EMISSAO)=5 THEN VL_MES_MAI
                    WHEN MONTH(SCOC.DT_EMISSAO)=6 THEN VL_MES_JUN
                    WHEN MONTH(SCOC.DT_EMISSAO)=7 THEN VL_MES_JUL
                    WHEN MONTH(SCOC.DT_EMISSAO)=8 THEN VL_MES_AGO
                    WHEN MONTH(SCOC.DT_EMISSAO)=9 THEN VL_MES_SET
                    WHEN MONTH(SCOC.DT_EMISSAO)=10 THEN VL_MES_OUT
                    WHEN MONTH(SCOC.DT_EMISSAO)=11 THEN VL_MES_NOV
                    WHEN MONTH(SCOC.DT_EMISSAO)=12 THEN VL_MES_DEZ
                      END 
                        FROM TBL_NEWNORTE_ORCAMENTO_ANUAL WHERE SCOC.CD_ORDEM_COMPRA = $idOrdem AND CPCG.CD_CONTA_GERENCIAL = CD_CONTA_GERENCIAL AND SCD.CD_CENTRO_CUSTO = CD_CENTRO_CUSTO) -
                ISNULL((SELECT 
                  SUM(SCD01.VL_CUSTO) 
                    FROM SEL_COMPRAS_ORDEM_COMPRA AS SCOC01
                      LEFT JOIN SEL_CUSTOS_DESDOBRADOS AS SCD01 ON SCD01.CD_LANCAMENTO = SCOC01.CD_ORDEM_COMPRA
                      LEFT JOIN SEL_CONTABIL_PLANO_CONTAS_GERENCIAL AS CPCG01 ON CPCG01.CD_CONTA_GERENCIAL = SCD01.CD_CONTA_GERENCIAL
                        WHERE SCOC01.CD_USUARIO_AUTORIZOU IS NOT NULL AND SCOC01.CD_USUARIO_REPROVOU IS NULL AND SCD01.CD_ORIGEM = 20 AND  SCD01.CD_CONTA_GERENCIAL = SCD.CD_CONTA_GERENCIAL AND MONTH(SCOC01.DT_EMISSAO) = MONTH(SCOC.DT_EMISSAO)
                          GROUP BY SCD01.CD_CONTA_GERENCIAL),0)) VL_DISPONIVEL, SCD.VL_CUSTO VL_ORDEM_COMPRA
                      FROM SEL_COMPRAS_ORDEM_COMPRA AS SCOC
                        LEFT JOIN SEL_CUSTOS_DESDOBRADOS AS SCD ON SCD.CD_LANCAMENTO = SCOC.CD_ORDEM_COMPRA
                        LEFT JOIN SEL_CONTABIL_PLANO_CONTAS_GERENCIAL AS CPCG ON CPCG.CD_CONTA_GERENCIAL = SCD.CD_CONTA_GERENCIAL
                          WHERE SCD.CD_ORIGEM = 20 AND SCOC.CD_ORDEM_COMPRA = $idOrdem";
  $consulta = odbc_exec($conexao, $sql);
  $contas = [];
  while ($conta = odbc_fetch_object($consulta)) {
    array_push($contas, [
      'cd_centro_custo' => $conta->CD_CENTRO_CUSTO,
      'cd_conta_gerencial' => $conta->CD_CONTA_GERENCIAL,
      'ds_classificacao' => $conta->DS_CLASSIFICACAO,
      'ds_centro_custo' => utf8_encode($conta->DS_CENTRO_CUSTO),
      'ds_conta_gerencial' => utf8_encode($conta->DS_CONTA_GERENCIAL),
      'vl_limite' => number_format($conta->VL_LIMITE, 2, ',', '.'),
      'vl_utilizado' => number_format($conta->VL_UTILIZADO, 2, ',', '.'),
      'vl_disponivel' => number_format($conta->VL_DISPONIVEL, 2, ',', '.'),
      'vl_ordem_compra' => number_format($conta->VL_ORDEM_COMPRA, 2, ',', '.'),
    ]);
  }
  return $contas;
}

function autorizaOrdem($idOrdem, $idUsuario, $data)
{
  require '../../config/database.php';
  $sql = "UPDATE TBL_COMPRAS_ORDEM_COMPRA SET CD_USUARIO_AUTORIZOU = $idUsuario, DT_AUTORIZACAO = '$data' WHERE CD_ORDEM_COMPRA = $idOrdem";
  odbc_exec($conexao, $sql);
}

function reprovaOrdem($idOrdem, $idUsuario, $data)
{
  require '../../config/database.php';
  $sql = "UPDATE TBL_COMPRAS_ORDEM_COMPRA SET CD_USUARIO_REPROVOU = $idUsuario, DT_REPROVACAO = '$data' WHERE CD_ORDEM_COMPRA = $idOrdem";
  odbc_exec($conexao, $sql);
}

function getValidacaoUsuario($condicao)
{
  require '../../config/database.php';
  $sql = "SELECT * FROM TBL_NEWNORTE_CENTRO_CUSTO_USUARIO WHERE $condicao";
  $consulta = odbc_exec($conexao, $sql);
  return (odbc_num_rows($consulta) == 0) ? false : true;
}
