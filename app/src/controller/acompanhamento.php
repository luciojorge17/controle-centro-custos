<?php
session_start();
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
require_once '../model/acompanhamentoModel.php';
require_once '../model/filiaisModel.php';
require_once '../model/centroCustoModel.php';
$action = $_POST['action'];
switch ($action) {
  case 'visaoGeral':
    $idCentroCusto = $_POST['centroCusto'];
    $idUsuario = $_SESSION['idUsuario'];
    $ano = $_POST['ano'];
    $mes = $_POST['mes'];
    $filial = $_SESSION['filial'];
    $queryContasUsuario = getContasGerenciaisUsuarioCentroCusto($idUsuario, $idCentroCusto, $filial);
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
    $condicao = "NNOA.CD_CENTRO_CUSTO = $idCentroCusto AND NNOA.DT_ANO = '$ano' AND SCD.CD_ORIGEM = 20 AND SCOC.CD_USUARIO_AUTORIZOU IS NOT NULL AND CD_USUARIO_REPROVOU IS NULL AND SCOC.CD_STATUS = 2 AND MONTH(DT_AUTORIZACAO) = '$mes'";
    if ($filial > 0) {
      $condicao .= " AND NNOA.CD_FILIAL = $filial AND SCOC.CD_FILIAL = $filial";
    }
    if(!empty($queryContasUsuario)){
      $contasUsuario = [];
      foreach($queryContasUsuario as $c){
        array_push($contasUsuario, $c['cd_conta_gerencial']);
      }
      $contasUsuario = implode(',', $contasUsuario);
      $condicao .= " AND SCD.CD_CONTA_GERENCIAL IN ($contasUsuario)";
      $retorno = getAcompanhamento($condicao, $colunaMes);
      echo json_encode($retorno);
    } else{
      echo '';
    }
    break;
  case 'detalhes':
    $idCentroCusto = $_POST['centroCusto'];
    $idUsuario  = $_SESSION['idUsuario'];
    $ano = $_POST['ano'];
    $mes = $_POST['mes'];
    $filial = $_SESSION['filial'];
    $queryContasUsuario = getContasGerenciaisUsuarioCentroCusto($idUsuario, $idCentroCusto, $filial);
    $condicao = "SCOC.CD_USUARIO_AUTORIZOU IS NOT NULL AND SCOC.CD_USUARIO_REPROVOU IS NULL AND YEAR(SCOC.DT_ATUALIZACAO) = '$ano' AND MONTH(SCOC.DT_ATUALIZACAO) = '$mes' AND SCD.CD_CENTRO_CUSTO = $idCentroCusto AND SCD.DS_CONTA_GERENCIAL IS NOT NULL";
    if ($filial > 0) {
      $condicao .= " AND SCOC.CD_FILIAL = $filial";
    } 
    if(!empty($queryContasUsuario)){
      $contasUsuario = [];
      foreach($queryContasUsuario as $c){
        array_push($contasUsuario, $c['cd_conta_gerencial']);
      }
      $contasUsuario = implode(',', $contasUsuario);
      $condicao .= " AND SCD.CD_CONTA_GERENCIAL IN ($contasUsuario)";
      $retorno = getAcompanhamentoDetalhes($condicao);
      echo json_encode($retorno);
    } else{
      echo '';
    }
    break;
}
