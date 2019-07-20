<?php
/**
 * 
 */
    $return['footer'] = '';
?>
<footer>
    <?= $return['footer']; ?>
</footer>
<?php
    // live reload script
    if( in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1')) && !is_admin() ){ echo '<script src="//localhost:35729/livereload.js"></script>'; }
    wp_footer();
?>
</footer>
</body>
</html>