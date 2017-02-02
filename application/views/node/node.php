<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<body>
    <div class = "main">
        <div id = "buttons">
            <div class = "button" id = "back-arrow">Back</div>

            <div class = "button" id = "restart">Restart</div>
        </div>

        <div class = "outline situation-block">
            <?php echo $node['description']; ?>
        </div>

        <?php $i = 0; foreach($options as $option) { $i++; ?>
            <div onclick = "goToPage(<?php echo $option['id_node']?>);" class = "option s<?php echo $i; ?>">
                <?php echo $option['action']; ?>
            </div>
        <?php } ?>

        <input maxlength = "<?php echo MAX_ACTION; ?>" class = "input" id = "action-input" placeholder = "action"></input>

        <div class = "warning" id = "action-repeat-warning"></div>

        <textarea maxlength = "<?php echo MAX_DESCRIPTION; ?>" class = "input" id = "description-input" placeholder = "result"></textarea>

        <div class = "warning" id = "missing-result-warning"></div>

        <div class = "button" id = "submit-new">Submit</div>

        <div class = "gap"></div>
    </div>

    <div id = "footer">

        <?php if ($node['reports'] >= 0) { ?>
            <div class = "footer-item right button" id = "report">Report Entry</div>
        <?php } ?>

        <div class = "footer-item right button" id = "log">Log</div>

    </div>
</body>

<script>
    var goToPage = function (id)
    {
        window.location = "<?php echo base_url(); ?>?i=" + id;
    };

    var goToLog = function (id)
    {
        window.location = "<?php echo base_url(); ?>index.php/node/log/?i=" + id;
    };

    var submit = function ()
    {
        if ($("#action-input").val().trim() != "" && $("#description-input").val().trim() != "")
        {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/ajax/addNode",
                type: "post",
                data: {
                    a: $("#action-input").val(),
                    d: $("#description-input").val(),
                    i: "<?php echo $id_node; ?>"
                },
                success: function (data) {
                    if (data != -1)
                    {
                        goToPage(data);
                    }
                    else
                    {
                        $("#action-repeat-warning").css("display", "block");
                        $("#action-repeat-warning").html("The action \"" + $("#action-input").val() + "\" is already taken.");
                    }
                }
            });
        }
        else
        {
            $("#missing-result-warning").css("display", "block");
            $("#missing-result-warning").html("Please fill out both fields.");
        }
    };

    var report = function ()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>index.php/ajax/fileReport",
            type: "post",
            data: {
                i: "<?php echo $id_node; ?>"
            },
            success: function () {
                $("#report").css("color", "#E65C5C");
                $("*").click(function () {});
                $("*").attr("onclick", "");
                setTimeout(function () {goToPage(1);}, 1000);
            }
        });
    };

    var restart = function ()
    {
        goToPage(1);
    };

    var back = function ()
    {
        goToPage(<?php echo $node['source_node']; ?>);
    };

    var log = function ()
    {
        goToLog(<?php echo $id_node; ?>);
    };

    $("#action-input").focus(function () {
        $("#description-input").css("display", "block");
        $("#description-input").animate({opacity: 1});
        $("#submit-new").css("display", "inline-block");
        $("#submit-new").animate({opacity: 1});
    });

    $("#submit-new").click(submit);
    $("#report").click(report);
    $("#restart").click(restart);
    $("#back-arrow").click(back);
    $("#log").click(log);

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
