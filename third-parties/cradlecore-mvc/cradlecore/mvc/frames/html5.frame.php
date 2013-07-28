<!doctype html>
<html lang="en">
    <head>
        <title><?php echo $title ?></title>
        <meta charset="utf-8">
<script type="text/javascript">var CRADLECORE_ENTRYPOINT = '<?php echo $entryPoint ?>';</script>
<?php AssetsRenderer::addTopAssets($this->httpObject) ?>       
    </head>
    <body>
        
        <?php echo $markup ?>

<?php AssetsRenderer::addBottomAssets($this->httpObject) ?>
        
    </body>  
</html>