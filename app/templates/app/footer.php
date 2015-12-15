
</div>

<!-- JS -->
<?php
helpers\assets::js(array(
    helpers\url::app_template_path() . 'js/jquery-1.11.2.min.js',
    helpers\url::app_template_path() . 'js/nicEdit.js',
    helpers\url::app_template_path() . 'js/jquery.auto-complete.min.js',
    helpers\url::app_template_path() . 'js/jquery.filter_input.js',
    helpers\url::app_template_path() . 'js/bootstrap.min.js',
    helpers\url::app_template_path() . 'js/jquery.timepicker.js',
    helpers\url::app_template_path() . 'js/jsgrid.min.js',
    helpers\url::app_template_path() . 'js/accounting.min.js',
    helpers\url::app_template_path() . 'js/scripts.js'
))
?>
<?php echo $data["js"]; ?>
</body>
</html>
