<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<body>
    <div id = "main-content">
        <div id = "buttons">
            <div id = "back-arrow">Back</div>

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

        <input maxlength = "57" class = "input" id = "action-input" placeholder = "action"></input>

        <div class = "warning" id = "action-repeat-warning"></div>

        <textarea maxlength = "1025" class = "input" id = "description-input" placeholder = "result"></textarea>

        <div class = "warning" id = "missing-result-warning"></div>

        <div id = "submit-new">Submit</div>

        <div class = "gap">
        </div>
    </div>

    <div id = "footer">
        <?php if ($node['reports'] >= 0) { ?>
            <div class = "footer-item right" id = "report">Report Entry</div>
        <?php } ?>
    </div>
</body>

<script>
    var goToPage = function (id)
    {
        window.location = "<?php echo base_url(); ?>?i=" + id;
    };

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
            url:"<?php echo base_url(); ?>index.php/main/fileReport",
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
