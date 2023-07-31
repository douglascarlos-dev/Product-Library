<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/bootstrap.min.css" crossorigin="anonymous">

    <title>Library</title>

    <style>
    .mt-4, .my-4 {
    margin-top: 2rem!important;
    }

    .thumbnail {
        border-radius: 0%;
        display: block;
        padding: 2px;
        line-height: 1.42857143;
        background-color: #fff;
        border: 1px solid #ddd;
        /*border-radius: 4px;*/
        -webkit-transition: border .2s ease-in-out;
        -o-transition: border .2s ease-in-out;
        transition: border .2s ease-in-out;
    }
    </style>
    
  </head>
  <body>
  <?php require_once 'menu.php'; ?>

<div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center col-md-8 order-md-1">

<div class="card">
<div class="card-body">
<?php

function Mask($mask,$str){
  $str = str_replace(" ","",$str);
  for($i=0;$i<strlen($str);$i++){
      $mask[strpos($mask,"#")] = $str[$i];
  }
  return $mask;
}

?>
<form action="<?php echo URLROOT; ?>/products/update/<?php echo $products->getStockKeepingUnit(); ?>" method="post">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputSku">SKU</label>
      <input type="text" class="form-control" id="inputSku" name="sku" value="<?php echo $products->getStockKeepingUnit(); ?>" maxlength="100" readonly>
    </div>
    <div class="form-group col-md-6">
      <label for="inputSku">SKU</label>
      <input type="text" class="form-control" id="inputDescricao" name="descricao" value="<?php echo $products->getDescription(); ?>" maxlength="100">
      </div>
    </div>

<?php
foreach($photo as &$photo_value):
?>

    <div class="form-row">
        <div class="form-group col-md-1">
        <br><br><a class="btn btn-danger" href="<?php echo URLROOT; ?>/photo/delete/<?php echo $products->getStockKeepingUnit(); ?>/<?php echo $photo_value->getFileName(); ?>" role="button">Deletar</a>
        </div>
        <div class="form-group col-md-2">
          <center><img src="<?php echo URLROOT; ?>/foto/<?php echo $products->getStockKeepingUnit(); ?>/<?php echo $photo_value->getFileName()."?t=".time(); ?>" alt="Image preview" class="thumbnail" width="120" height="120"></center>
        </div>

        <div class="form-group col-md-3">
            <label for="inputSku">SKU</label>
            <input type="text" class="form-control" id="inputSku" name="sku" value="<?php echo $products->getStockKeepingUnit(); ?>" maxlength="100" readonly>
        </div>
        <div class="form-group col-md-2">
            <label for="inputSku">Data</label>
            <input type="text" class="form-control" id="inputSku" name="sku" value="2023-07-23 22:03:11" maxlength="100" readonly>
        </div>
        <div class="form-group col-md-2">
            <label for="inputSku">Resolução</label>
            <input type="text" class="form-control" id="inputSku" name="sku" value="1200px 1200px" maxlength="100" readonly>
        </div>
        <div class="form-group col-md-2">
            <label for="inputSku">Tamanho</label>
            <input type="text" class="form-control" id="inputSku" name="sku" value="300kb" maxlength="100" readonly>
        </div>

    </div>

<?php
endforeach;
?>

<button type="submit" class="btn btn-primary">Atualizar</button>
<a class="btn btn-outline-primary" id="newPhoto" href="<?php echo URLROOT; ?>/photo/new/<?php echo $products->getStockKeepingUnit(); ?>" role="button">Adicionar foto</a>
</form>
</div>
</div>
</div>

<script type="text/javascript" src="<?php echo URLROOT; ?>/js/jquery-3.5.1.slim.min.js"></script>
<script src="<?php echo URLROOT; ?>/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>