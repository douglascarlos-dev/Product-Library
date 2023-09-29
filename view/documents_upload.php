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
      <form name="register" action="<?php echo URLROOT; ?>/documents/fileupdate/<?php echo $documents->getFileName(); ?>" method="post" enctype="multipart/form-data">
        <div class="form-row">
          <div class="input-group col-md-4">
            <label for="inputDocument">Manual/Bula <strong>.pdf</strong> (máximo de <strong><code class="highlighter-rouge">10 MB</code></strong>)</label>     
            <input type="file" class="form-control-file" id="inputDocument" name="document" accept="application/pdf" required>
          </div>
          <div class="form-group col-md-8">
            <label for="inputDescricao">Descrição do documento</label>
            <input type="text" class="form-control" id="inputDescricao" name="descricao" maxlength="100" value="<?php echo $documents->getDescription(); ?>" readonly>
          </div>
        </div>
        <br><a class="btn btn-outline-primary" href="<?php echo URLROOT; ?>/documents/edit/<?php echo $documents->getFileName(); ?>" role="button">Cancelar</a>
        <button type="submit" class="btn btn-primary">Atualizar</button> 
      </form>
    </div>
    <div class="card-body">
      ⚠️ O nome do arquivo só deve ter letras, números e underline _.
    </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URLROOT; ?>/js/jquery-3.5.1.slim.min.js"></script>
<script src="<?php echo URLROOT; ?>/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>