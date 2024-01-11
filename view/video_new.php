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
      <form name="register" action="<?php echo URLROOT; ?>/video/save/<?php echo $stock_keeping_unit; ?>" method="post" enctype="multipart/form-data">
        <div class="form-row">
          <div class="input-group col-md-12">
            <label for="exampleFormControlFile1">Vídeo (máximo de 2 MB) 720 Pixels sem áudio</label>     
            <input type="file" class="form-control-file" id="inputVideo" name="video" accept="video/mp4,video/x-m4v">
          </div>
        </div>
        <br><a class="btn btn-outline-primary" href="<?php echo URLROOT; ?>/products/edit/<?php echo $stock_keeping_unit; ?>" role="button">Cancelar</a>
        <button type="submit" class="btn btn-primary">Carregar</button> 
      </form>

      <div class="card-body">
        ⚠️ Favor arguardar enquanto o vídeo é carregado.<br>
        💡 Para Comprimir o vídeo use o site <a href="https://www.comprimirvideo.com.br" target="_blank">https://www.comprimirvideo.com.br/</a>.
      </div>
      </div>
</div>
<script type="text/javascript" src="<?php echo URLROOT; ?>/js/jquery-3.5.1.slim.min.js"></script>
<script src="<?php echo URLROOT; ?>/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>