<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Board</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <style>
    body {
      background-color: #3C484D;
      color: #C9F2FF;
    }
    #submit-new {
      display: inline-block;
    }
    #submit-new:hover {
      background-color: grey;
    }
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
            data: {
                a: $("#action-input").val(),
                d: $("#description-input").val(),
                i: "<?php echo $id_node; ?>"
            },
            success: function (data) {window.location = "<?php echo base_url(); ?>?i=" + data;}
        });
    });
</script>
</html>
