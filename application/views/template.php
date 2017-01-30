<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php

    $this->load->view("head", $headdata);
    $this->load->view($view, $viewdata);
    $this->load->view("foot", $footdata);

?>
