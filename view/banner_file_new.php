<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/bootstrap.min.css" crossorigin="anonymous">
    <meta http-equiv="Cache-Control" content="No-Cache">
    <meta http-equiv="Pragma" content="No-Cache">
    <meta http-equiv="Expires" content="0">
    <title>Library</title>
    <style>
        #main_area {
            margin-top: 50px;
        }
    </style>
  </head>
  <body>
  <?php require_once 'menu.php'; ?>
  <div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center col-md-8 order-md-1">
  <div class="card">
    <div class="card-body">
      <form name="register" action="<?php echo URLROOT; ?>/bannerfile/save/<?php echo $banner_name; ?>" method="post" enctype="multipart/form-data">
        <div class="form-row">
          <div class="input-group col-md-4">
            <label for="inputFile">Arquivos (máximo de <strong><code class="highlighter-rouge">1 MB</code></strong>)</label>     
            <input type="file" class="form-control-file" id="inputFile" name="file[]" accept="image/*" multiple required >
          </div>
          <div class="form-group col-md-3 mx-auto">
            <label for="inputDevice">Dispositivo</label>
            <select id="selectDevice" name="device" class="form-control" autofocus>
                <option value='d' name='d' selected>Desktop</option>
                <option value='m' name='m'>Mobile</option>
            </select>
          </div>
          <div class="form-group col-md-3 mx-auto">
            <label for="inputLanguage">Idioma</label>
            <select id="selectLanguage" name="language" class="form-control" autofocus>
                <option value='pt' name='pt' selected>Português</option>
            </select>
          </div>
        </div>
        <br><a class="btn btn-outline-primary" href="<?php echo URLROOT; ?>/banner/edit/<?php echo $banner_name; ?>" role="button">Cancelar</a>
        <button type="submit" class="btn btn-primary">Carregar</button> 
      </form>
    </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URLROOT; ?>/js/jquery-3.5.1.slim.min.js"></script>
<script src="<?php echo URLROOT; ?>/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>