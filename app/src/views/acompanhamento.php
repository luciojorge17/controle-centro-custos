<?php
$titulo = 'Acompanhamento de ordem de compra saldos';
$active = [
  0 => '',
  1 => '',
  2 => '',
  3 => 'active',
  4 => '',
  5 => ''
];
require_once 'templates/cabecalho.php';
include_once '../model/centroCustoModel.php';
?>

<section id="page-acompanhamento">
  <div class="container padding-sm">
    <div class="row align-items-end">
      <div class="col-12 col-md-2 col-lg-1">
        <label for="slcAno">Ano</label>
        <select name="slcAno" id="slcAno" class="form-control form-control-sm">
          <?php
          for ($ano = date('Y'); $ano >= (date('Y') - 5); $ano--) {
            $selected = ($ano == date('Y')) ? 'selected' : '';
            echo '<option ' . $selected . ' value="' . $ano . '">' . $ano . '</option>';
          }
          ?>
        </select>
      </div>
      <div class="col-12 col-md-2 col-lg-1">
        <label for="slcMes">Mês</label>
        <select name="slcMes" id="slcMes" class="form-control form-control-sm">
          <?php
          foreach ($meses as $index => $mes) {
            $selected = ($index == date('m')) ? 'selected' : '';
            echo '<option ' . $selected . ' value="' . $index . '">' . $mes["abreviatura"] . '</option>';
          }
          ?>
        </select>
      </div>
      <div class="col-12 col-md-2 col-lg-5">
        <label for="slcCentroCusto">Centro de Custo</label>
        <select name="slcCentroCusto" id="slcCentroCusto" class="form-control form-control-sm">
          <option value="">Selecione...</option>
          <?php
          $queryCentroCustos = getCentroCustosUsuario($_SESSION['idUsuario'], $_SESSION['filial']);
          foreach ($queryCentroCustos as $cc) {
            echo '<option value="' . $cc["cd_centro_custo"] . '">' . $cc["ds_centro_custo"] . '</option>';
          }
          ?>
        </select>
      </div>
      <div class="col-12 col-md-4 col-lg-2">
        <button class="btn btn-primary btn-sm btn-block">Visão Geral</button>
      </div>
      <div class="col-12 col-md-4 col-lg-2">
        <button class="btn btn-primary btn-sm btn-block">Detalhes</button>
      </div>
    </div>
  </div>
</section>

<?php
require_once 'templates/scripts.php';
require_once 'templates/rodape.php';
