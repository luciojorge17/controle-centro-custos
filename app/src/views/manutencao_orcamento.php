<?php
$titulo = 'Manutenção Orçamento';
$active = [
  0 => '',
  1 => 'active',
  2 => '',
  3 => '',
  4 => '',
  5 => ''
];
require_once 'templates/cabecalho.php';

if (!isAdministrador($_SESSION['idUsuario'])) {
  header('Location: dashboard.php');
}
include_once '../model/orcamentoModel.php';

?>

<section id="page-manutencao-orcamento">
  <div class="container padding-sm">
    <form id="frmManutencao" action="#">
      <div class="row align-items-center">
        <div class="col-12 col-md-2 col-lg-2">
          <label for="slcOperacao">Operação</label>
        </div>
        <div class="col-12 col-md-3 col-lg-3">
          <select name="slcOperacao" id="slcOperacao" class="form-control form-control-sm">
            <option value="0">Aumentar limite</option>
            <option value="1">Diminuir limite</option>
            <option value="1">Transferir limite</option>
          </select>
        </div>
        <div class="col-12 col-md-2 col-lg-1 text-right">
          <label for="slcAno">Ano</label>
        </div>
        <div class="col-12 col-md-3 col-lg-2">
          <select name="slcAno" id="slcAno" class="form-control form-control-sm">
            <?php
            $queryAnos = getAnos();
            foreach ($queryAnos as $ano) {
              echo '<option value="' . $ano->DT_ANO . '">' . $ano->DT_ANO . '</option>';
            }
            ?>
          </select>
        </div>
        <div class="col-12 col-md-2 col-lg-1 text-right">
          <label for="slcMes">Mês</label>
        </div>
        <div class="col-12 col-md-3 col-lg-2">
          <select name="slcMes" id="slcMes" class="form-control form-control-sm">
            <?php
            foreach ($meses as $index => $mes) {
              $selected = ($index == date('m')) ? 'selected' : '';
              echo '<option ' . $selected . ' value="' . $index . '">' . $mes["abreviatura"] . '</option>';
            }
            ?>
          </select>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-12 col-lg-10 offset-lg-2 mt-1 mb-2">
          Saída
        </div>
        <div class="col-12 col-md-2 col-lg-2">
          <label for="numCentroCustoSaida">Centro de Custo</label>
        </div>
        <div class="col-12 col-md-2 col-lg-1">
          <input type="number" name="numCentroCustoSaida" id="numCentroCustoSaida" class="form-control form-control-sm" required>
        </div>
        <div class="col-12 col-md-2 col-lg-1">
          <button type="button" class="btn btn-secondary btn-sm btn-block">...</button>
        </div>
        <div class="col-12 col-md-6 col-lg-5">
          <input readonly type="text" name="txtNomeCentroCustoSaida" id="txtNomeCentroCustoSaida" class="form-control form-control-sm">
        </div>
      </div>
      <div class="row align-items-center mt-2">
        <div class="col-12 col-md-2 col-lg-2">
          <label for="numContaGerencialSaida">Conta Gerencial</label>
        </div>
        <div class="col-12 col-md-2 col-lg-1">
          <input type="number" name="numContaGerencialSaida" id="numContaGerencialSaida" class="form-control form-control-sm" required>
        </div>
        <div class="col-12 col-md-2 col-lg-1">
          <button type="button" class="btn btn-secondary btn-sm btn-block">...</button>
        </div>
        <div class="col-12 col-md-6 col-lg-5">
          <input readonly type="text" name="txtNomeContaGerencialSaida" id="txtNomeContaGerencialSaida" class="form-control form-control-sm">
        </div>
        <div class="col-12 col-md-2 col-lg-1 text-right">
          <label for="txtValorAtualSaida">Valor Atual</label>
        </div>
        <div class="col-12 col-md-2 col-lg-2">
          <input readonly type="text" name="txtValorAtualSaida" id="txtValorAtualSaida" class="form-control form-control-sm">
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-12 col-lg-10 offset-lg-2 mt-1 mb-2">
          Entrada
        </div>
        <div class="col-12 col-md-2 col-lg-2">
          <label for="numCentroCustoEntrada">Centro de Custo</label>
        </div>
        <div class="col-12 col-md-2 col-lg-1">
          <input type="number" name="numCentroCustoEntrada" id="numCentroCustoEntrada" class="form-control form-control-sm" required>
        </div>
        <div class="col-12 col-md-2 col-lg-1">
          <button type="button" class="btn btn-secondary btn-sm btn-block">...</button>
        </div>
        <div class="col-12 col-md-6 col-lg-5">
          <input readonly type="text" name="txtNomeCentroCustoEntrada" id="txtNomeCentroCustoEntrada" class="form-control form-control-sm">
        </div>
      </div>
      <div class="row align-items-center mt-2">
        <div class="col-12 col-md-2 col-lg-2">
          <label for="numContaGerencialEntrada">Conta Gerencial</label>
        </div>
        <div class="col-12 col-md-2 col-lg-1">
          <input type="number" name="numContaGerencialEntrada" id="numContaGerencialEntrada" class="form-control form-control-sm" required>
        </div>
        <div class="col-12 col-md-2 col-lg-1">
          <button type="button" class="btn btn-secondary btn-sm btn-block">...</button>
        </div>
        <div class="col-12 col-md-6 col-lg-5">
          <input readonly type="text" name="txtNomeContaGerencialEntrada" id="txtNomeContaGerencialEntrada" class="form-control form-control-sm">
        </div>
        <div class="col-12 col-md-2 col-lg-1 text-right">
          <label for="txtValorAtualEntrada">Valor Atual</label>
        </div>
        <div class="col-12 col-md-2 col-lg-2">
          <input readonly type="text" name="txtValorAtualEntrada" id="txtValorAtualEntrada" class="form-control form-control-sm">
        </div>
      </div>
      <div class="row align-items-center mt-5">
        <div class="col-12 col-md-2 col-lg-2">
          <label for="txtValorTransferencia">Valor</label>
        </div>
        <div class="col-12 col-md-2 col-lg-2">
          <input type="text" name="txtValorTransferencia" id="txtValorTransferencia" class="form-control form-control-sm maskValor" value="0,00" required>
        </div>
      </div>
      <div class="row align-items-center mt-2">
        <div class="col-12 col-md-2 col-lg-2">
          <label for="txtJustificativa">Justificativa</label>
        </div>
        <div class="col-12 col-md-2 col-lg-10">
          <textarea name="txtJustificativa" id="txtJustificativa" rows="2" class="form-control form-control-sm" required></textarea>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-12 col-lg-10 offset-lg-2 mt-1 mb-2">
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </div>
    </form>
  </div>
</section>

<?php
require_once 'templates/scripts.php';
require_once 'templates/rodape.php';
