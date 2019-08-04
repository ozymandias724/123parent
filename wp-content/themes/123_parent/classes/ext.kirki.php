<?php
/**
* 
*/

Kirki::add_config('kirki_config', array(
    'capability'    => 'edit_theme_options',
    'option_type'   => 'theme_mod',
));

    include('kirki/kirki.panels.php');
    include('kirki/kirki.sections.php');
    include('kirki/kirki.controls.php');

 ?>
