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
}
