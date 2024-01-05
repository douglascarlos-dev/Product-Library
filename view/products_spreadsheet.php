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
    <script src="https://kit.fontawesome.com/14edfcae2f.js" crossorigin="anonymous"></script>
  </head>
  <body>
  <?php require_once 'menu.php'; ?>

  <div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center col-md-8 order-md-1">
  <div class="card">
    <div class="card-body">
      <form action="<?php echo URLROOT; ?>/products/spreadsheet/save" method="post" enctype="multipart/form-data">
        <div class="form-row">&nbsp;<b>Planilha de Produtos.</b>
          <div class="input-group col-md-12">
            <label for="exampleFormControlFile1">Atualize os produtos a partir de um relátorio em planilha.</label>     
            <input type="file" class="form-control-file" id="inputPlanilha" name="planilha" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" >
          </div>
        </div>
        <br>
        <div class="form-row">
          <div class="input-group col-md-12">
            <label for="exampleFormControlFile1"><a class="ext-dark" href="<?php echo URLROOT; ?>/products/spreadsheet/download">Clique aqui <i class="fa-solid fa-file" style="color: #28a745;"></i> para baixar o relátorio atual.</a></label>     
          </div>
        </div>
        <br><a class="btn btn-outline-primary" href="<?php echo URLROOT; ?>/products" role="button">Cancelar</a>
        <button type="submit" class="btn btn-primary">Carregar</button> 
      </form>
    </div>
    </div>
</div>

</body>
</html>