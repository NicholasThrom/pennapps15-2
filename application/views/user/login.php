<body>
    <div class = "main">
        <div class = "vgap"></div>
        <div class = "vgap"></div>
        <div class = "warning" id = "login-warning"></div>
        <div>
            <input placeholder = "username" class = "input thin" id = "username"/>
        </div>
        <div>
            <input type = "password" placeholder = "password" class = "input thin" id = "password"/>
        </div>
        <div class = "sgap"></div>
        <div class = "button" id = "login">
            Login
        </div>

    </div>
</body>

<script>
    var login = function ()
    {
        if ($("#username").val() != "" && $("#password").val() != "")
        {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/ajax/login",
                type: "post",
                data: {
                    u: $("#username").val(),
                    p: $("#password").val()
                },
                success: function (data) {
                    if (data == 1)
                    {
                        window.location = "<?php echo base_url(); ?>index.php/user/info";
                    }
                    else
                    {
                        $("#login-warning").css("display", "block");
                        $("#login-warning").html("Login failed.");
                    }
                }
            });
        }
        else
        {
            $("#login-warning").css("display", "block");
            if ($("#username").val() == "" && $("#password").val() != "")
            {
                $("#login-warning").html("Username is required.");
            }
            else if ($("#username").val() != "" && $("#password").val() == "")
            {
                $("#login-warning").html("Password is required.");
            }
            else if ($("#username").val() == "" && $("#password").val() == "")
            {
                $("#login-warning").html("Username and password is required.");
            }
        }
    };

    $("#login").click(login);

    $(document).keydown(function (event)
    {
        switch (event.keyCode)
        {
            case 13:
                login();
                break;
        }
    });

</script>
