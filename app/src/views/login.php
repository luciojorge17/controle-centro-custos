<?php
session_start();
if (isset($_SESSION['idUsuario'])) {
  header('Location: dashboard.php');
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
  <link rel="stylesheet" href="../../css/login.css">
  <title>Entrar</title>
</head>

<body>

  <form action="#" class="form-signin">
    <div class="logo text-center">
      <img src="../../images/logo_dark.png" alt="New Norte logo">
    </div>
    <label for="txtUsuario">Usuário</label>
    <input type="text" name="txtUsuario" id="txtUsuario" class="form-control" required autofocus>
    <label for="txtSenha">Senha</label>
    <input type="password" name="txtSenha" id="txtSenha" class="form-control" required>
    <button type="submit" class="btn btn-primary btn-lg btn-block">Entrar</button>
    <div class="login-error text-center text-danger"></div>
  </form>

  <script src="../../js/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="../../js/bootstrap.min.js"></script>
  <script src="../../js/login.js"></script>
</body>

</html>