<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script src="<?= base_url().'/assets/js/jquery.min.js' ?>"></script>
<script src="<?= base_url().'/assets/js/bootstrap.min.js' ?>"></script>
<script src="<?= base_url().'/assets/js/jquery-ui.js' ?>"></script>
<script src="<?= base_url().'/assets/js/main_script.js' ?>"></script>
<?php if(isset($footerScriptData)){AN_footer_script($footerScriptData);}else{ AN_footer_script();} ?>   
</body>
</html>