<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php

    $this->load->view("template/head", $headdata);
    $this->load->view($view, $viewdata);
    $this->load->view("template/foot", $footdata);

?>
