<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$hook['display_override'] = array(
    'class'    => 'ReplaceTitel',
    'function' => 'replaceValue',
    'filename' => 'ReplaceTitel.php',
    'filepath' => 'hooks'
);
?>
