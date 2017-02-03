<body>
    <div class = "main">
        <div class = "vgap"></div>
        <div class = "vgap"></div>
        <div class = "warning" id = "create-warning"></div>
        <div>
            <input placeholder = "username" class = "input thin" id = "username"/>
        </div>
        <div>
            <input type = "password" placeholder = "password" class = "input thin" id = "password"/>
        </div>
        <div>
            <input type = "password" placeholder = "confirm password" class = "input thin" id = "confirm-password"/>
        </div>
        <div class = "sgap"></div>
        <div class = "button" id = "create">
            Register
        </div>

    </div>
</body>
<script>
    var create = function ()
    {
        if (verify())
        {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/ajax/createUser",
                type: "post",
                data: {
                    u: $("#username").val(),
                    p: $("#password").val()
                },
                success: function (data)
                {
                    if (data == 1)
                    {
                        window.location = "<?php echo base_url(); ?>index.php/user/info";
                    }
                    else
                    {
                        $("#create-warning").css("display", "block");
                        $("#create-warning").html(data);
                    }
                }
            });
        }
    };

    var verify = function ()
    {
        console.log("!");
        if ($("#username").val() == "" && $("#password").val() != "")
        {
            $("#create-warning").css("display", "block");
            $("#create-warning").html("Username is required.");
            return false;
        }
        else if ($("#username").val() != "" && $("#password").val() == "")
        {
            $("#create-warning").css("display", "block");
            $("#create-warning").html("Password is required.");
            return false;
        }
        else if ($("#username").val() == "" && $("#password").val() == "")
        {
            $("#create-warning").css("display", "block");
            $("#create-warning").html("Username and password is required.");
            return false;
        }
        else if ($("#confirm-password").val() != $("#password").val())
        {
            $("#create-warning").css("display", "block");
            $("#create-warning").html("Passwords do not match.");
            return false;
        }
        else
        {
            $("#create-warning").css("display", "none");
            return true;
        }
    };

    $("#create").click(create);

    $(document).keydown(function (event)
    {
        switch (event.keyCode)
        {
            case 13:
                break;
        }
    });

</script>
