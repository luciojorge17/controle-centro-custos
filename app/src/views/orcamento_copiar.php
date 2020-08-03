<?php
$titulo = 'Orçamento - copiar';
$active = [
  0 => '',
  1 => '',
  2 => '',
  3 => '',
  4 => '',
  5 => 'active'
];
require_once 'templates/cabecalho.php';
include_once '../model/orcamentoModel.php';
?>

<section id="page-orcamento-copiar">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <a href="orcamento.php" class="btn btn-danger btn-sm">Voltar</a>
      </div>
    </div>
  </div>
  <div class="container padding-sm">
    <div class="row align-items-end mt-3">
      <div class="col-12 col-md-2 col-lg-2">
        <label for="slcAnoPara">Orçamento para</label>
        <select name="slcAnoPara" id="slcAnoPara" class="form-control form-control-sm">
          <?php
          for ($ano = date('Y'); $ano <= (date('Y') + 5); $ano++) {
            $selected = ($ano == date('Y')) ? 'selected' : '';
            echo '<option ' . $selected . ' value="' . $ano . '">' . $ano . '</option>';
          }
          ?>
        </select>
      </div>
      <div class="col-12 col-md-2 col-lg-2">
        <label for="slcAnoDe">Copiar valores do ano</label>
        <select name="slcAnoDe" id="slcAnoDe" class="form-control form-control-sm">
          <?php
          $queryAnos = getAnos();
          foreach ($queryAnos as $ano) {
            echo '<option value="' . $ano->DT_ANO . '">' . $ano->DT_ANO . '</option>';
          }
          ?>
        </select>
      </div>
      <div class="col-12 col-md-2 col-lg-1">
        <label for="slcReajuste">Reajuste</label>
        <select name="slcReajuste" id="slcReajuste" class="form-control form-control-sm">
          <option value="0">Não</option>
          <option selected value="1">Sim</option>
        </select>
      </div>
      <div class="col-12 col-md-2 col-lg-2 esconde-reajuste">
        <label for="slcTipo">Tipo</label>
        <select name="slcTipo" id="slcTipo" class="form-control form-control-sm">
          <option value="0">Decréscimo</option>
          <option selected value="1">Acréscimo</option>
        </select>
      </div>
      <div class="col-12 col-md-2 col-lg-1 esconde-reajuste">
        <label for="txtPercentual">%</label>
        <input type="text" name="txtPercentual" id="txtPercentual" class="form-control form-control-sm maskPercentual" value="0.00">
      </div>
      <div class="col-12 col-md-4 col-lg-1">
        <button class="btn btn-secondary btn-sm btn-block">Copiar</button>
      </div>
    </div>
  </div>
</section>

<?php
require_once 'templates/scripts.php';
?>

<script>
  $('#slcReajuste').on('change', () => {
    let reajustar = $('#slcReajuste').val();
    if (reajustar == 1) {
      $('.esconde-reajuste').show();
    } else {
      $('.esconde-reajuste').hide();
    }
  });
</script>

<?php
require_once 'templates/rodape.php';
