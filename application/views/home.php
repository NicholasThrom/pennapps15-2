<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Endless Pathway</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/main.css">
</head>
<body>
    <div id = "buttons">
        <?php if ($node['reports'] >= 0) { ?>
            <div id = "report">Report</div>
        <?php } ?>

        <div id = "restart">Restart</div>
    </div>

    <div class = "situation">
        <?php echo $node['description']; ?>
    </div>

    <?php $i = 0; foreach($options as $option) { $i++; ?>
        <div onclick = "goToPage(<?php echo $option['id_node']?>);" class = "option s<?php echo $i; ?>">
            <?php echo $option['action']; ?>
        </div>
    <?php } ?>

    <input maxlength = "31" class = "input" id = "action-input" placeholder = "action"></input>

    <div class = "warning" id = "action-repeat-warning"></div>

    <textarea maxlength = "1025" class = "input" id = "description-input" placeholder = "result"></textarea>

    <div id = "submit-new">Submit</div>
</body>
<script src = "<?php echo base_url(); ?>assets/js/main.js"></script>
</html>
