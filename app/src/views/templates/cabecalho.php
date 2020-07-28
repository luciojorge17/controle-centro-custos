<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
  header('Location: login.php');
}
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
      <li class="<?php echo $active[0]; ?>"><a href="#">Início</a></li>
      <li class="<?php echo $active[1]; ?>"><a href="#">Manutenção de orçamento</a></li>
      <li class="<?php echo $active[2]; ?>"><a href="#">Autorização de compra</a></li>
      <li class="<?php echo $active[3]; ?>"><a href="#">Acompanhamento OC Saldos</a></li>
      <li class="<?php echo $active[4]; ?>"><a href="#">Cadastrar usuário</a></li>
      <li class="<?php echo $active[5]; ?>"><a href="#">Cadastrar orçamento</a></li>
    </ul>
    <div class="text-center mt-4 align-items-center text-light">
      <?php echo $_SESSION['nomeUsuario']; ?><br>
      <button class="btn btn-danger" onclick="sair()">Sair</button>
    </div>
  </aside>

  <main>
    <header>
      <div class="container">
        <div class="row">
          <div class="col-12">
            <select name="slcTrocaFilial" id="slcTrocaFilial" class="form-control">
              <option value="0">Mostrar dados de todas as filiais</option>
              <?php
              include_once '../model/filiaisModel.php';
              $queryFiliais = getFiliais();
              foreach ($queryFiliais as $filial) {
                $selected = ($filial->CD_FILIAL == $_SESSION['filial']) ? 'selected' : '';
                echo '<option ' . $selected . ' value="' . $filial->CD_FILIAL . '">' . $filial->CD_FILIAL . ' - ' . utf8_encode($filial->DS_FILIAL) . '</option>';
              }
              ?>
            </select>
          </div>
        </div>
      </div>
    </header>

    <div class="container">
      <div class="row">
        <div class="col-12 pt-2 pb-2">
          <h2><?php echo (isset($titulo)) ? $titulo : 'Sem título'; ?></h2>
        </div>
      </div>
    </div>