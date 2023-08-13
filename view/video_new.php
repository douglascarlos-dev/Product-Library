<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/bootstrap.min.css" crossorigin="anonymous">
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
            <label for="exampleFormControlFile1">Vídeo</label>     
            <input type="file" class="form-control-file" id="inputVideo" name="video" accept="video/mp4,video/x-m4v">
          </div>
        </div>
        <br><a class="btn btn-outline-primary" href="<?php echo URLROOT; ?>/products/edit/<?php echo $stock_keeping_unit; ?>" role="button">Cancelar</a>
        <button type="submit" class="btn btn-primary">Carregar</button> 
      </form>

      <div class="card-body">
      ⚠️ Favor arguardar enquanto o vídeo é carregado e convertido para as dimensões 240p (240 x 240). Isso pode levar alguns minutos.
      </div>
      </div>
</div>
<script type="text/javascript" src="<?php echo URLROOT; ?>/js/jquery-3.5.1.slim.min.js"></script>
<script src="<?php echo URLROOT; ?>/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>