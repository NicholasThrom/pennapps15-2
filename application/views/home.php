<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Board</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <style>
    </style>
</head>
<body>
    <?php echo $node['description']; ?>
    New:
    <input id = "action-input" name = "action"></input>
    Result:
    <input id = "description-input" = "description"></input>
    <div id = "submit-new">Submit</div>
</body>
<script>
$("#submit-new").click(function () {
    $.ajax({
        url: "<?php echo base_url(); ?>index.php/main/addNode",
        type: "post",
        data: {a: $("#action-input").value, d: $("#description-input").value}
    });
});
</script>
</html>
