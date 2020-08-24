<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
  header('Location: login.php');
}

include_once '../model/loginModel.php';
include_once '../model/filiaisModel.php';

$meses = [
  1 => [
    'mes' => 'Janeiro',
    'abreviatura' => 'JAN'
  ],
  2 => [
    'mes' => 'Fevereiro',
    'abreviatura' => 'FEV'
  ],
  3 => [
    'mes' => 'Março',
    'abreviatura' => 'MAR'
  ],
  4 => [
    'mes' => 'Abril',
    'abreviatura' => 'ABR'
  ],
  5 => [
    'mes' => 'Maio',
    'abreviatura' => 'MAI'
  ],
  6 => [
    'mes' => 'Junho',
    'abreviatura' => 'JUN'
  ],
  7 => [
    'mes' => 'Julho',
    'abreviatura' => 'JUL'
  ],
  8 => [
    'mes' => 'Agosto',
    'abreviatura' => 'AGO'
  ],
  9 => [
    'mes' => 'Setembro',
    'abreviatura' => 'SET'
  ],
  10 => [
    'mes' => 'Outubro',
    'abreviatura' => 'OUT'
  ],
  11 => [
    'mes' => 'Novembro',
    'abreviatura' => 'NOV'
  ],
  12 => [
    'mes' => 'Dezembro',
    'abreviatura' => 'DEZ'
  ]
]



?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="57x57" href="../../images/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="../../images/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="../../images/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="../../images/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="../../images/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="../../images/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="../../images/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="../../images/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="../../images/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192" href="../../images/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../../images/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="../../images/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../../images/favicon/favicon-16x16.png">
  <link rel="manifest" href="../../images/favicon/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="../../images/favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <link rel="stylesheet" href="../../css/bootstrap.min.css">
  <link rel="stylesheet" href="../../css/global.css">
  <link rel="stylesheet" href="../../css/dashboard.css">
  <title>New Norte - <?php echo (isset($titulo)) ? $titulo : 'Sem título'; ?></title>
</head>

<body>

  <aside>
    <div class="text-center">
      <img src="../../images/logo_light.png" alt="New Norte Logo" class="aside-logo">
    </div>
    <ul>
      <li class="<?php echo $active[0]; ?>"><a href="dashboard.php">Início</a></li>
      <?php
      if (isAdministrador($_SESSION['idUsuario'])) {
      ?>
        <li class="<?php echo $active[1]; ?>"><a href="manutencao_orcamento.php">Manutenção de orçamento</a></li>
      <?php
      }
      ?>
      <li class="<?php echo $active[2]; ?>"><a href="autorizacao_compra.php">Autorização de compra</a></li>
      <li class="<?php echo $active[3]; ?>"><a href="acompanhamento.php">Acompanhamento OC Saldos</a></li>
      <?php
      if (isAdministrador($_SESSION['idUsuario'])) {
      ?>
        <li class="<?php echo $active[4]; ?>"><a href="usuario_centro_custo.php">Cadastrar usuário</a></li>
      <?php
      }
      if (isAdministrador($_SESSION['idUsuario'])) {
      ?>
        <li class="<?php echo $active[5]; ?>"><a href="orcamento.php">Cadastrar orçamento</a></li>
      <?php
      }
      ?>
    </ul>
  </aside>

  <main>
    <header>
      <div class="container">
        <div class="row">
          <div class="col-12 col-md-9">
            <select name="slcTrocaFilial" id="slcTrocaFilial" class="form-control form-control-sm">
              <option value="0">Mostrar dados de todas as filiais</option>
              <?php
              $queryFiliais = getFiliais();
              foreach ($queryFiliais as $filial) {
                $selected = ($filial->CD_FILIAL == $_SESSION['filial']) ? 'selected' : '';
                echo '<option ' . $selected . ' value="' . $filial->CD_FILIAL . '">' . $filial->CD_FILIAL . ' - ' . utf8_encode($filial->DS_FILIAL) . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="col-12 col-md-3 text-right">
            <?php echo $_SESSION['nomeUsuario']; ?>
            <button id="btn-logoff" class="btn btn-danger btn-sm" onclick="sair()">Sair</button>
          </div>
        </div>
      </div>
    </header>

    <div class="container">
      <div class="row">
        <div class="col-12 pt-2 pb-2">
          <h2><?php echo (isset($titulo)) ? $titulo : 'Sem título'; ?></h2>
          <hr>
        </div>
      </div>
    </div>