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
        background-color: #36414D;
        color: #B3D9FF;
        font-family: "Lucida Console", Monaco, monospace;
        font-weight: 100;
    }

    .situation {
        width: 30vw;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
        margin-top: 10vh;
        border: 1px solid #B3D9FF;
        padding: 1rem;
    }



    #submit-new {
        display: inline-block;
    }
    #submit-new:hover {
        background-color: grey;
    }

    .option {
        width: 20vw;
        border: 1px solid #B3D9FF;
        padding: 0.5rem;
        margin-left: auto;
        margin-right: auto;
        margin-top: 1rem;
    }

    .option a {
        text-decoration: none;
        color: inherit;
        display: inline-block;
        width: 100%;
        text-align: center;
    }

    .option.s1:hover {
        background-color: #4D3636;
        color: #E6A1A1;
        border-color: #E6A1A1;
    }

    .option.s2:hover {
        background-color: green;
    }

    .option.s3:hover {
        background-color: blue;
    }

    #action-input {
        display: block;
        background-color: transparent;
        outline: none;
        border: none;
        border-bottom: 1px solid #B3D9FF;
        width: 20vw;
        margin-left: auto;
        margin-right: auto;
        margin-top: 1rem;
    }

    #description-input {
        background-color: transparent;
        outline: none;
        border: none;
    }

    </style>
</head>
<body>
    <div class = "situation">
    <?php echo $node['description']; ?>
    </div>
    <?php $i = 0; foreach($options as $option) { $i++; ?>
        <div class = "option s<?php echo $i; ?>">
            <a href = "<?php echo base_url(); ?>?i=<?php echo $option['id_node']?>"><?php echo $option['action']; ?></a>
        </div>
    <?php } ?>
    <input id = "action-input"></input>
    <input id = "description-input"></input>
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
