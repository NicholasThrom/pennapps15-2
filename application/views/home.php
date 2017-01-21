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
        text-align: center;
    }

    .situation {
        width: 30vw;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
        margin-top: 10vh;
        border: 1px solid #B3D9FF;
        padding: 1rem;
        border-radius: 1rem;
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
        background-color: #45364D;
        color: #CFA1E6;
        border-color: #CFA1E6;
    }

    .option.s2:hover {
        background-color: #364D3E;
        color: #A1E6B8;
        border-color: #A1E6B8;
    }

    .option.s3:hover {
        background-color: #4D4736;
        color: #E6D4A1;
        border-color: #E6D4A1;
    }

    .input {
        background-color: transparent;
        outline: none;
        border: none;
        border-bottom: 1px solid #B3D9FF;
        width: 20vw;
        margin-left: auto;
        margin-right: auto;
        margin-top: 1.5rem;
        color: inherit;
        font-family: inherit;
        font-size: inherit;
        text-align: center;
        padding: 0.3rem;
        resize: none;
    }

    #action-input {
        display: block;
        margin-top: 3rem;
    }

    #description-input {
        display: none;
        border-radius: 1rem;
        border: 1px solid #B3D9FF;
        opacity: 0;
        resize: none;
        padding-top: 1.2rem;
        padding-bottom: 0.5rem;
        vertical-align:middle;
    }

    #submit-new {
        display: none;
        margin-left: auto;
        margin-right: auto;
        cursor: pointer;
        margin-top: 1.5rem;
        opacity: 0;
    }

    #submit-new:hover {
        font-weight: 900;
    }


    ::-webkit-input-placeholder {
        color: #6B8199;
    }

    :-moz-placeholder {
        color: #6B8199;
    }

    ::-moz-placeholder {
        color: #6B8199;
    }

    :-ms-input-placeholder {
        color: #6B8199;
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
    <input maxlength = "31" class = "input" id = "action-input" placeholder = "action"></input>
    <textarea maxlength = "1025" class = "input" id = "description-input" placeholder = "result"></textarea>
    <div id = "submit-new">Submit</div>
</body>
<script>
    var submit = function ()
    {
        if ($("#action-input").val().trim() != "" && $("#description-input").val().trim() != "")
        {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/main/addNode",
                type: "post",
                data: {
                    a: $("#action-input").val(),
                    d: $("#description-input").val(),
                    i: "<?php echo $id_node; ?>"
                },
                success: function (data) {if (data != -1) {window.location = "<?php echo base_url(); ?>?i=" + data;}}
            });
        }
    }

    $("#action-input").focus(function () {
        $("#description-input").css("display", "block");
        $("#description-input").animate({opacity: 1});
        $("#submit-new").css("display", "inline-block");
        $("#submit-new").animate({opacity: 1});
    });

    $("#submit-new").click(submit);

    $(document).keydown(function (event)
    {
        switch (event.keyCode)
        {
            case 13:
                submit();
                break;
        }
    });


</script>
</html>
