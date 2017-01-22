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
            $("*").attr("href", "");
            setTimeout(function () {goToPage(1);}, 1000);
        }
    });
};

var restart = function ()
{
    goToPage(1);
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

$(document).keydown(function (event)
{
    switch (event.keyCode)
    {
        case 13:
            submit();
            break;
    }
});
