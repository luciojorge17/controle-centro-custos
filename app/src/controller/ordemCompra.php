<?php
session_start();
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
require_once '../model/ordemCompraModel.php';
$action = $_POST['action'];
switch ($action) {
  case 'listarOrdens':
    $idUsuario = $_SESSION['idUsuario'];
    $queryOrdens = getOrdensCompra($idUsuario);
    echo json_encode($queryOrdens);
    break;
  case 'listarItensOrdem':
    $idOrdem = $_POST['idOrdem'];
    $queryItens = getItensOrdemCompra($idOrdem);
    echo json_encode($queryItens);
    break;
  case 'listarContasGerenciaisOrdem':
    $idOrdem = $_POST['idOrdem'];
    $queryContasGerenciais = getContasGerenciaisOrdemCompra($idOrdem);
    echo json_encode($queryContasGerenciais);
    break;
  case 'getObservacaoOrdem':
    $idOrdem = $_POST['idOrdem'];
    $queryObs = getObservacaoOrdemCompra($idOrdem);
    echo json_encode($queryObs);
    break;
  case 'autorizar':
    $ordens = $_POST['ordens'];
    $idUsuario = $_SESSION['idUsuario'];
    foreach ($ordens as $ordem) {
      $data = date('d/m/Y H:i:s') . '.000';
      autorizaOrdem($ordem, $idUsuario, $data);
    }
    break;
  case 'reprovar':
    $ordens = $_POST['ordens'];
    $idUsuario = $_SESSION['idUsuario'];
    foreach ($ordens as $ordem) {
      $data = date('Y-m-d H:i:s') . '.000';
      reprovaOrdem($ordem, $idUsuario, $data);
    }
    break;
}
