<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if (is_singular() && get_option('thread_comments')) wp_enqueue_script('comment-reply'); ?>
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>

<?php
/**
 *  Choose from multiple styles of nav
 */
    $headerStyle = ( (!empty(get_field())) ? '' : '' );
    $header = get_field('header', 'options');
    $selected_header = 'header__' . $header['style'];
    $banner_popup_status = (get_field('popups', 'options')['banner']['status'] == 1 ? 'banner_popup' : '');

    $body_classes = array(
        (!empty(get_field('header', 'options')['long_scroll']) ? 'js__smoothscroll' : ''), $selected_header, $banner_popup_status, 'narrow'
    );
?>

<body <?php body_class($body_classes); ?>>
    <?php
    include_once(get_template_directory() . '/parts/popups/popup.loader.php');
    include('parts/nav.desktop.php');
    include('parts/nav.mobile.php');
    /**
     *  Clean Up 
     */
    unset($body_classes);
    ?>