<body>
    <div id="main-content">
        <?php for ($i = count($nodes) - 1; $i >= 0; $i--) { ?>
            <div class = "block">
                <div class = "result">
                    <?php echo $nodes[$i]['description']; ?><br/>
                </div>

                <?php if ($i != 0) { ?>
                    <div class = "action">
                        <?php echo $nodes[$i - 1]['action']; ?><br/>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</body>

<script>
    window.scrollTo(0, document.body.scrollHeight);
</script>
