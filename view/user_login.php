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
    <h4>Product Library</h4>
    <p>Biblioteca de imagens, vídeos e PDF para e-commerce</p>
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
                <?php  if ($settings->getHcaptcha() == 1) { ?><div class="h-captcha" data-sitekey="<?php echo $settings->getHcaptchaDataSitekey(); ?>"></div><?php } ?>
            </div>
            <div class="form-group col-md-6">
                <button type="submit" class="btn btn-primary">Entrar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <footer class="pt-3 my-md-2">
      <div class="row">
        <div class="col-12 col-md">
          <small class="d-block mb-3 text-muted text-center">© 2023<br><a href="https://github.com/douglascarlos-dev/Product-Library" target="_blank"><img src="<?php echo URLROOT; ?>/img/logo.svg" alt="HTML tutorial" style="height:35px;"></a></small>
        </div>
      </div>
    </footer>
  </div>
<script type="text/javascript" src="<?php echo URLROOT; ?>/js/jquery-3.5.1.slim.min.js"></script>
<script src="<?php echo URLROOT; ?>/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src='https://js.hcaptcha.com/1/api.js' async defer></script>

</body>
</html>