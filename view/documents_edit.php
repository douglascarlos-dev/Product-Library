<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/bootstrap.min.css" crossorigin="anonymous">
    <meta http-equiv="Cache-Control" content="No-Cache">
    <meta http-equiv="Pragma" content="No-Cache">
    <meta http-equiv="Expires" content="0">

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
        border: 0px solid #ddd;
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
<form action="<?php echo URLROOT; ?>/documents/update/<?php echo $documents->getFileName(); ?>" method="post">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputSku">Nome do arquivo</label>
      <input type="text" class="form-control" id="inputSku" name="sku" value="<?php echo $documents->getFileName(); ?>" maxlength="100" readonly>
    </div>
    <div class="form-group col-md-6">
      <label for="inputSku">Descrição</label>
      <input type="text" class="form-control" id="inputDescricao" name="descricao" value="<?php echo $documents->getDescription(); ?>" maxlength="100">
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-2">
        <br><br><a class="btn btn-info" href="<?php echo URLROOT; ?>/documents/upload/<?php echo $documents->getFileName(); ?>" role="button">Carregar Nova Versão</a>
    </div>
    <div class="form-group col-md-2">
      <center><a href="<?php echo URLROOT; ?>/files/<?php echo $documents->getFileName()."?t=".strtotime($documents->getUpdated()); ?>" target="_blank">
      <img src="<?php echo URLROOT; ?>/img/<?php
      $string = $documents->getFileName();
      $ultimos_caracteres = substr($string, -3);
      echo $ultimos_caracteres . '.svg';
      ?>" alt="Image preview" class="thumbnail" width="90" height="120">
    </a></center>
    </div>
    <div class="form-group col-md-2">
      <label for="inputSku">Páginas</label>
      <input type="text" class="form-control" id="inputSku" name="sku" value="" maxlength="100" readonly>
    </div>
    <div class="form-group col-md-2">
      <label for="inputSku">Tamanho</label>
      <input type="text" class="form-control" id="inputSku" name="sku" value="<?php echo $documents->convertToReadableSize($documents->getSize()); ?> <?php if ($documents->getSize() >= 5000000)  echo "⚠️"; ?>" maxlength="100" readonly>
    </div>
    <div class="form-group col-md-2">
      <label for="inputSku">Carregado</label>
      <input type="text" class="form-control" id="inputSku" name="sku" value="<?php echo $documents->formatDate($documents->getCreated()); ?>" maxlength="100" readonly>
    </div>
    <div class="form-group col-md-2">
      <label for="inputSku">Atualizado</label>
      <input type="text" class="form-control" id="inputSku" name="sku" value="<?php echo $documents->formatDate($documents->getUpdated()); ?>" maxlength="100" readonly>
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-10">
        <label for="inputSku">URL do Arquivo</label>
        <input type="text" class="form-control" id="inputSku" name="sku" value="<?php echo "http://" . $_SERVER['SERVER_NAME']; ?><?php echo URLROOT; ?>/files/download/<?php echo $documents->getFileName(); ?>" maxlength="100" readonly>
    </div>
    <div class="form-group col-md-2">
      <label for="inputSku">Views</label>
      <input type="text" class="form-control" id="inputvVews" name="views" value="<?php echo $documents->getViews(); ?>" readonly>
    </div>
  </div>
  <?php if ($documents->getCdn() == 1 & $settings->getBunny() == 1) { ?>
  <div class="form-row">
    <div class="form-group col-md-12">
        <label for="inputSku">URL do Arquivo no CDN</label>
        <input type="text" class="form-control" id="inputSku" name="sku" value="<?php echo $settings->getBunnyLinkedHostname(); ?>/files/<?php echo $documents->getFileName(); ?>" maxlength="100" readonly>
    </div>
  </div>
<?php } ?>
<button type="submit" class="btn btn-primary">Atualizar</button>
<a class="btn btn-danger" href="<?php echo URLROOT; ?>/documents/delete/<?php echo $documents->getFileName(); ?>" role="button">Deletar</a>
<a class="btn btn-warning" href="<?php echo URLROOT; ?>/documents" role="button">Cancelar</a>
<?php //echo ( $settings->getBunny() == 1) ? 'CDN Ativado' : 'CDN Desativado'; ?>
<?php

if ($settings->getBunny() == 1) {
  echo ' <a class="btn btn-info" href="' . URLROOT . '/cdn/upload/' . $documents->getFileName() . '" role="button">Enviar para CDN</a>';
} else {
  //echo '<a class="btn btn-warning disabled" href="' . URLROOT . '/cdn/delete/' . $documents->getFileName() . '" role="button" aria-disabled="true">Apagar no CDN</a>';
}

if ($documents->getCdn() == 1 & $settings->getBunny() == 1) {
  echo ' <a class="btn btn-warning" href="' . URLROOT . '/cdn/delete/' . $documents->getFileName() . '" role="button">Apagar no CDN</a>';
} else {
  //echo '<a class="btn btn-warning disabled" href="' . URLROOT . '/cdn/delete/' . $documents->getFileName() . '" role="button" aria-disabled="true">Apagar no CDN</a>';
}
?>
</form>
</div>
</div>
</div>
<!--
<center>
  <object data="<?php echo URLROOT; ?>/files/<?php echo $documents->getFileName(); ?>" type="application/pdf" width="800px" height="800px">
    <p>Seu navegador não tem um plugin pra PDF</p>
  </object>
</center>
-->

<script type="text/javascript" src="<?php echo URLROOT; ?>/js/jquery-3.5.1.slim.min.js"></script>
<script src="<?php echo URLROOT; ?>/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>