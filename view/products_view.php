<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo URLROOT ?>/css/bootstrap.min.css" crossorigin="anonymous">

    <title>Library</title>
    <style>
[class*="col"] {
    margin-bottom: 5px;
}
      </style>

  <script src="https://kit.fontawesome.com/14edfcae2f.js" crossorigin="anonymous"></script>
  </head>
  <body>
  <?php require_once 'menu.php'; ?>
  
<div class="container">
  <div class="input-group mb-3">
    <div class="form-group col-md-2">
      <div class="px-2">
        <center><a class="btn btn-primary" href="<?php echo URLROOT; ?>/products/new/" role="button">Novo Produto</a></center>
      </div>
    </div>
    
    <div class="form-group col-md-9">
      <form action="<?php echo URLROOT; ?>/products/search" method="post">
        <div class="input-group">
          <input type="text" class="form-control" id="inputSearch" name="search" placeholder="Nome ou SKU do Produto" maxlength="100" autofocus>
            <div class="input-group-append">
              <button class="btn btn-primary" type="submit">Buscar Produto</button>
            </div>
        </div>
      </form>
    </div>
    <div class="form-group col-md-1">
      <div class="px-2">
        <center><a class="btn btn-success" href="<?php echo URLROOT; ?>/products/spreadsheet/" role="button">Planilha</a></center>
      </div>
    </div>
  </div>
</div>

<div class="px-3 pt-md-3 pb-md-4 mx-auto text-center">

<?php

function Mask($mask,$str){
  $str = str_replace(" ","",$str);
  for($i=0;$i<strlen($str);$i++){
      $mask[strpos($mask,"#")] = $str[$i];
  }
  return $mask;
}

$resultado = $products->get_all_products();
if(count($resultado) >= 1){
?>

 <div id="lista_de_clientes" class="row">
    <div class="table-responsive col-md-12">
        
    <div class="container">
    <div class="row">
      <div class="col p-2 col-md-2"><b>SKU</b></div>
      <div class="col p-2"><b>Descrição</b></div>
      <div class="col p-2 col-md-1"><b>Fotos</b></div>
      <div class="col p-2 col-md-2"><b>Ações</b></div>
 

      <?php
      $i = 0;
foreach($resultado as &$value):
    ?>
      <div class="w-100"></div>
      <div class="col<?php echo !($i % 2) ? " bg-light text-dark p-2" : " p-2"; ?> col-md-2"><?php echo $value["stock_keeping_unit"]; ?></div>  
      <div class="col<?php echo !($i % 2) ? " bg-light text-dark p-2" : " p-2"; ?>"><?php echo $value["description"]; ?></div>
      <div class="col<?php echo !($i % 2) ? " bg-light text-dark p-2" : " p-2"; ?> col-md-1"><?php echo $value["count"]; ?> X <i class="fa-solid fa-image"></i></div>  
      <div class="col<?php echo !($i % 2) ? " bg-light text-dark p-2" : " p-2"; ?> col-md-2"><a class="btn btn-primary btn-xs" href="<?php echo URLROOT; ?>/products/edit/<?php echo $value["stock_keeping_unit"]; ?>">Visualizar</a></div>   
      
      <?php
      $i++;
endforeach;
    ?>


</div>
     </div>
 </div> <!-- /#list -->
<?php
} else {
?>
<div id="lista_de_clientes">
    <img src="<?php echo URLROOT; ?>/img/resultado.svg" alt="some text" width=304 height=182>
    <p>Ops! Nenhum resultado encontrado! :(</p>
</div>
<?php
}
?>
 

</div>

<script type="text/javascript" src="<?php echo URLROOT; ?>/js/jquery-3.5.1.slim.min.js"></script>
<script src="<?php echo URLROOT; ?>/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>