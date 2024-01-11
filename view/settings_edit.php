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
    .mt-4,
    .my-4 {
      margin-top: 2rem !important;
    }
  </style>

</head>

<body>
  <?php require_once 'menu.php'; ?>
  <div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center col-md-8 order-md-1">
    <div class="card">
      <div class="card-body">
        <form action="<?php echo URLROOT; ?>/settings/save" method="post">
        <div class="form-row">
          <div class="form-group col-md-2">
            <label for="inputSku"><a href="https://hCaptcha.com/?r=9d7680486bca" target="_blank">hCaptcha</a></label><br>
            <input class="form-check-input" type="checkbox" value="" id="inputHcaptcha" name="hcaptcha" <?php echo ($settings->getHcaptcha() == 1) ? 'checked' : ''; ?>>
            <label class="form-check-label" for="defaultCheck1">
            <?php echo ($settings->getHcaptcha() == 1) ? 'Ativado' : 'Desativado'; ?>
            </label>
          </div>
          <div class="form-group col-md-5">
            <label for="inputSku">hCaptcha Secret</label>
            <input type="text" class="form-control" id="inputHcaptchaSecret" name="hcaptcha_secret" value="<?php echo $settings->processaString($settings->getHcaptchaSecret()); ?>" maxlength="100">
          </div>
          <div class="form-group col-md-5">
            <label for="inputSku">Hcaptcha Data-Sitekey</label>
            <input type="text" class="form-control" id="inputHcaptchaDataSitekey" name="hcaptcha_data_sitekey" value="<?php echo $settings->processaString($settings->getHcaptchaDataSitekey()); ?>" maxlength="100">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-2">
            <label for="inputSku"><a href="https://bunny.net?ref=q88mxhh13h" target="_blank">Bunny</a></label><br>
            <input class="form-check-input" type="checkbox" value="" id="inputBunny" name="bunny" <?php echo ($settings->getBunny() == 1) ? 'checked' : ''; ?>>
            <label class="form-check-label" for="defaultCheck1">
            <?php echo ($settings->getBunny() == 1) ? 'Ativado' : 'Desativado'; ?>
            </label>
          </div>
          <div class="form-group col-md-5">
            <label for="inputSku">Bunny CDN Region</label>
            <input type="text" class="form-control" id="inputBunnyCdnRegion" name="bunny_cdn_region" value="<?php echo $settings->getBunnyCdnRegion(); ?>" maxlength="100">
          </div>
          <div class="form-group col-md-5">
            <label for="inputSku">Bunny CDN Storage Name</label>
            <input type="text" class="form-control" id="inputBunnyCdnStorageName" name="bunny_cdn_storage_name" value="<?php echo $settings->getBunnyCdnStorageName(); ?>" maxlength="100">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="inputSku">Bunny Storage Zone Key</label>
            <input type="text" class="form-control" id="inputBunnyCdnKey" name="bunny_cdn_key" value="<?php echo $settings->processaString($settings->getBunnyCdnKey()); ?>" maxlength="100">
          </div>
          <div class="form-group col-md-6">
            <label for="inputSku">Bunny Linked Hostname</label>
            <input type="text" class="form-control" id="inputBunnyLinkedHostname" name="bunny_linked_hostname" value="<?php echo $settings->getBunnyLinkedHostname(); ?>" maxlength="100">
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a class="btn btn-warning" href="<?php echo URLROOT; ?>/settings/edit" role="button">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
    <script type="text/javascript" src="<?php echo URLROOT; ?>/js/jquery-3.5.1.slim.min.js"></script>
    <script src="<?php echo URLROOT; ?>/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</body>

</html>