<?php
session_start();
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
require_once '../model/orcamentoModel.php';
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
}

function soNumero($string)
{
  return str_replace('.', '', str_replace(',', '', $string));
}
