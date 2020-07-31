const desabilitaBtn = () => {
  $('.form-signin button[type="submit"]').prop('disabled', true);
  $('.form-signin button[type="submit"]').addClass('disabled');
  $('.form-signin button[type="submit"]').html('Aguarde');
}

const habilitaBtn = () => {
  $('.form-signin button[type="submit"]').prop('disabled', false);
  $('.form-signin button[type="submit"]').removeClass('disabled');
  $('.form-signin button[type="submit"]').html('Entrar');
}

const erroServidor = 'Falha ao conectar no servidor';

$('.form-signin').on('submit', (e) => {
  e.preventDefault();
  let form = new FormData($('.form-signin')[0]);
  $.ajax({
    url: '../controller/login.php',
    type: 'post',
    data: form,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: () => desabilitaBtn()
  }).done((data) => {
    let response = JSON.parse(data);
    if (response.status == 1) {
      window.location.href = 'dashboard.php';
    } else {
      habilitaBtn();
      $('#txtSenha').val('');
      $('#txtUsuario').focus();
      $('.login-error').html(response.mensagem);
      setTimeout(() => {
        $('.login-error').empty();
      }, 5000);
    }
  }).fail(() => {
    habilitaBtn();
    $('#txtSenha').val('');
    $('#txtUsuario').focus();
    $('.login-error').html(erroServidor);
    setTimeout(() => {
      $('.login-error').empty();
    }, 5000);
  });
})