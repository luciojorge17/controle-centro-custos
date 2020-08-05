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

if (!isAdministrador($_SESSION['idUsuario'])) {
  header('Location: dashboard.php');
}

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
          for ($ano = date('Y'); $ano <= (date('Y') + 3); $ano++) {
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
        <button class="btn btn-secondary btn-sm btn-block" data-toggle="modal" onclick="abreModalCentroCustos()">...</button>
      </div>
      <div class="col-12 col-md-6 col-lg-5">
        <input readonly type="text" name="txtNomeCentroCusto" id="txtNomeCentroCusto" class="form-control form-control-sm">
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
          <button class="btn btn-secondary btn-sm" onclick="salvarValores()">SALVAR</button>
        </div>
      </div>
    </div>
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

<?php
require_once 'templates/scripts.php';
?>

<script>
  const selecionaCentroCusto = (id, descricao) => {
    $('#numCentroCusto').val(id);
    $('#txtNomeCentroCusto').val(descricao);
    $('#modalCentroCustos').modal('hide');
    getContasGerenciaisCentroCustoAnual(id);
  }

  const abreModalCentroCustos = () => {
    let ano = $('#slcAno').val(),
      campo = $('#slcCentroCustoCampo').val(),
      pesquisa = $('#txtCentroCustoTexto').val();
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
          `<tr onclick="selecionaCentroCusto(${centroCusto.cd_centro_custo}, '${centroCusto.ds_centro_custo}')" style="cursor: pointer;">
            <th scope="row">${centroCusto.cd_centro_custo}</th>
            <td>${(centroCusto.x_tipo == 1) ? 'S' : 'A'}</td>
            <td>${centroCusto.ds_classificacao}</td>
            <td>${centroCusto.ds_centro_custo}</td>
          </tr>`;
      });
      $('#resultListaCentroCustos').html(html);
    });
  }

  $('#frmBuscaCentroCusto').on('submit', (e) => {
    e.preventDefault();
    abreModalCentroCustos();
  });

  const getContasGerenciaisCentroCustoAnual = (cdCentroCusto) => {
    let ano = $('#slcAno').val();
    $.ajax({
      url: '../controller/centroCusto.php',
      type: 'post',
      data: {
        action: 'listarContasGerenciaisCentroCustoAnual',
        ano,
        cdCentroCusto
      }
    }).done((data) => {
      let response = JSON.parse(data);
      let html = ``;
      $.each(response, (index, cg) => {
        html +=
          `<tr id="tr-linha-${cg.item}">
            <input type="hidden" name="hd-cd-id" value="${cg.cd_id}">
            <th scope="row">${cg.item}</th>
            <td>${cg.cd_filial}</td>
            <td>${cg.ds_conta_gerencial}</td>
            <td><input type="text" class="form-control form-control-sm maskValor" id="vl-total-linha-${cg.item}" value="${cg.vl_total_ano}" onchange="divideValorMes(${cg.item}, this.value)"></td>
            <td><input type="text" class="form-control form-control-sm maskValor" id="vl-jan-linha-${cg.item}" value="${cg.vl_mes_jan}"></td>
            <td><input type="text" class="form-control form-control-sm maskValor" id="vl-fev-linha-${cg.item}" value="${cg.vl_mes_fev}"></td>
            <td><input type="text" class="form-control form-control-sm maskValor" id="vl-mar-linha-${cg.item}" value="${cg.vl_mes_mar}"></td>
            <td><input type="text" class="form-control form-control-sm maskValor" id="vl-abr-linha-${cg.item}" value="${cg.vl_mes_abr}"></td>
            <td><input type="text" class="form-control form-control-sm maskValor" id="vl-mai-linha-${cg.item}" value="${cg.vl_mes_mai}"></td>
            <td><input type="text" class="form-control form-control-sm maskValor" id="vl-jun-linha-${cg.item}" value="${cg.vl_mes_jun}"></td>
            <td><input type="text" class="form-control form-control-sm maskValor" id="vl-jul-linha-${cg.item}" value="${cg.vl_mes_jul}"></td>
            <td><input type="text" class="form-control form-control-sm maskValor" id="vl-ago-linha-${cg.item}" value="${cg.vl_mes_ago}"></td>
            <td><input type="text" class="form-control form-control-sm maskValor" id="vl-set-linha-${cg.item}" value="${cg.vl_mes_set}"></td>
            <td><input type="text" class="form-control form-control-sm maskValor" id="vl-out-linha-${cg.item}" value="${cg.vl_mes_out}"></td>
            <td><input type="text" class="form-control form-control-sm maskValor" id="vl-nov-linha-${cg.item}" value="${cg.vl_mes_nov}"></td>
            <td><input type="text" class="form-control form-control-sm maskValor" id="vl-dez-linha-${cg.item}" value="${cg.vl_mes_dez}"></td> 
          </tr>`;
      });
      $('#tbody-orcamento').html(html);
    });
  }

  const divideValorMes = (linha, valor) => {
    valor = valor.replace('.', '');
    valor = valor.replace(',', '');
    valor = parseInt(valor);
    if (valor > 0) {
      let valorMensal = (valor / 12) / 100;
      let valorMensalSobra = ((valor / 100) - (valorMensal.toFixed(2) * 12));
      $(`#vl-jan-linha-${linha}`).val(numberToReal(valorMensal));
      $(`#vl-fev-linha-${linha}`).val(numberToReal(valorMensal));
      $(`#vl-mar-linha-${linha}`).val(numberToReal(valorMensal));
      $(`#vl-abr-linha-${linha}`).val(numberToReal(valorMensal));
      $(`#vl-mai-linha-${linha}`).val(numberToReal(valorMensal));
      $(`#vl-jun-linha-${linha}`).val(numberToReal(valorMensal));
      $(`#vl-jul-linha-${linha}`).val(numberToReal(valorMensal));
      $(`#vl-ago-linha-${linha}`).val(numberToReal(valorMensal));
      $(`#vl-set-linha-${linha}`).val(numberToReal(valorMensal));
      $(`#vl-out-linha-${linha}`).val(numberToReal(valorMensal));
      $(`#vl-nov-linha-${linha}`).val(numberToReal(valorMensal));
      $(`#vl-dez-linha-${linha}`).val(numberToReal(valorMensal + valorMensalSobra));
    } else {
      $(`#vl-jan-linha-${linha}`).val("0,00");
      $(`#vl-fev-linha-${linha}`).val("0,00");
      $(`#vl-mar-linha-${linha}`).val("0,00");
      $(`#vl-abr-linha-${linha}`).val("0,00");
      $(`#vl-mai-linha-${linha}`).val("0,00");
      $(`#vl-jun-linha-${linha}`).val("0,00");
      $(`#vl-jul-linha-${linha}`).val("0,00");
      $(`#vl-ago-linha-${linha}`).val("0,00");
      $(`#vl-set-linha-${linha}`).val("0,00");
      $(`#vl-out-linha-${linha}`).val("0,00");
      $(`#vl-nov-linha-${linha}`).val("0,00");
      $(`#vl-dez-linha-${linha}`).val("0,00");
    }
  }

  function numberToReal(numero) {
    var numero = numero.toFixed(2).split('.');
    numero[0] = numero[0].split(/(?=(?:...)*$)/).join('.');
    return numero.join(',');
  }

  const salvarValores = () => {
    let linhas = $('#tbody-orcamento tr');
    if (linhas.length == 0) {
      alert('Nada para salvar ainda!');
      return;
    }
    let update = [];
    $.each(linhas, (index, linha) => {
      let identificador = linha.id.replace('tr-linha-', '');
      update[index] = [];
      update[index].push($(`#${linha.id} input[name="hd-cd-id"]`).val());
      update[index].push($(`#${linha.id} #vl-jan-linha-${identificador}`).val());
      update[index].push($(`#${linha.id} #vl-fev-linha-${identificador}`).val());
      update[index].push($(`#${linha.id} #vl-mar-linha-${identificador}`).val());
      update[index].push($(`#${linha.id} #vl-abr-linha-${identificador}`).val());
      update[index].push($(`#${linha.id} #vl-mai-linha-${identificador}`).val());
      update[index].push($(`#${linha.id} #vl-jun-linha-${identificador}`).val());
      update[index].push($(`#${linha.id} #vl-jul-linha-${identificador}`).val());
      update[index].push($(`#${linha.id} #vl-ago-linha-${identificador}`).val());
      update[index].push($(`#${linha.id} #vl-set-linha-${identificador}`).val());
      update[index].push($(`#${linha.id} #vl-out-linha-${identificador}`).val());
      update[index].push($(`#${linha.id} #vl-nov-linha-${identificador}`).val());
      update[index].push($(`#${linha.id} #vl-dez-linha-${identificador}`).val());
    });
    update = JSON.stringify(update);
    $.ajax({
      url: '../controller/centroCusto.php',
      type: 'post',
      data: {
        action: 'updateOrcamentoAnual',
        update
      }
    }).done((data) => {
      let response = JSON.parse(data);
      if (response.status == 1) {
        alert('Dados alterados com sucesso');
        let idCentroCusto = $('#numCentroCusto').val();
        getContasGerenciaisCentroCustoAnual(idCentroCusto);
      }
    });
  }
</script>

<?php
require_once 'templates/rodape.php';
