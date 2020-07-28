<?php
  session_start();
  $filial = $_POST['filial'];
  $_SESSION['filial'] = $filial;
