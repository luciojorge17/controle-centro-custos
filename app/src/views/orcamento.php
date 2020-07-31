<?php
$titulo = 'Orçamento';
$active = [
  0 => '',
  1 => '',
  2 => '',
  3 => '',
  4 => '',
  5 => 'active'
];
require_once 'templates/cabecalho.php';
?>

<section id="page-orcamento">
  <div class="container">
    <div class="row">
      <div class="col-12 text-right">
        <a href="orcamento_copiar.php" class="btn btn-primary btn-sm">Copiar Orçamento</a>
      </div>
    </div>
  </div>
  <div class="container padding-sm">
    <div class="row align-items-center">
      <div class="col-12 col-md-2 col-lg-2 text-right">
        <label for="slcAno">Ano</label>
      </div>
      <div class="col-12 col-md-2 col-lg-1">
        <select name="slcAno" id="slcAno" class="form-control form-control-sm">
          <?php
          for ($ano = date('Y'); $ano >= (date('Y') - 5); $ano--) {
            $selected = ($ano == date('Y')) ? 'selected' : '';
            echo '<option ' . $selected . ' value="' . $ano . '">' . $ano . '</option>';
          }
          ?>
        </select>
      </div>
    </div>
    <div class="row align-items-center mt-3">
      <div class="col-12 col-md-2 col-lg-2 text-right">
        <label for="numCentroCusto">Centro de Custo</label>
      </div>
      <div class="col-12 col-md-2 col-lg-1">
        <input type="number" name="numCentroCusto" id="numCentroCusto" class="form-control form-control-sm">
      </div>
      <div class="col-12 col-md-2 col-lg-1">
        <button class="btn btn-secondary btn-sm btn-block">...</button>
      </div>
      <div class="col-12 col-md-6 col-lg-5">
        <input readonly type="text" name="txtNomeUsuario" id="txtNomeUsuario" class="form-control form-control-sm">
      </div>
      <div class="col-12 col-md-4 col-lg-3">
        <button class="btn btn-primary btn-sm">Carregar Contas Gerenciais</button>
      </div>
    </div>
    <div class="container mt-5">
      <div class="row">
        <div class="col-12">
          Contas Gerenciais
        </div>
        <div class="col-12">
          <table class="table table-sm table-striped">
            <thead>
              <tr>
                <th scope="col">Item</th>
                <th scope="col">Filial</th>
                <th scope="col">Conta Gerencial</th>
                <th scope="col">VALOR ANO</th>
                <?php
                foreach ($meses as $mes) {
                  echo '<th scope="col">' . $mes["abreviatura"] . '</th>';
                }
                ?>
              </tr>
            </thead>
            <tbody id="tbody-orcamento">
            </tbody>
          </table>
        </div>
        <div class="col-12 text-right">
          <button class="btn btn-secondary btn-sm">SALVAR</button>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
require_once 'templates/scripts.php';
require_once 'templates/rodape.php';
