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
<form action="<?php echo URLROOT; ?>/banner/update/<?php echo $banner->getId(); ?>" method="post">
  <div class="form-row">
    <div class="form-group col-md-2">
      <label for="inputSku">Id</label>
      <input type="text" class="form-control" id="inputSku" name="sku" value="<?php echo $banner->getId(); ?>" maxlength="100" readonly>
    </div>
    <div class="form-group col-md-10">
      <label for="inputSku">Descrição do Banner</label>
      <input type="text" class="form-control" id="inputDescricao" name="descricao" value="<?php echo $banner->getDescription(); ?>" maxlength="100">
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="exampleFormControlTextarea1" class="form-label">Código Json <?php echo $banner->getName(); ?></label>
      <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" style="height: 299px;"><?php //echo $banner->getCode();

$banner_id = $banner->getId();
$banner_name = $banner->getName();
$db = pg_connect("host=localhost port=5432 dbname=library user=postgres password=postgres");
//$result = pg_query($db,"SELECT sequence, file_name FROM public.view_photo_products where stock_keeping_unit = '$sku' order by sequence");
$result = pg_query($db,"SELECT banner_box.file_name from banner INNER JOIN banner_box ON banner.id = banner_box.id_banner WHERE device = 'd' AND banner.id = $banner_id order by banner_box.sequence");
$array_banner_name = array();
$array_banner_name_teste = array();
while($row=pg_fetch_assoc($result)){
$banner = "https://" . $_SERVER['SERVER_NAME'] . URLROOT . "/banner/" . $banner_name  . "/" . $row['file_name'];
//array_push($array_banner_name, $banner);
$arr = array('type' => 'image', 'src' => $banner, 'alt' => 'Banner');
array_push($array_banner_name_teste, $arr);
}

$result2 = pg_query($db,"SELECT banner_box.file_name from banner INNER JOIN banner_box ON banner.id = banner_box.id_banner WHERE device = 'm' AND banner.id = $banner_id order by banner_box.sequence");
$array_banner_name2 = array();
$array_banner_name_teste2 = array();
while($row2=pg_fetch_assoc($result2)){
$banner2 = "https://" . $_SERVER['SERVER_NAME'] . URLROOT . "/banner/" . $banner_name  . "/" . $row2['file_name'];
//array_push($array_banner_name, $banner);
$arr2 = array('type' => 'image', 'src' => $banner2, 'alt' => 'Banner');
array_push($array_banner_name_teste2, $arr2);
}

//$arr = array("language" => "pt", 'medias' => ["desktop" => ["type" => "image", 'src' => $array_banner_name[0], "alt" => "Banner"]]);
//$arr = array("language" => "pt", 'medias' => ["desktop" => $array_banner_name]);
$arr0 = array("language" => "pt", 'medias' => ["desktop" => $array_banner_name_teste, "mobile" => $array_banner_name_teste2]);
$array_pai = array();
array_push($array_pai, $arr0);
echo json_encode($array_pai, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
?></textarea>
      </div></div>

<button type="submit" class="btn btn-primary">Atualizar</button>
<a class="btn btn-info" id="newFile" href="<?php echo URLROOT; ?>/bannerfile/new/<?php echo $banner_name; ?>" role="button">Adicionar imagem</a>
<a class="btn btn-danger" href="<?php echo URLROOT; ?>/banner/delete/<?php echo $banner_id; ?>" role="button">Deletar</a>
<a class="btn btn-warning" href="<?php echo URLROOT; ?>/banner/visualizar" role="button">Cancelar</a>
<br><br>
<a class="btn btn-info" id="newPhoto" href="<?php echo URLROOT; ?>/photo/new/<?php echo $banner_id; ?>" role="button">Visualizar Desktop</a> <a class="btn btn-info" id="newPhoto" href="<?php echo URLROOT; ?>/photo/new/<?php echo $banner_id; ?>" role="button">Visualizar Mobile</a>
</form>
</div>
</div>
</div>

<script type="text/javascript" src="<?php echo URLROOT; ?>/js/jquery-3.5.1.slim.min.js"></script>
<script src="<?php echo URLROOT; ?>/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>