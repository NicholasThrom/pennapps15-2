<body>
    <div class = "main">
        <div class = "vgap"></div>
        <div class = "vgap"></div>
        <div class = "button" id = "logout">
            Logout
        </div>
    </div>
</body>

<script>
    var logout = function ()
    {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/ajax/logout",
            success: function (data) {
                window.location = "<?php echo base_url(); ?>index.php/user/login";
            }
        });
    };

    $("#logout").click(logout);

    $(document).keydown(function (event)
    {
        switch (event.keyCode)
        {
            case 13:
                logout();
                break;
        }
    });
</script>
