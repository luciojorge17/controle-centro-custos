<?php
session_start();
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
require_once '../model/orcamentoModel.php';
require_once '../model/filiaisModel.php';
$action = $_POST['action'];
switch ($action) {
  case 'manutencaoOrcamento':
    $operacao = $_POST['slcOperacao'];
    $ano = $_POST['slcAno'];
    $mes = $_POST['slcMes'];
    $justificativa = $_POST['txtJustificativa'];
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
    $valor = soNumero($_POST['txtValorTransferencia']);
    switch ($operacao) {
      case 'aumentar':
        $data = date('Y-m-d H:i:d') . '.000';
        $valorAnterior = soNumero($_POST['txtValorAtualEntrada']);
        $valorAtualizado = number_format(($valorAnterior + $valor) / 100, 2, '.', '');
        $centroCusto = $_POST['numCentroCustoEntrada'];
        $contaGerencial = $_POST['numContaGerencialEntrada'];
        $update = "$colunaMes = '$valorAtualizado', DT_ATUALIZACAO = '$data'";
        $condicao = "DT_ANO = '$ano' AND CD_CENTRO_CUSTO = $centroCusto AND CD_CONTA_GERENCIAL = $contaGerencial";
        updateNewnorteOrcamentoAtual($update, $condicao);
        atualizaTotalOrcamentoAtual($condicao);
        $dados = [];
        $dados[0] = $operacao;
        $dados[1] = $_SESSION['idUsuario'];
        $dados[2] = number_format($valor / 100, 2, '.', '');
        $dados[3] = $justificativa;
        $dados[4] = $centroCusto;
        $dados[5] = $contaGerencial;
        $dados[6] = $centroCusto;
        $dados[7] = $contaGerencial;
        insertManutencao($dados);
        echo json_encode(['status' => 1]);
        break;
      case 'diminuir':
        $data = date('Y-m-d H:i:d') . '.000';
        $valorAnterior = soNumero($_POST['txtValorAtualSaida']);
        if ($valor > $valorAnterior) {
          echo json_encode(['status' => 0, 'mensagem' => 'Saldo insuficiente']);
          exit;
        }
        $valorAtualizado = number_format(($valorAnterior - $valor) / 100, 2, '.', '');
        $centroCusto = $_POST['numCentroCustoSaida'];
        $contaGerencial = $_POST['numContaGerencialSaida'];
        $update = "$colunaMes = '$valorAtualizado', DT_ATUALIZACAO = '$data'";
        $condicao = "DT_ANO = '$ano' AND CD_CENTRO_CUSTO = $centroCusto AND CD_CONTA_GERENCIAL = $contaGerencial";
        updateNewnorteOrcamentoAtual($update, $condicao);
        atualizaTotalOrcamentoAtual($condicao);
        $dados = [];
        $dados[0] = $operacao;
        $dados[1] = $_SESSION['idUsuario'];
        $dados[2] = number_format($valor / 100, 2, '.', '');
        $dados[3] = $justificativa;
        $dados[4] = $centroCusto;
        $dados[5] = $contaGerencial;
        $dados[6] = $centroCusto;
        $dados[7] = $contaGerencial;
        insertManutencao($dados);
        echo json_encode(['status' => 1]);
        break;
      case 'transferir':
        $data = date('Y-m-d H:i:d') . '.000';
        //diminui
        $valorAnterior = soNumero($_POST['txtValorAtualSaida']);
        if ($valor > $valorAnterior) {
          echo json_encode(['status' => 0, 'mensagem' => 'Saldo insuficiente']);
          exit;
        }
        $valorAtualizado = number_format(($valorAnterior - $valor) / 100, 2, '.', '');
        $centroCustoSaida = $_POST['numCentroCustoSaida'];
        $contaGerencialSaida = $_POST['numContaGerencialSaida'];
        $update = "$colunaMes = '$valorAtualizado', DT_ATUALIZACAO = '$data'";
        $condicao = "DT_ANO = '$ano' AND CD_CENTRO_CUSTO = $centroCustoSaida AND CD_CONTA_GERENCIAL = $contaGerencialSaida";
        updateNewnorteOrcamentoAtual($update, $condicao);
        atualizaTotalOrcamentoAtual($condicao);
        //soma
        $valorAnterior = soNumero($_POST['txtValorAtualEntrada']);
        $valorAtualizado = number_format(($valorAnterior + $valor) / 100, 2, '.', '');
        $centroCustoEntrada = $_POST['numCentroCustoEntrada'];
        $contaGerencialEntrada = $_POST['numContaGerencialEntrada'];
        $update = "$colunaMes = '$valorAtualizado', DT_ATUALIZACAO = '$data'";
        $condicao = "DT_ANO = '$ano' AND CD_CENTRO_CUSTO = $centroCustoEntrada AND CD_CONTA_GERENCIAL = $contaGerencialEntrada";
        updateNewnorteOrcamentoAtual($update, $condicao);
        atualizaTotalOrcamentoAtual($condicao);
        $dados = [];
        $dados[0] = $operacao;
        $dados[1] = $_SESSION['idUsuario'];
        $dados[2] = number_format($valor / 100, 2, '.', '');
        $dados[3] = $justificativa;
        $dados[4] = $centroCustoSaida;
        $dados[5] = $contaGerencialSaida;
        $dados[6] = $centroCustoEntrada;
        $dados[7] = $contaGerencialEntrada;
        insertManutencao($dados);
        echo json_encode(['status' => 1]);
        break;
    }
    break;
  case 'copiarOrcamento':
    $filial = ($_SESSION['filial'] == 0) ? 1 : $_SESSION['filial'];
    $empresa = ($_SESSION['filial'] == 0) ? 1 : getIdEmpresa($_SESSION['filial']);
    $anoDe = $_POST['slcAnoDe'];
    $anoPara = $_POST['slcAnoPara'];
    $reajuste = $_POST['slcReajuste'];
    $tipoReajuste = $_POST['slcTipo'];
    $percentual = $_POST['txtPercentual'] / 100;
    $condicao = "DT_ANO = '$anoDe'";
    if ($filial > 0) {
      $condicao .= " AND CD_EMPRESA = $empresa AND CD_FILIAL = $filial";
    }
    $dadosCopia = getOrcamentoAnual($condicao);
    foreach ($dadosCopia as $copiar) {

      if ($reajuste == 0) {
        $vl_total_ano = $copiar['vl_total_ano'];
        $vl_mes_jan = $copiar['vl_mes_jan'];
        $vl_mes_fev = $copiar['vl_mes_fev'];
        $vl_mes_mar = $copiar['vl_mes_mar'];
        $vl_mes_abr = $copiar['vl_mes_abr'];
        $vl_mes_mai = $copiar['vl_mes_mai'];
        $vl_mes_jun = $copiar['vl_mes_jun'];
        $vl_mes_jul = $copiar['vl_mes_jul'];
        $vl_mes_ago = $copiar['vl_mes_ago'];
        $vl_mes_set = $copiar['vl_mes_set'];
        $vl_mes_out = $copiar['vl_mes_out'];
        $vl_mes_nov = $copiar['vl_mes_nov'];
        $vl_mes_dez = $copiar['vl_mes_dez'];
      } else {
        if ($tipoReajuste == 0) {
          $vl_total_ano = $copiar['vl_total_ano'] - ($copiar['vl_total_ano'] * $percentual);
          $vl_mes_jan = $copiar['vl_mes_jan'] - ($copiar['vl_mes_jan'] * $percentual);
          $vl_mes_fev = $copiar['vl_mes_fev'] - ($copiar['vl_mes_fev'] * $percentual);
          $vl_mes_mar = $copiar['vl_mes_mar'] - ($copiar['vl_mes_mar'] * $percentual);
          $vl_mes_abr = $copiar['vl_mes_abr'] - ($copiar['vl_mes_abr'] * $percentual);
          $vl_mes_mai = $copiar['vl_mes_mai'] - ($copiar['vl_mes_mai'] * $percentual);
          $vl_mes_jun = $copiar['vl_mes_jun'] - ($copiar['vl_mes_jun'] * $percentual);
          $vl_mes_jul = $copiar['vl_mes_jul'] - ($copiar['vl_mes_jul'] * $percentual);
          $vl_mes_ago = $copiar['vl_mes_ago'] - ($copiar['vl_mes_ago'] * $percentual);
          $vl_mes_set = $copiar['vl_mes_set'] - ($copiar['vl_mes_set'] * $percentual);
          $vl_mes_out = $copiar['vl_mes_out'] - ($copiar['vl_mes_out'] * $percentual);
          $vl_mes_nov = $copiar['vl_mes_nov'] - ($copiar['vl_mes_nov'] * $percentual);
          $vl_mes_dez = $copiar['vl_mes_dez'] - ($copiar['vl_mes_dez'] * $percentual);
        } else {
          $vl_total_ano = $copiar['vl_total_ano'] + ($copiar['vl_total_ano'] * $percentual);
          $vl_mes_jan = $copiar['vl_mes_jan'] + ($copiar['vl_mes_jan'] * $percentual);
          $vl_mes_fev = $copiar['vl_mes_fev'] + ($copiar['vl_mes_fev'] * $percentual);
          $vl_mes_mar = $copiar['vl_mes_mar'] + ($copiar['vl_mes_mar'] * $percentual);
          $vl_mes_abr = $copiar['vl_mes_abr'] + ($copiar['vl_mes_abr'] * $percentual);
          $vl_mes_mai = $copiar['vl_mes_mai'] + ($copiar['vl_mes_mai'] * $percentual);
          $vl_mes_jun = $copiar['vl_mes_jun'] + ($copiar['vl_mes_jun'] * $percentual);
          $vl_mes_jul = $copiar['vl_mes_jul'] + ($copiar['vl_mes_jul'] * $percentual);
          $vl_mes_ago = $copiar['vl_mes_ago'] + ($copiar['vl_mes_ago'] * $percentual);
          $vl_mes_set = $copiar['vl_mes_set'] + ($copiar['vl_mes_set'] * $percentual);
          $vl_mes_out = $copiar['vl_mes_out'] + ($copiar['vl_mes_out'] * $percentual);
          $vl_mes_nov = $copiar['vl_mes_nov'] + ($copiar['vl_mes_nov'] * $percentual);
          $vl_mes_dez = $copiar['vl_mes_dez'] + ($copiar['vl_mes_dez'] * $percentual);
        }
      }

      $dados[0] = $_SESSION['idUsuario'];
      $dados[1] = $_SESSION['idUsuario'];
      $dados[2] = $copiar['cd_empresa'];
      $dados[3] = $copiar['cd_filial'];
      $dados[4] = date('Y-m-d H:i:s') . '.000';
      $dados[5] = date('Y-m-d H:i:s') . '.000';
      $dados[6] = $anoPara;
      $dados[7] = $vl_total_ano;
      $dados[8] = $vl_mes_jan;
      $dados[9] = $vl_mes_fev;
      $dados[10] = $vl_mes_mar;
      $dados[11] = $vl_mes_abr;
      $dados[12] = $vl_mes_mai;
      $dados[13] = $vl_mes_jun;
      $dados[14] = $vl_mes_jul;
      $dados[15] = $vl_mes_ago;
      $dados[16] = $vl_mes_set;
      $dados[17] = $vl_mes_out;
      $dados[18] = $vl_mes_nov;
      $dados[19] = $vl_mes_dez;
      $dados[20] = $copiar['cd_centro_custo'];
      $dados[21] = $copiar['cd_conta_gerencial'];
      $dados[22] = $copiar['ds_obs'];
      insertContaOrcamento($dados);
    }
    echo json_encode(['status' => 1]);
    break;
}

function soNumero($string)
{
  return str_replace('.', '', str_replace(',', '', $string));
}
