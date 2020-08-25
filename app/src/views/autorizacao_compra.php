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
        <button class="btn btn-primary btn-sm" onclick="alterarStatusOrdem(1)">Autorizar</button>
        <button class="btn btn-danger btn-sm" onclick="alterarStatusOrdem(2)">Reprovar</button>
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
              <th scope="col" class="text-center">Autorizar</th>
            </tr>
          </thead>
          <tbody id="resultListaOrdens">
          </tbody>
        </table>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-12">
        Observação da Ordem de Compra
      </div>
      <div class="col-12">
        <textarea name="txtObservacao" id="txtObservacao" rows="3" class="form-control form-control-sm" readonly></textarea>
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
          <tbody id="resultItensOrdem">
          </tbody>
        </table>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-12">
        Desdobro dos custos
      </div>
      <div class="col-12">
        <table class="table table-sm table-striped">
          <thead>
            <tr>
              <th scope="col">Cód</th>
              <th scope="col">Classificação</th>
              <th scope="col">Centro Custo</th>
              <th scope="col">Conta Gerencial</th>
              <th scope="col" class="text-right">Vl. Limite</th>
              <th scope="col" class="text-right">Vl. Utilizado</th>
              <th scope="col" class="text-right">Vl. Disponível</th>
              <th scope="col" class="text-right">Vl. Ord. Compra</th>
            </tr>
          </thead>
          <tbody id="resultContasGerenciaisOrdem">
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<?php
require_once 'templates/scripts.php';
?>

<script>
  window.onload = () => {
    listarOrdensDeCompra();
  }

  let ordens = [];

  const alterarStatusOrdem = (tipo) => {
    if (ordens.length == 0) {
      alert('Selecione pelo menos uma ordem de compra!');
      return;
    }
    let action = (tipo == 1) ? 'autorizar' : 'reprovar';
    if (window.confirm(`Deseja mesmo ${action} as ordens de compra?`)) {
      $.ajax({
        url: '../controller/ordemCompra.php',
        type: 'post',
        data: {
          action,
          ordens
        }
      }).done(() => {
        window.location.reload();
      });
    }
  }

  const adicionarRemoverOrdem = (elemento, idOrdem) => {
    ($(elemento).prop('checked')) ? ordens.push(idOrdem): ordens.splice(ordens.indexOf(idOrdem), 1);
  };

  const listarOrdensDeCompra = () => {
    $.ajax({
      url: '../controller/ordemCompra.php',
      type: 'post',
      data: {
        action: 'listarOrdens'
      }
    }).done((data) => {
      let response = JSON.parse(data);
      let html = ``;
      let primeira = null;
      $.each(response, (index, ordem) => {
        if (index == 0) {
          primeira = ordem.cd_ordem_compra;
        }
        html +=
          `<tr id="ordem-compra-${ordem.cd_ordem_compra}" onclick="detalhesOrdem(${ordem.cd_ordem_compra})" style="cursor: pointer;">
            <th scope="row">${ordem.cd_ordem_compra}</th>
            <td>${ordem.cd_filial}</td>
            <td class="text-center">${ordem.dt_emissao}</td>
            <td>${ordem.ds_entidade}</td>
            <td class="text-right">${ordem.vl_total}</td>
            <td class="text-center">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="ordem-${ordem.cd_ordem_compra}" onchange="adicionarRemoverOrdem(this, ${ordem.cd_ordem_compra})">
                <label class="custom-control-label" for="ordem-${ordem.cd_ordem_compra}"></label>
              </div>
            </td>
          </tr>`;
      });
      $('#resultListaOrdens').html(html);
      if (primeira != null) {
        detalhesOrdem(primeira);
      }
    });
  }

  const detalhesOrdem = (idOrdem) => {
    $('#resultContasGerenciaisOrdem').empty();
    listaItensOrdemDeCompra(idOrdem);
    listaContasGerenciaisOrdemDeCompra(idOrdem);
    getObservacao(idOrdem);
    $(`#resultListaOrdens tr`).removeClass('bg-primary');
    $(`#resultListaOrdens tr`).removeClass('text-white');
    $(`#ordem-compra-${idOrdem}`).addClass('bg-primary');
    $(`#ordem-compra-${idOrdem}`).addClass('text-white');
    $(`#resultListaOrdens tr input[type="checkbox"]`).prop('disabled', false);
  }

  const listaItensOrdemDeCompra = (idOrdem) => {
    $.ajax({
      url: '../controller/ordemCompra.php',
      type: 'post',
      data: {
        action: 'listarItensOrdem',
        idOrdem
      }
    }).done((data) => {
      let response = JSON.parse(data);
      let html = ``;
      $.each(response, (index, item) => {
        html +=
          `<tr>
            <th scope="row">${item.cd_item}</th>
            <td>${item.cd_material}</td>
            <td>${item.ds_material}</td>
            <td class="text-right">${item.nr_quantidade}</td>
            <td class="text-right">${item.vl_unitario}</td>
            <td class="text-right">${item.vl_total}</td>
          </tr>`;
      });
      $('#resultItensOrdem').html(html);
    });
  }

  const listaContasGerenciaisOrdemDeCompra = (idOrdem) => {
    $.ajax({
      url: '../controller/ordemCompra.php',
      type: 'post',
      data: {
        action: 'listarContasGerenciaisOrdem',
        idOrdem
      }
    }).done((data) => {
      let response = JSON.parse(data);
      let html = ``;
      $.each(response, (index, cg) => {
        let bg = '';
        $.ajax({
          url: '../controller/ordemCompra.php',
          type: 'post',
          data: {
            action: 'verificacaoUsuario',
            centroCusto: cg.cd_centro_custo,
            contaGerencial: cg.cd_conta_gerencial
          }
        }).done((data) => {
          let response = JSON.parse(data);
          if (response.status == true) {
            bg = 'bg-danger text-white';
            $(`#resultListaOrdens #ordem-compra-${idOrdem} input[type="checkbox"]`).prop('disabled', true);
            $(`#resultListaOrdens #ordem-compra-${idOrdem} input[type="checkbox"]`).prop('checked', false);
            alert('Centro de custo/Conta gerencial informado não relacionado com o usuário logado. Favor corrigir para realizar a autorização!');
          }
          html =
            `<tr class="${bg}">
            <th scope="row">${cg.cd_conta_gerencial}</th>
            <td>${cg.ds_classificacao}</td>
            <td>${cg.ds_centro_custo}</td>
            <td>${cg.ds_conta_gerencial}</td>
            <td class="text-right">${cg.vl_limite}</td>
            <td class="text-right">${cg.vl_utilizado}</td>
            <td class="text-right">${cg.vl_disponivel}</td>
            <td class="text-right">${cg.vl_ordem_compra}</td>
          </tr>`;
          $('#resultContasGerenciaisOrdem').append(html);
        });
      });
    });
  }

  const getObservacao = (idOrdem) => {
    $.ajax({
      url: '../controller/ordemCompra.php',
      type: 'post',
      data: {
        action: 'getObservacaoOrdem',
        idOrdem
      }
    }).done((data) => {
      let response = JSON.parse(data);
      $('#txtObservacao').val(response);
    });
  }
</script>

<?php
require_once 'templates/rodape.php';
