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
      <form name="register" action="<?php echo URLROOT; ?>/photo/save/<?php echo $stock_keeping_unit; ?>" method="post" enctype="multipart/form-data">
        <div class="form-row">
          <div class="input-group col-md-12">
            <label for="exampleFormControlFile1">Foto (máximo de 2 MB)</label>     
            <input type="file" class="form-control-file" id="inputPhoto" name="photo" accept="image/png, image/jpeg">
          </div>
        </div>
        <br><a class="btn btn-outline-primary" href="<?php echo URLROOT; ?>/products/edit/<?php echo $stock_keeping_unit; ?>" role="button">Cancelar</a>
        <button type="submit" class="btn btn-primary">Carregar</button> 
      </form>
    </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URLROOT; ?>/js/jquery-3.5.1.slim.min.js"></script>
<script src="<?php echo URLROOT; ?>/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>