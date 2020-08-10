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
        <button class="btn btn-primary btn-sm btn-block" onclick="visaoGeral()">Visão Geral</button>
      </div>
      <div class="col-12 col-md-4 col-lg-2">
        <button class="btn btn-primary btn-sm btn-block" onclick="detalhes()">Detalhes</button>
      </div>
    </div>
  </div>
  <div class="container mt-5">
    <div id="result" class="row">
    </div>
  </div>
</section>

<?php
require_once 'templates/scripts.php';
?>
<script src="../../js/raphael-2.1.4.min.js"></script>
<script src="../../js/justgage.js"></script>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<script>
  const visaoGeral = () => {
    let centroCusto = $('#slcCentroCusto').val(),
      mes = $('#slcMes').val(),
      ano = $('#slcAno').val();
    if (centroCusto == '' || centroCusto == undefined || centroCusto == null) {
      alert('Selecione um centro de custo');
      return;
    }

    let animation =
      `<div class="col-12 text-center">
        <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_6vr5Cz.json"  background="transparent"  speed="1"  style="height: 200px;"  loop autoplay></lottie-player>
        <p class="mt-3">Aguarde</p>
      </div>`;

    $.ajax({
      url: '../controller/acompanhamento.php',
      type: 'post',
      data: {
        centroCusto,
        mes,
        ano,
        action: 'visaoGeral'
      },
      beforeSend: () => $('#result').html(animation)
    }).done((data) => {
      let response = JSON.parse(data);
      let html =
        `<div class="col-12 text-center mt-3 mb-1">
          <h4>Contas Gerenciais</h4>
        </div>`;
      $.each(response, (index, dados) => {
        html +=
          `<div class="col-12 col-md-4"><div id="gauge-${dados.cd_conta_gerencial}"></div></div>`;
      });
      $('#result').html(html);
      $.each(response, (index, dados) => {
        let valor = dados.limite.replace('.', '');
        valor = valor.replace(',', '.');
        let utilizado = dados.utilizado.replace('.', '');
        utilizado = utilizado.replace(',', '.');
        let percentual = (utilizado * 100) / valor;
        new JustGage({
          id: `gauge-${dados.cd_conta_gerencial}`,
          decimal: 2,
          value: utilizado,
          min: 0,
          max: parseFloat(valor).toFixed(2),
          title: dados.ds_conta_gerencial,
          label: `${percentual.toFixed(2)} %`,
          pointer: true,
          gaugeWidthScale: 1,
          formatNumber: true,
          pointerOptions: {
            toplength: 5,
            bottomlength: 5,
            bottomwidth: 4,
            color: '#000'
          },
          levelColors: [
            "#01DFA5",
          ],
          gaugeColor: "#e6e6e6",
          titleFontColor: "#000",
          valueFontColor: "#000",
          labelFontColor: "#000"
        });
      });
    });
  }

  const detalhes = () => {
    let centroCusto = $('#slcCentroCusto').val(),
      mes = $('#slcMes').val(),
      ano = $('#slcAno').val();
    if (centroCusto == '' || centroCusto == undefined || centroCusto == null) {
      alert('Selecione um centro de custo');
      return;
    }

    let animation =
      `<div class="col-12 text-center">
        <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_6vr5Cz.json"  background="transparent"  speed="1"  style="height: 200px;"  loop autoplay></lottie-player>
        <p class="mt-3">Aguarde</p>
      </div>`;

    $.ajax({
      url: '../controller/acompanhamento.php',
      type: 'post',
      data: {
        centroCusto,
        mes,
        ano,
        action: 'detalhes'
      },
      beforeSend: () => $('#result').html(animation)
    }).done((data) => {
      let response = JSON.parse(data);
      let html = `<div class="col-12 mb-3"><div class="accordion" id="accordion">`;
      let contador = 1;
      $.each(response, (index, dados) => {
        html +=
          `<div class="card">
            <div class="card-header" id="accordion-${contador}">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left btn-accordion" type="button" data-toggle="collapse" data-target="#collapse-${contador}" aria-expanded="true" aria-controls="collapse-${contador}">
                  ${index}
                </button>
              </h2>
            </div>
            <div id="collapse-${contador}" class="collapse" aria-labelledby="accordion-${contador}" data-parent="#accordion">
              <div class="card-body">
                  <table class="table table-sm table-striped">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">O.C.</th>
                        <th scope="col">Fornecedor</th>
                        <th scope="col" class="text-right">Total (R$)</th>
                      </tr>
                    </thead>
                    <tbody>`;
        let valorTotal = 0;
        $.each(dados, (index, linha) => {
          let valorLinha = linha.valor.replace('.', '');
          valorLinha = valorLinha.replace(',', '.');
          valorTotal = parseFloat(valorTotal) + parseFloat(valorLinha);
          html +=
            `<tr>
            <th scope="row">${linha.cd_ordem_compra}</th>
            <td>${linha.ds_fornecedor}</td>
            <td class="text-right">${linha.valor}</td>
          </tr>`;
        });
        html +=
          `       </tbody>
                </table>
              <div class="col-12 text-right mb-3">
                Total: R$ ${numberToReal(valorTotal)}
              </div>
            </div>
          </div>
          </div>`;
        contador++;
      })
      html += `</div>`;
      $('#result').html(html);
    });
  }

  function numberToReal(numero) {
    var numero = numero.toFixed(2).split('.');
    numero[0] = numero[0].split(/(?=(?:...)*$)/).join('.');
    return numero.join(',');
  }
</script>

<?php
require_once 'templates/rodape.php';
