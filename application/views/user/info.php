<body>
    <div class = "main">
        <div class = "item">
            <?php echo $user['username']; ?> <br/>
        </div>
        <div class = "item">
            <?php echo $user['status']; ?> <br/>
        </div>
        <div class = "item button" id = "logout">
            Logout
        </div>
    </div>
</body>

<script>
    var logout = function ()
    {
        window.location = "<?php echo base_url(); ?>index.php/user/logout";
    };

    $("#logout").click(logout);

    $(document).keydown(function (event)
    {
        switch (event.keyCode)
        {
            case 13:
                break;
        }
    });

</script>
