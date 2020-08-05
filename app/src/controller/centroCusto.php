<?php
session_start();
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
require_once '../model/centroCustoModel.php';
require_once '../model/orcamentoModel.php';
$action = $_POST['action'];
switch ($action) {
  case 'buscarCentroCustos':
    $campo = (isset($_POST['slcCentroCustoCampo'])) ? $_POST['slcCentroCustoCampo'] : null;
    $texto = (isset($_POST['txtCentroCustoTexto'])) ? $_POST['txtCentroCustoTexto'] : null;
    if (empty($texto)) {
      $condicao = null;
    } else {
      $condicao = ($campo == 'centroCusto') ? "DS_CENTRO_CUSTO LIKE '%$texto%'" : "DS_CLASSIFICACAO LIKE '$texto%'";
    }
    $queryCentroCustos = getCentroCustos($condicao);
    echo json_encode($queryCentroCustos);
    break;
  case 'contasGerenciaisUsuarioCentroCusto':
    $idUsuario = $_POST['idUsuario'];
    $centroCusto = $_POST['idCentroCusto'];
    $filial = $_SESSION['filial'];
    $queryContasGerenciais = getContasGerenciaisUsuarioCentroCusto($idUsuario, $centroCusto, $filial);
    echo json_encode($queryContasGerenciais);
    break;
  case 'listarContasGerenciais':
    $campo = (isset($_POST['slcContaGerrencialCampo'])) ? $_POST['slcContaGerrencialCampo'] : null;
    $texto = (isset($_POST['txtContaGerencialTexto'])) ? $_POST['txtContaGerencialTexto'] : null;
    $centroCusto = (isset($_POST['idCentroCusto'])) ? $_POST['idCentroCusto'] : null;
    if (empty($texto)) {
      $condicao = (!empty($centroCusto)) ? "CD_CENTRO_CUSTO = $centroCusto" : null;
    } else {
      $condicao = ($campo == 'contaGerencial') ? "DS_CONTA_GERENCIAL LIKE '%$texto%'" : "DS_CLASSIFICACAO LIKE '$texto%'";
    }
    $queryContasGerenciais = getContasGerenciais($condicao);
    echo json_encode($queryContasGerenciais);
    break;
  case 'adicionarContasUsuario':
    $dados = [];
    foreach ($_POST['contas'] as $conta) {
      $dados[0] = '0';
      $dados[1] = '0';
      $dados[2] = $_SESSION['idUsuario'];
      $dados[3] = 1;
      $dados[4] = 1;
      $dados[5] = date('Y-m-d H:i:s') . '.000';
      $dados[6] = date('Y-m-d H:i:s') . '.000';
      $dados[7] = (!empty(getCentroCustoByContaGerencial($conta))) ? getCentroCustoByContaGerencial($conta) : 1;
      $dados[8] = $conta;
      insertUsuarioConta($dados);
    }
    break;
  case 'listarCentroCustosOrcamentoAnual':
    $ano = $_POST['ano'];
    $campo = $_POST['campo'];
    $pesquisa = $_POST['pesquisa'];
    $condicao = "NNOA.DT_ANO = '$ano'";
    if (!empty($pesquisa)) {
      $condicao .= ($campo == 'centroCusto') ? " AND TCCC.DS_CENTRO_CUSTO LIKE '%$pesquisa%'" : " AND TCCC.DS_CLASSIFICACAO LIKE '$pesquisa%'";
    }
    $queryCentroCustos = getCentroCustosOrcamentoAnual($condicao);
    echo json_encode($queryCentroCustos);
    break;
  case 'listarContasGerenciaisOrcamentoAnual':
    $mes = $_POST['mes'];
    $ano = $_POST['ano'];
    $campo = $_POST['campo'];
    $pesquisa = $_POST['pesquisa'];
    $centroCusto = $_POST['cdCentroCusto'];
    $colunaMes = '';
    switch ($mes) {
      case 1:
        $colunaMes = 'VL_MES_JAN';
        break;
      case 2:
        $colunaMes = 'VL_MES_FEV';
        break;
      case 3:
        $colunaMes = 'VL_MES_MAR';
        break;
      case 4:
        $colunaMes = 'VL_MES_ABR';
        break;
      case 5:
        $colunaMes = 'VL_MES_MAI';
        break;
      case 6:
        $colunaMes = 'VL_MES_JUN';
        break;
      case 7:
        $colunaMes = 'VL_MES_JUL';
        break;
      case 8:
        $colunaMes = 'VL_MES_AGO';
        break;
      case 9:
        $colunaMes = 'VL_MES_SET';
        break;
      case 10:
        $colunaMes = 'VL_MES_OUT';
        break;
      case 11:
        $colunaMes = 'VL_MES_NOV';
        break;
      case 12:
        $colunaMes = 'VL_MES_DEZ';
        break;
    }
    $condicao = "NNOA.DT_ANO = '$ano' AND NNOA.CD_CENTRO_CUSTO = $centroCusto";
    if (!empty($pesquisa)) {
      $condicao .= ($campo == 'contaGerencial') ? " AND TCCG.DS_CONTA_GERENCIAL LIKE '%$pesquisa%'" : " AND TCCG.DS_CLASSIFICACAO LIKE '$pesquisa%'";
    }
    $queryContasGerenciais = getContasGerenciaisOrcamentoAnual($condicao, $colunaMes);
    echo json_encode($queryContasGerenciais);
    break;
  case 'listarContasGerenciaisCentroCustoAnual':
    $filial = $_SESSION['filial'];
    $ano = $_POST['ano'];
    $centroCusto = $_POST['cdCentroCusto'];
    $condicao = "NNOA.DT_ANO = '$ano' AND NNOA.CD_CENTRO_CUSTO = $centroCusto";
    if ($filial > 0) {
      $condicao .= " AND NNOA.CD_FILIAL = $filial";
    }
    $queryContasGerenciais = getContasGerenciaisCentroCustoOrcamentoAnual($condicao);
    echo json_encode($queryContasGerenciais);
    break;
  case 'updateOrcamentoAnual':
    $usuarioAt = $_SESSION['idUsuario'];
    $data = date('Y-m-d H:i:s') . '.000';
    foreach (json_decode($_POST['update']) as $linha) {
      $condicao = "CD_ID = $linha[0]";
      $vl_jan = formataNumero($linha[1])/100;
      $vl_fev = formataNumero($linha[2])/100;
      $vl_mar = formataNumero($linha[3])/100;
      $vl_abr = formataNumero($linha[4])/100;
      $vl_mai = formataNumero($linha[5])/100;
      $vl_jun = formataNumero($linha[6])/100;
      $vl_jul = formataNumero($linha[7])/100;
      $vl_ago = formataNumero($linha[8])/100;
      $vl_set = formataNumero($linha[9])/100;
      $vl_out = formataNumero($linha[10])/100;
      $vl_nov = formataNumero($linha[11])/100;
      $vl_dez = formataNumero($linha[12])/100;
      $vl_total = $vl_jan + $vl_fev + $vl_mar + $vl_abr + $vl_mai + $vl_jun + $vl_jul + $vl_ago + $vl_set + $vl_out + $vl_nov + $vl_dez;
      $update = "VL_TOTAL_ANO = '$vl_total', VL_MES_JAN = '$vl_jan', VL_MES_FEV = '$vl_fev', VL_MES_MAR = '$vl_mar', VL_MES_ABR = '$vl_abr', VL_MES_MAI = '$vl_mai', VL_MES_JUN = '$vl_jun', VL_MES_JUL = '$vl_jul', VL_MES_AGO = '$vl_ago', VL_MES_SET = '$vl_set', VL_MES_OUT = '$vl_out', VL_MES_NOV = '$vl_nov', VL_MES_DEZ = '$vl_dez', CD_USUARIOAT = $usuarioAt, DT_ATUALIZACAO = '$data'";
      updateNewnorteOrcamentoAtual($update, $condicao);
    }
    echo json_encode(['status' => 1]);
    break;
}

function formataNumero($n)
{
  return str_replace('.', '', str_replace(',', '', $n));
}
