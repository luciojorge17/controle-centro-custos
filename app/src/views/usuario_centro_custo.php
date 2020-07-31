<?php
$titulo = 'Usuário x Centro de Custo';
$active = [
  0 => '',
  1 => '',
  2 => '',
  3 => '',
  4 => 'active',
  5 => ''
];
require_once 'templates/cabecalho.php';
?>

<section id="page-usuario-centro-custo">
  <div class="container padding-sm">
    <div class="row align-items-center">
      <div class="col-12 col-md-2 col-lg-2 text-right">
        <label for="numUsuario">Usuário</label>
      </div>
      <div class="col-12 col-md-2 col-lg-1">
        <input type="number" name="numUsuario" id="numUsuario" class="form-control form-control-sm">
      </div>
      <div class="col-12 col-md-2 col-lg-1">
        <button class="btn btn-secondary btn-sm btn-block">...</button>
      </div>
      <div class="col-12 col-md-7 col-lg-5">
        <input readonly type="text" name="txtNomeUsuario" id="txtNomeUsuario" class="form-control form-control-sm">
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
          Centros de custo/Conta gerencial do usuário
        </div>
        <div class="col-12">
          <table class="table table-sm table-striped">
            <thead>
              <tr>
                <th scope="col">Item</th>
                <th scope="col">Filial</th>
                <th scope="col">Cód</th>
                <th scope="col">Classificação</th>
                <th scope="col">Centro de Custo</th>
                <th scope="col">Conta Gerencial</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
require_once 'templates/scripts.php';
require_once 'templates/rodape.php';
