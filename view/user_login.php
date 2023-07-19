<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Douglas Carlos">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo URLROOT ?>/css/bootstrap.min.css" crossorigin="anonymous">
    <title>Library</title>
    <meta property="og:image" content=""/>
    <meta property="og:title" content="Library"/>
    <meta property="og:description" content=""/>
  </head>
  <body>
  <div class="mx-auto text-center col-md-8 order-md-1">
    <img src="<?php echo URLROOT; ?>/img/5138237.svg" height="200" width="274" alt="Contato">
    <h4>Library</h4>
    <p>-</p>
    <p>Demonstração
    <br>
    <b>Usuário:</b> admin
    <br>
    <b>Senha:</b> admin</p>
    <div class="card">
      <div class="card-body">
        <form name="entrar" action="<?php echo URLROOT; ?>/user/login" method="post">
          <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputUsuario">Usuário</label>
                <input type="text" class="form-control" id="inputUsuario" name="username" autocomplete="username" placeholder="Usuário" maxlength="100">
            </div>
            <div class="form-group col-md-6">
                <label for="inputSenha">Senha</label>
                <input type="password" class="form-control" id="inputSenha" name="password" autocomplete="off" placeholder="Senha" maxlength="100">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
                <div class="h-captcha" data-sitekey="<?php
$params = require "model/database.php";
echo $params['captcha_data-sitekey'];
?>"></div>
            </div>
            <div class="form-group col-md-6">
                <button type="submit" class="btn btn-primary">Entrar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<script type="text/javascript" src="<?php echo URLROOT; ?>/js/jquery-3.5.1.slim.min.js"></script>
<script src="<?php echo URLROOT; ?>/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src='https://www.hCaptcha.com/1/api.js' async defer></script>
</body>
</html>