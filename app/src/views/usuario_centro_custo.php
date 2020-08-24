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

if (!isAdministrador($_SESSION['idUsuario'])) {
  header('Location: dashboard.php');
}

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
        <button class="btn btn-secondary btn-sm btn-block" data-toggle="modal" data-target="#modalUsuarios">...</button>
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
        <button class="btn btn-secondary btn-sm btn-block" data-toggle="modal" data-target="#modalCentroCustos">...</button>
      </div>
      <div class="col-12 col-md-6 col-lg-5">
        <input readonly type="text" name="txtNomeCentroCusto" id="txtNomeCentroCusto" class="form-control form-control-sm">
      </div>
      <div class="col-12 col-md-4 col-lg-3">
        <button class="btn btn-primary btn-sm" data-toggle="modal" onclick="abreModalContasGerenciais()">Carregar Contas Gerenciais</button>
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
                <th scope="col" class="text-center">Ações</th>
              </tr>
            </thead>
            <tbody id="resultGridContasGerenciais">
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="modalUsuarios" tabindex="-1" role="dialog" aria-labelledby="modalUsuariosLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalUsuariosLabel">Consulta usuário</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frmBuscaUsuario" class="row">
          <input type="hidden" name="action" value="buscarUsuarios">
          <div class="col-12 col-md-4 col-lg-3">
            <label for="slcUsuarioCampo">Campo</label>
            <select name="slcUsuarioCampo" id="slcUsuarioCampo" class="form-control form-control-sm" required>
              <option value="usuario">Usuário</option>
              <option value="login">Login</option>
            </select>
          </div>
          <div class="col-12 col-md-8 col-lg-9">
            <label for="txtUsuarioTexto">Texto</label>
            <input type="text" name="txtUsuarioTexto" id="txtUsuarioTexto" class="form-control form-control-sm">
          </div>
        </form>
        <div class="row mt-4">
          <div class="col-12">
            <table class="table table-sm table-hover table-striped">
              <thead>
                <tr>
                  <th scope="col">Cód</th>
                  <th scope="col">Usuário</th>
                </tr>
              </thead>
              <tbody id="resultListaUsuarios">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

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
          <input type="hidden" name="action" value="buscarCentroCustos">
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
        <h5 class="modal-title" id="modalContasGerenciaisLabel">Gravar Conta Gerencial</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frmBuscaContasGerenciais" class="row">
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
          <div class="col-12 text-right">
            <button class="btn btn-outline-danger btn-sm" onclick="limparSelecaoContas()">Desmarcar tudo</button>
            <button class="btn btn-outline-primary btn-sm" onclick="selecionarTodasAsContas()">Marcar tudo</button>
          </div>
          <div class="col-12">
            <table class="table table-sm table-hover table-striped">
              <thead>
                <tr>
                  <th scope="col">Código</th>
                  <th scope="col">Classificação</th>
                  <th scope="col">Conta Gerencial</th>
                  <th scope="col" class="text-center">Gravar</th>
                </tr>
              </thead>
              <tbody id="resultListaContasGerenciais">
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary btn-sm" onclick="salvarContasGerenciaisUsuario()">Gravar</button>
      </div>
    </div>
  </div>
</div>

<?php
require_once 'templates/scripts.php';
?>

<script>
  window.onload = () => {
    listarUsuarios();
    listarCentroCustos();
  }

  let contas = [];

  const adicionarRemoverConta = (elemento, idConta) => {
    ($(elemento).prop('checked')) ? contas.push(idConta): contas.splice(contas.indexOf(idConta), 1);
  };

  const limparSelecaoContas = () => {
    $('.checkbox-conta').prop('checked', false);
    while (contas.length) {
      contas.pop();
    }
  }

  const selecionarTodasAsContas = () => {
    limparSelecaoContas();
    $('.checkbox-conta').prop('checked', true);
    let elementos = $('.checkbox-conta');
    $.each(elementos, (index, el) => {
      let idConta = el.id.replace('cg-', '');
      contas.push(parseInt(idConta));
    });
  }

  const salvarContasGerenciaisUsuario = () => {
    let centroCusto = $('#numCentroCusto').val(),
      usuario = $('#numUsuario').val();
    if (contas.length == 0) {
      alert('Selecione pelo menos uma conta gerencial!');
      return;
    }
    if (window.confirm(`Deseja mesmo gravar as contas gerenciais para este usuário?`)) {
      $.ajax({
        url: '../controller/centroCusto.php',
        type: 'post',
        data: {
          action: 'adicionarContasUsuario',
          contas,
          centroCusto,
          usuario
        }
      }).done(() => {
        $('#modalContasGerenciais').modal('hide');
        listarContasGerenciaisGrid();
      });
    }
  }

  const abreModalContasGerenciais = () => {
    if ($('#numUsuario').val() != '' && $('#numCentroCusto').val() != '') {
      $('#modalContasGerenciais').modal('show');
      listarContasGerenciaisModal();
      limparSelecaoContas();
    } else {
      alert('Selecione um usuário e um centro de custo primeiro!');
    }
  }

  const selecionaUsuario = (id, nome) => {
    $('#numUsuario').val(id);
    $('#txtNomeUsuario').val(nome);
    $('#modalUsuarios').modal('hide');
    listarContasGerenciaisGrid();
  }

  const selecionaCentroCusto = (id, descricao) => {
    $('#numCentroCusto').val(id);
    $('#txtNomeCentroCusto').val(descricao);
    $('#modalCentroCustos').modal('hide');
    listarContasGerenciaisGrid();
  }

  $('#frmBuscaUsuario').on('submit', (e) => {
    e.preventDefault();
    let dados = $('#frmBuscaUsuario').serialize();
    listarUsuarios(dados);
  });

  $('#frmBuscaCentroCusto').on('submit', (e) => {
    e.preventDefault();
    let dados = $('#frmBuscaCentroCusto').serialize();
    listarCentroCustos(dados);
  });

  $('#frmBuscaContasGerenciais').on('submit', (e) => {
    e.preventDefault();
    let dados = $('#frmBuscaContasGerenciais').serialize();
    listarContasGerenciaisModal(dados);
  });

  $('#numUsuario').on('change', () => {
    let id = $('#numUsuario').val();
    if (id != '') {
      $.ajax({
        url: '../controller/usuarios.php',
        type: 'post',
        data: {
          action: 'getUsuarioById',
          id
        }
      }).done((data) => {
        let response = JSON.parse(data);
        if (response.status == 1) {
          selecionaUsuario(response.cd_codusuario, response.ds_usuario);
        } else {
          limpaUsuario();
          alert('Usuário não encontrado!');
        }
      });
    } else {
      limpaUsuario();
    }
  });

  $('#numCentroCusto').on('change', () => {
    let id = $('#numCentroCusto').val();
    if (id != '') {
      $.ajax({
        url: '../controller/centroCusto.php',
        type: 'post',
        data: {
          action: 'getCentroCustoById',
          id
        }
      }).done((data) => {
        let response = JSON.parse(data);
        if (response.status == 1) {
          selecionaCentroCusto(response.cd_centro_custo, response.ds_centro_custo);
        } else {
          limpaCentroCusto();
          alert('Centro de custo não encontrado!');
        }
      });
    } else {
      limpaCentroCusto();
    }
  });

  const limpaUsuario = () => {
    $('#numUsuario').val("");
    $('#txtNomeUsuario').val("");
    $('#resultGridContasGerenciais').empty();
  }

  const limpaCentroCusto = () => {
    $('#numCentroCusto').val("");
    $('#txtNomeCentroCusto').val("");
    $('#resultGridContasGerenciais').empty();
  }

  const listarUsuarios = (dados = null) => {
    $.ajax({
      url: '../controller/usuarios.php',
      type: 'post',
      data: (dados != null) ? dados : {
        action: 'buscarUsuarios'
      }
    }).done((data) => {
      let response = JSON.parse(data);
      let html = ``;
      $.each(response, (index, usuario) => {
        html +=
          `<tr onclick="selecionaUsuario(${usuario.cd_codusuario}, '${usuario.ds_usuario}')" style="cursor: pointer;">
            <th scope="row">${usuario.cd_codusuario}</th>
            <td>${usuario.ds_usuario}</td>
          </tr>`;
      });
      $('#resultListaUsuarios').html(html);
    });
  }

  const listarCentroCustos = (dados = null) => {
    $.ajax({
      url: '../controller/centroCusto.php',
      type: 'post',
      data: (dados != null) ? dados : {
        action: 'buscarCentroCustos'
      }
    }).done((data) => {
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

  const listarContasGerenciaisGrid = () => {
    let idUsuario = $('#numUsuario').val(),
      idCentroCusto = $('#numCentroCusto').val();
    if (idUsuario != '' && idCentroCusto != '') {
      $.ajax({
        url: '../controller/centroCusto.php',
        type: 'post',
        data: {
          action: 'contasGerenciaisUsuarioCentroCusto',
          idUsuario,
          idCentroCusto
        }
      }).done((data) => {
        let response = JSON.parse(data);
        let html = ``;
        $.each(response, (index, cg) => {
          html +=
            `<tr>
            <th scope="row">${cg.item}</th>
            <td>${cg.cd_filial}</td>
            <td>${cg.cd_conta_gerencial}</td>
            <td>${cg.ds_classificacao}</td>
            <td>${cg.ds_centro_custo}</td>
            <td>${cg.ds_conta_gerencial}</td>
            <td class="text-center">
              <button class="btn btn-small btn-secondary" onclick="excluirContaGerencialUsuario(${idUsuario}, ${idCentroCusto}, ${cg.cd_conta_gerencial}, '${cg.ds_conta_gerencial}')">Excluir</button>
            </td>
          </tr>`;
        });
        $('#resultGridContasGerenciais').html(html);
      });
    }
  }

  const excluirContaGerencialUsuario = (usuario, centroCusto, contaGerencial, descricaoContaGerencial) => {
    if (window.confirm(`Confirma remover '${descricaoContaGerencial}' para este usuário?`)) {
      $.ajax({
        url: '../controller/centroCusto.php',
        type: 'post',
        data: {
          action: 'excluirContaGerencialUsuario',
          usuario,
          centroCusto,
          contaGerencial
        }
      }).done(() => {
        listarContasGerenciaisGrid();
      });
    }
  }

  const listarContasGerenciaisModal = (dados = null) => {
    $.ajax({
      url: '../controller/centroCusto.php',
      type: 'post',
      data: (dados != null) ? dados : {
        action: 'listarContasGerenciais'
      }
    }).done((data) => {
      let response = JSON.parse(data);
      let html = ``;
      $.each(response, (index, cg) => {
        html +=
          `<tr>
            <th scope="row">${cg.cd_conta_gerencial}</th>
            <td>${cg.ds_classificacao}</td>
            <td>${cg.ds_conta_gerencial}</td>
            <td class="text-center">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input checkbox-conta" id="cg-${cg.cd_conta_gerencial}" onchange="adicionarRemoverConta(this, ${cg.cd_conta_gerencial})">
                <label class="custom-control-label" for="cg-${cg.cd_conta_gerencial}"></label>
              </div>
            </td>
          </tr>`;
      });
      $('#resultListaContasGerenciais').html(html);
    });
  }
</script>

<?php
require_once 'templates/rodape.php';
?>