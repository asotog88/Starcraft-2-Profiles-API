<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
    <title><?php echo $title ?></title>
<script type="text/javascript">var CRADLECORE_ENTRYPOINT = '<?php echo $entryPoint ?>';</script>
<?php AssetsRenderer::addTopAssets($this->httpObject) ?>
    </head>
    <body>
        <?php echo $markup ?>

<?php AssetsRenderer::addBottomAssets($this->httpObject) ?>
        
    </body>
</html>