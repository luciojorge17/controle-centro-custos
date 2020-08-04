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
      <input type="hidden" name="action" value="manutencaoOrcamento">
      <div class="row align-items-center">
        <div class="col-12 col-md-2 col-lg-2">
          <label for="slcOperacao">Operação</label>
        </div>
        <div class="col-12 col-md-3 col-lg-3">
          <select name="slcOperacao" id="slcOperacao" class="form-control form-control-sm">
            <option value="aumentar">Aumentar limite</option>
            <option value="diminuir">Diminuir limite</option>
            <option value="transferir">Transferir limite</option>
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
      <div class="row mt-3 saida">
        <div class="col-12 col-lg-10 offset-lg-2 mt-1 mb-2">
          Saída
        </div>
        <div class="col-12 col-md-2 col-lg-2">
          <label for="numCentroCustoSaida">Centro de Custo</label>
        </div>
        <div class="col-12 col-md-2 col-lg-1">
          <input type="number" name="numCentroCustoSaida" id="numCentroCustoSaida" class="form-control form-control-sm">
        </div>
        <div class="col-12 col-md-2 col-lg-1">
          <button type="button" class="btn btn-secondary btn-sm btn-block" data-toggle="modal" onclick="abreModalCentroCustos(1)">...</button>
        </div>
        <div class="col-12 col-md-6 col-lg-5">
          <input readonly type="text" name="txtNomeCentroCustoSaida" id="txtNomeCentroCustoSaida" class="form-control form-control-sm">
        </div>
      </div>
      <div class="row align-items-center mt-2 saida">
        <div class="col-12 col-md-2 col-lg-2">
          <label for="numContaGerencialSaida">Conta Gerencial</label>
        </div>
        <div class="col-12 col-md-2 col-lg-1">
          <input type="number" name="numContaGerencialSaida" id="numContaGerencialSaida" class="form-control form-control-sm">
        </div>
        <div class="col-12 col-md-2 col-lg-1">
          <button type="button" class="btn btn-secondary btn-sm btn-block" data-toggle="modal" onclick="abreModalContasGerenciais(1)">...</button>
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
      <div class="row mt-3 entrada">
        <div class="col-12 col-lg-10 offset-lg-2 mt-1 mb-2">
          Entrada
        </div>
        <div class="col-12 col-md-2 col-lg-2">
          <label for="numCentroCustoEntrada">Centro de Custo</label>
        </div>
        <div class="col-12 col-md-2 col-lg-1">
          <input type="number" name="numCentroCustoEntrada" id="numCentroCustoEntrada" class="form-control form-control-sm">
        </div>
        <div class="col-12 col-md-2 col-lg-1">
          <button type="button" class="btn btn-secondary btn-sm btn-block" data-toggle="modal" onclick="abreModalCentroCustos(2)">...</button>
        </div>
        <div class="col-12 col-md-6 col-lg-5">
          <input readonly type="text" name="txtNomeCentroCustoEntrada" id="txtNomeCentroCustoEntrada" class="form-control form-control-sm">
        </div>
      </div>
      <div class="row align-items-center mt-2 entrada">
        <div class="col-12 col-md-2 col-lg-2">
          <label for="numContaGerencialEntrada">Conta Gerencial</label>
        </div>
        <div class="col-12 col-md-2 col-lg-1">
          <input type="number" name="numContaGerencialEntrada" id="numContaGerencialEntrada" class="form-control form-control-sm">
        </div>
        <div class="col-12 col-md-2 col-lg-1">
          <button type="button" class="btn btn-secondary btn-sm btn-block" data-toggle="modal" onclick="abreModalContasGerenciais(2)">...</button>
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

<div class="modal fade" id="modalCentroCustos" tabindex="-1" role="dialog" aria-labelledby="modalCentroCustosLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCentroCustosLabel">Consulta centro de custo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frmBuscaCentroCusto" class="row">
          <input type="hidden" name="tipoModal" id="tipoModal">
          <div class="col-12 col-md-4 col-lg-3">
            <label for="slcCentroCustoCampo">Campo</label>
            <select name="slcCentroCustoCampo" id="slcCentroCustoCampo" class="form-control form-control-sm" required>
              <option value="centroCusto">Centro de custo</option>
              <option value="classificacao">Classificação</option>
            </select>
          </div>
          <div class="col-12 col-md-8 col-lg-9">
            <label for="txtCentroCustoTexto">Texto</label>
            <input type="text" name="txtCentroCustoTexto" id="txtCentroCustoTexto" class="form-control form-control-sm">
          </div>
        </form>
        <div class="row mt-4">
          <div class="col-12">
            <table class="table table-sm table-hover table-striped">
              <thead>
                <tr>
                  <th scope="col">Cód</th>
                  <th scope="col">Tipo</th>
                  <th scope="col">Classificação</th>
                  <th scope="col">Centro de Custo</th>
                </tr>
              </thead>
              <tbody id="resultListaCentroCustos">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalContasGerenciais" tabindex="-1" role="dialog" aria-labelledby="modalContasGerenciaisLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalContasGerenciaisLabel">Consulta conta gerencial</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frmBuscaContasGerenciais" class="row">
          <input type="hidden" name="tipoModalGerencial" id="tipoModalGerencial">
          <input type="hidden" name="action" value="listarContasGerenciais">
          <div class="col-12 col-md-4 col-lg-3">
            <label for="slcContaGerencialCampo">Campo</label>
            <select name="slcContaGerencialCampo" id="slcContaGerencialCampo" class="form-control form-control-sm" required>
              <option value="contaGerencial">Conta Gerencial</option>
              <option value="classificacao">Classificação</option>
            </select>
          </div>
          <div class="col-12 col-md-8 col-lg-9">
            <label for="txtContaGerencialTexto">Texto</label>
            <input type="text" name="txtContaGerencialTexto" id="txtContaGerencialTexto" class="form-control form-control-sm">
          </div>
        </form>
        <div class="row mt-4">
          <div class="col-12">
            <table class="table table-sm table-hover table-striped">
              <thead>
                <tr>
                  <th scope="col">Cód</th>
                  <th scope="col">Tipo</th>
                  <th scope="col">Classificação</th>
                  <th scope="col">Conta Gerencial</th>
                </tr>
              </thead>
              <tbody id="resultListaContasGerenciais">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
require_once 'templates/scripts.php';
?>

<script>
  $('.saida').hide();
  $('#slcOperacao').on('change', () => {
    let operacao = $('#slcOperacao').val();
    switch (operacao) {
      case 'aumentar':
        $('.saida').hide();
        $('.entrada').show();
        break;
      case 'diminuir':
        $('.saida').show();
        $('.entrada').hide();
        break;
      case 'transferir':
        $('.saida').show();
        $('.entrada').show();
        break;
    }
  });
  const selecionaCentroCusto = (id, descricao, tipo) => {
    if (tipo == 2) {
      $('#numCentroCustoEntrada').val(id);
      $('#txtNomeCentroCustoEntrada').val(descricao);
    } else {
      $('#numCentroCustoSaida').val(id);
      $('#txtNomeCentroCustoSaida').val(descricao);
    }
    $('#modalCentroCustos').modal('hide');
  }
  const selecionaContaGerencial = (id, descricao, valor, tipo) => {
    if (tipo == 2) {
      $('#numContaGerencialEntrada').val(id);
      $('#txtNomeContaGerencialEntrada').val(descricao);
      $('#txtValorAtualEntrada').val(valor);
    } else {
      $('#numContaGerencialSaida').val(id);
      $('#txtNomeContaGerencialSaida').val(descricao);
      $('#txtValorAtualSaida').val(valor);
    }
    $('#modalContasGerenciais').modal('hide');
  }
  const abreModalCentroCustos = (tipo) => {
    // 2 entrada 1 saída
    let ano = $('#slcAno').val(),
      campo = $('#slcCentroCustoCampo').val(),
      pesquisa = $('#txtCentroCustoTexto').val();
    $('#tipoModal').val(tipo);
    $.ajax({
      url: '../controller/centroCusto.php',
      type: 'post',
      data: {
        action: 'listarCentroCustosOrcamentoAnual',
        ano,
        campo,
        pesquisa
      }
    }).done((data) => {
      $('#modalCentroCustos').modal('show');
      let response = JSON.parse(data);
      let html = ``;
      $.each(response, (index, centroCusto) => {
        html +=
          `<tr onclick="selecionaCentroCusto(${centroCusto.cd_centro_custo}, '${centroCusto.ds_centro_custo}', ${tipo})" style="cursor: pointer;">
            <th scope="row">${centroCusto.cd_centro_custo}</th>
            <td>${(centroCusto.x_tipo == 1) ? 'S' : 'A'}</td>
            <td>${centroCusto.ds_classificacao}</td>
            <td>${centroCusto.ds_centro_custo}</td>
          </tr>`;
      });
      $('#resultListaCentroCustos').html(html);
    });
  }
  const abreModalContasGerenciais = (tipo) => {
    // 2 entrada 1 saída
    let cdCentroCusto;
    let palavra;
    if (tipo == 1) {
      cdCentroCusto = $('#numCentroCustoSaida').val();
      palavra = 'saída';
    } else {
      cdCentroCusto = $('#numCentroCustoEntrada').val();
      palavra = 'entrada';
    }
    if (cdCentroCusto == '' || cdCentroCusto == undefined || cdCentroCusto == null) {
      alert(`Selecione um centro de custo de ${palavra} primeiro!`);
      return;
    }
    let
      mes = $('#slcMes').val(),
      ano = $('#slcAno').val(),
      campo = $('#slcContaGerencialCampo').val(),
      pesquisa = $('#txtContaGerencialTexto').val();
    $('#tipoModalGerencial').val(tipo);
    $.ajax({
      url: '../controller/centroCusto.php',
      type: 'post',
      data: {
        action: 'listarContasGerenciaisOrcamentoAnual',
        mes,
        ano,
        campo,
        pesquisa,
        cdCentroCusto
      }
    }).done((data) => {
      $('#modalContasGerenciais').modal('show');
      let response = JSON.parse(data);
      let html = ``;
      $.each(response, (index, cg) => {
        html +=
          `<tr onclick="selecionaContaGerencial(${cg.cd_conta_gerencial}, '${cg.ds_conta_gerencial}', '${cg.valor_atual}' , ${tipo})" style="cursor: pointer;">
            <th scope="row">${cg.cd_conta_gerencial}</th>
            <td>${(cg.x_tipo == 1) ? 'S' : 'A'}</td>
            <td>${cg.ds_classificacao}</td>
            <td>${cg.ds_conta_gerencial}</td>
          </tr>`;
      });
      $('#resultListaContasGerenciais').html(html);
    });
  }

  $('#frmBuscaCentroCusto').on('submit', (e) => {
    e.preventDefault();
    abreModalCentroCustos($('#tipoModal').val());
  });
  $('#frmBuscaContasGerenciais').on('submit', (e) => {
    e.preventDefault();
    abreModalContasGerenciais($('#tipoModalGerencial').val());
  });

  $('#frmManutencao').on('submit', (e) => {
    e.preventDefault();
    let form = new FormData($('#frmManutencao')[0]);
    $.ajax({
      url: '../controller/orcamento.php',
      type: 'post',
      data: form,
      processData: false,
      contentType: false,
      cache: false
    }).done((data) => {
      let response = JSON.parse(data);
      if (response.status == 1) {
        alert('Operação realizada com sucesso');
        setTimeout(() => {
          window.location.reload();
        }, 2000);
      } else {
        alert(response.mensagem);
      }
    });
  });
</script>

<?php
require_once 'templates/rodape.php';
