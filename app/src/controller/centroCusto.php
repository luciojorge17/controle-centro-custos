<?php
session_start();
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
require_once '../model/centroCustoModel.php';
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
}
