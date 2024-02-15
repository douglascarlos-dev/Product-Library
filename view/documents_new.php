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
      <form name="register" action="<?php echo URLROOT; ?>/documents/save" method="post" enctype="multipart/form-data">
        <div class="form-row">
          <div class="input-group col-md-4">
            <label for="inputDocument">Arquivos (máximo de <strong><code class="highlighter-rouge">10 MB</code></strong>)</label>     
            <input type="file" class="form-control-file" id="inputDocument" name="document" accept="application/pdf, image/*, video/mp4, video/x-m4v" required>
          </div>
          <div class="form-group col-md-8">
            <label for="inputDescricao">Descrição do arquivo</label>
            <input type="text" class="form-control" id="inputDescricao" name="descricao" maxlength="100" required>
          </div>
        </div>
        <br><a class="btn btn-outline-primary" href="<?php echo URLROOT; ?>/documents" role="button">Cancelar</a>
        <button type="submit" class="btn btn-primary">Carregar</button> 
      </form>
    </div>
    <div class="card-body">
      ⚠️ O nome do arquivo só deve ter letras, números e underline _.<br>
      💡 Para Comprimir o vídeo use o site <a href="https://www.comprimirvideo.com.br" target="_blank">https://www.comprimirvideo.com.br/</a>.<br>
      Vídeo (máximo de 10 MB) 1920 Pixels sem áudio.
    </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URLROOT; ?>/js/jquery-3.5.1.slim.min.js"></script>
<script src="<?php echo URLROOT; ?>/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>