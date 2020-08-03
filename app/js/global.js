$('#slcTrocaFilial').on('change', () => {
  let filial = $('#slcTrocaFilial').val();
  $.ajax({
    url: '../controller/login.php',
    type: 'post',
    data: { filial, action: 'trocarFilial' }
  }).done(() => {
    window.location.reload();
  });
});

const sair = () => {
  $.ajax({
    url: '../controller/login.php',
    type: 'post',
    data: { action: 'logoff' }
  }).done(() => {
    window.location.href = 'login.php';
  });
}

$('.maskPercentual').maskMoney();
$('.maskValor').maskMoney({
  allowNegative: false,
  thousands: '.',
  decimal: ',',
  affixesStay: false
});
$('.maskPercentual').on('blur', function () {
  if ($(this).val() == '') {
    $(this).val("0.00");
  }
})
$('.maskValor').on('blur', function () {
  if ($(this).val() == '') {
    $(this).val("0,00");
  }
})