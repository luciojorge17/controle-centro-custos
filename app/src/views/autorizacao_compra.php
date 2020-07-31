<?php
$titulo = 'Autorização de compra';
$active = [
  0 => '',
  1 => '',
  2 => 'active',
  3 => '',
  4 => '',
  5 => ''
];
require_once 'templates/cabecalho.php';
?>

<section id="page-autorizacao-compra">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <button class="btn btn-primary btn-sm">Autorizar</button>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-12">
        Ordem de Compra
      </div>
      <div class="col-12">
        <table class="table table-sm table-striped">
          <thead>
            <tr>
              <th scope="col">Cód</th>
              <th scope="col">Filial</th>
              <th scope="col" class="text-center">Emissão</th>
              <th scope="col">Entidade</th>
              <th scope="col" class="text-right">Valor</th>
              <th scope="col" class="tetx-center">Autorizar</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-12">
        Itens da Ordem de Compra
      </div>
      <div class="col-12">
        <table class="table table-sm table-striped">
          <thead>
            <tr>
              <th scope="col">Item</th>
              <th scope="col">Cód</th>
              <th scope="col">Produto</th>
              <th scope="col" class="text-right">Quantidade</th>
              <th scope="col" class="text-right">Vl. Unitário</th>
              <th scope="col" class="text-right">Vl. Total</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-12">
        Contas Gerenciais
      </div>
      <div class="col-12">
        <table class="table table-sm table-striped">
          <thead>
            <tr>
              <th scope="col">Cód</th>
              <th scope="col">Classificação</th>
              <th scope="col">Descrição</th>
              <th scope="col" class="text-right">Vl. Limite</th>
              <th scope="col" class="text-right">Vl. Utilizado</th>
              <th scope="col" class="text-right">Vl. Disponível</th>
              <th scope="col" class="text-right">Vl. Ord. Compra</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<?php
require_once 'templates/scripts.php';
require_once 'templates/rodape.php';
