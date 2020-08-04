<?php
function getCentroCustos($condicao = NULL)
{
  require '../../config/database.php';
  $where = (!empty($condicao)) ? 'WHERE X_ATIVO = 1 AND ' . $condicao : 'WHERE X_ATIVO = 1';
  $sql = "SELECT CD_CENTRO_CUSTO, DS_CLASSIFICACAO, DS_CENTRO_CUSTO, X_TIPO FROM TBL_CUSTOS_CENTRO_CUSTOS $where ORDER BY CD_CENTRO_CUSTO ASC";
  $consulta = odbc_exec($conexao, $sql);
  $centroCustos = [];
  while ($centroCusto = odbc_fetch_object($consulta)) {
    array_push($centroCustos, [
      'cd_centro_custo' => $centroCusto->CD_CENTRO_CUSTO,
      'ds_classificacao' => $centroCusto->DS_CLASSIFICACAO,
      'x_tipo' => $centroCusto->X_TIPO,
      'ds_centro_custo' => utf8_encode($centroCusto->DS_CENTRO_CUSTO)
    ]);
  }
  return $centroCustos;
}

function getContasGerenciais($condicao = NULL)
{
  require '../../config/database.php';
  $where = (!empty($condicao)) ? 'WHERE X_ATIVO = 1 AND ' . $condicao : 'WHERE X_ATIVO = 1';
  $sql = "SELECT CD_CONTA_GERENCIAL, DS_CONTA_GERENCIAL, DS_CLASSIFICACAO FROM TBL_CONTABIL_PLANO_CONTAS_GERENCIAL $where ORDER BY CD_CONTA_GERENCIAL ASC";
  $consulta = odbc_exec($conexao, $sql);
  $contasGerenciais = [];
  while ($cg = odbc_fetch_object($consulta)) {
    array_push($contasGerenciais, [
      'cd_conta_gerencial' => $cg->CD_CONTA_GERENCIAL,
      'ds_classificacao' => $cg->DS_CLASSIFICACAO,
      'ds_conta_gerencial' => utf8_encode($cg->DS_CONTA_GERENCIAL)
    ]);
  }
  return $contasGerenciais;
}

function getCentroCustosUsuario($idUsuario, $filial)
{
  require '../../config/database.php';
  $where = ($filial != 0) ? 'AND NCCU.CD_FILIAL = ' . $filial : '';
  $sql =
    "SELECT NCCU.CD_CENTRO_CUSTO, TCCC.DS_CENTRO_CUSTO 
      FROM TBL_NEWNORTE_CENTRO_CUSTO_USUARIO NCCU 
        INNER JOIN TBL_CUSTOS_CENTRO_CUSTOS TCCC ON NCCU.CD_CENTRO_CUSTO = TCCC.CD_CENTRO_CUSTO 
          WHERE CD_CODUSUARIO = $idUsuario $where
            GROUP BY TCCC.DS_CENTRO_CUSTO, NCCU.CD_CENTRO_CUSTO";
  $consulta = odbc_exec($conexao, $sql);
  $centroCustos = [];
  while ($centroCusto = odbc_fetch_object($consulta)) {
    array_push($centroCustos, [
      'cd_centro_custo' => $centroCusto->CD_CENTRO_CUSTO,
      'ds_centro_custo' => utf8_encode($centroCusto->DS_CENTRO_CUSTO)
    ]);
  }
  return $centroCustos;
}


function getContasGerenciaisUsuarioCentroCusto($idUsuario, $centroCusto, $filial)
{
  require '../../config/database.php';
  $where = ($filial != 0) ? 'AND NCCU.CD_FILIAL = ' . $filial : '';
  $sql =
    "SELECT NCCU.CD_FILIAL, NCCU.CD_CENTRO_CUSTO, NCCU.CD_CONTA_GERENCIAL, TCCC.DS_CENTRO_CUSTO, TCCG.DS_CLASSIFICACAO, TCCG.DS_CONTA_GERENCIAL
      FROM TBL_NEWNORTE_CENTRO_CUSTO_USUARIO NCCU
        INNER JOIN TBL_CUSTOS_CENTRO_CUSTOS TCCC ON NCCU.CD_CENTRO_CUSTO = TCCC.CD_CENTRO_CUSTO
        INNER JOIN TBL_CONTABIL_PLANO_CONTAS_GERENCIAL TCCG ON NCCU.CD_CONTA_GERENCIAL = TCCG.CD_CONTA_GERENCIAL
          WHERE NCCU.CD_CODUSUARIO = $idUsuario AND TCCC.CD_CENTRO_CUSTO = $centroCusto $where";
  $consulta = odbc_exec($conexao, $sql);
  $contasGerenciais = [];
  $contador = 1;
  while ($cg = odbc_fetch_object($consulta)) {
    array_push($contasGerenciais, [
      'item' => $contador,
      'cd_filial' => $cg->CD_FILIAL,
      'ds_centro_custo' => utf8_encode($cg->DS_CENTRO_CUSTO),
      'cd_conta_gerencial' => $cg->CD_CONTA_GERENCIAL,
      'ds_classificacao' => $cg->DS_CLASSIFICACAO,
      'ds_conta_gerencial' => utf8_encode($cg->DS_CONTA_GERENCIAL)
    ]);
    $contador++;
  }
  return $contasGerenciais;
}

function insertUsuarioConta($dados)
{
  require '../../config/database.php';
  $sql =
    "INSERT INTO dbo.TBL_NEWNORTE_CENTRO_CUSTO_USUARIO
      (CD_USUARIO
      ,CD_USUARIOAT
      ,CD_CODUSUARIO
      ,CD_EMPRESA
      ,CD_FILIAL
      ,DT_ATUALIZACAO
      ,DT_CADASTRO
      ,CD_CENTRO_CUSTO
      ,CD_CONTA_GERENCIAL)
    VALUES
      ($dados[0]
      ,$dados[1]
      ,$dados[2]
      ,$dados[3]
      ,$dados[4]
      ,'$dados[5]'
      ,'$dados[6]'
      ,$dados[7]
      ,$dados[8])";
  odbc_exec($conexao, $sql);
}

function getCentroCustoByContaGerencial($idConta)
{
  require '../../config/database.php';
  $sql = "SELECT CD_CENTRO_CUSTO FROM TBL_CONTABIL_PLANO_CONTAS_GERENCIAL WHERE CD_CONTA_GERENCIAL = $idConta";
  $consulta = odbc_exec($conexao, $sql);
  $resultado = odbc_fetch_object($consulta);
  return $resultado->CD_CENTRO_CUSTO;
}

function getCentroCustosOrcamentoAnual($condicao = null)
{
  require '../../config/database.php';
  $where = (!empty($condicao)) ? 'WHERE ' . $condicao : '';
  $sql =
    "SELECT NNOA.CD_CENTRO_CUSTO, TCCC.DS_CENTRO_CUSTO, TCCC.DS_CLASSIFICACAO, TCCC.X_TIPO 
	    FROM TBL_NEWNORTE_ORCAMENTO_ANUAL NNOA 
		    INNER JOIN TBL_CUSTOS_CENTRO_CUSTOS TCCC ON NNOA.CD_CENTRO_CUSTO = TCCC.CD_CENTRO_CUSTO
			    $where 
            GROUP BY NNOA.CD_CENTRO_CUSTO,  TCCC.DS_CENTRO_CUSTO, TCCC.DS_CLASSIFICACAO, TCCC.X_TIPO";
  $consulta = odbc_exec($conexao, $sql);
  $centroCustos = [];
  while ($centroCusto = odbc_fetch_object($consulta)) {
    array_push($centroCustos, [
      'cd_centro_custo' => $centroCusto->CD_CENTRO_CUSTO,
      'ds_classificacao' => $centroCusto->DS_CLASSIFICACAO,
      'x_tipo' => $centroCusto->X_TIPO,
      'ds_centro_custo' => utf8_encode($centroCusto->DS_CENTRO_CUSTO)
    ]);
  }
  return $centroCustos;
}

function getContasGerenciaisOrcamentoAnual($condicao = null, $campoMes)
{
  require '../../config/database.php';
  $where = (!empty($condicao)) ? 'WHERE ' . $condicao : '';
  $sql =
    "SELECT NNOA.CD_CONTA_GERENCIAL, TCCG.DS_CONTA_GERENCIAL, TCCG.DS_CLASSIFICACAO, TCCG.X_TIPO, NNOA.$campoMes
      FROM TBL_NEWNORTE_ORCAMENTO_ANUAL NNOA 
        INNER JOIN TBL_CONTABIL_PLANO_CONTAS_GERENCIAL TCCG ON NNOA.CD_CONTA_GERENCIAL = TCCG.CD_CONTA_GERENCIAL
          $where
            GROUP BY NNOA.CD_CONTA_GERENCIAL,  TCCG.DS_CONTA_GERENCIAL, TCCG.DS_CLASSIFICACAO, TCCG.X_TIPO, $campoMes";
  $consulta = odbc_exec($conexao, $sql);
  $contasGerenciais = [];
  while ($cg = odbc_fetch_object($consulta)) {
    array_push($contasGerenciais, [
      'cd_conta_gerencial' => $cg->CD_CONTA_GERENCIAL,
      'ds_classificacao' => $cg->DS_CLASSIFICACAO,
      'x_tipo' => $cg->X_TIPO,
      'ds_conta_gerencial' => utf8_encode($cg->DS_CONTA_GERENCIAL),
      'valor_atual' => number_format($cg->$campoMes, 2, ',', '.')
    ]);
  }
  return $contasGerenciais;
}
