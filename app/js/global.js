$('#slcTrocaFilial').on('change', () => {
  let filial = $('#slcTrocaFilial').val();
  $.ajax({
    url: '../controller/login/trocarFilial.php',
    type: 'post',
    data: { filial }
  }).done(() => {
    window.location.reload();
  });
});

const sair = () => {
  $.ajax({
    url: '../controller/login/sair.php'
  }).done(() => {
    window.location.href = 'login.php';
  });
}