<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title(); ?></title>
    <?php 
        $classes = [
            (!empty(get_field('site_settings', 'options')['content_width']) ? 'sitewidth__'.get_field('site_settings', 'options')['content_width'] : '')
            ,'debug'
        ];
    
        wp_head();
     ?>
</head>
<body <?php body_class($classes); ?>>
<?php
    include('parts/nav.desktop.php');
    // try to remove the need to use a separate mobile nav please!
    // include('parts/nav.mobile.php');
?>