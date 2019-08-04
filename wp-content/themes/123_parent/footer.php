<?php
/**
 * 
 */
    $footer_settings = get_field('footer_settings', 'options');
    $company_info = get_field('company_info', 'options');


    $return['footer'] = '';


    $guide['footer'] = '
        <footer class="footer">
            <div class="container %s">
                <section>
                    %s
                    %s
                    %s
                    %s
                </section>
                <section>
                    %s
                </section>
                <section>
                    %s
                </section>
                <section>
                    %s
                </section>
            </div>
            %s
        </footer>
    ';


    $guide['reseller_logo'] = '<div>%s%s%s%s</div>';
    $return['reseller_logo'] = '';
    $return['reseller_logo'] .= sprintf(
        $guide['reseller_logo']
        ,( 
            ( !empty($footer_settings['copyright_banner']['reseller']['link']) ) 
            ? '<a href="'.$footer_settings['copyright_banner']['reseller']['link'].'">' 
            : ''
        )
        ,$footer_settings['copyright_banner']['reseller']['text']
        ,'<img class="reseller-logo" src="' . $footer_settings['copyright_banner']['reseller']['logo']['url'] . '">'
        ,(
            ( !empty($footer_settings['copyright_banner']['copyright_url']) )
            ? '</a>'
            : ''
        )
    );
    




    // 
    $return['copyright_banner'] = '';
    if( !empty( $footer_settings['copyright_banner']['copyright_url'] ) || !empty($footer_settings['copyright_banner']['copyright_text']) ){
        
        $guide['copyright_banner'] = '%s%s%s%s%s';

        $return['copyright_banner'] .= sprintf(
            $guide['copyright_banner']
            ,'<section class="banner banner__copyright"><div class="container">'
            ,( (!empty($footer_settings['copyright_banner']['copyright_url'])) ? '<a href="'.$footer_settings['copyright_banner']['copyright_url'].'">' : '' )
            ,$footer_settings['copyright_banner']['copyright_text']
            ,$return['reseller_logo']
            ,'</div></section>'
        );
    }
    // 

  


    $return['footer'] .= sprintf(
        $guide['footer']
        ,$footer_settings['width']
        // 1st section
        ,( !empty($footer_settings['logo']['url']) ? '<figure class="logo"><img src="'. $footer_settings['logo']['url'].'" width="240"></figure>' : '' )    // if/get logo
        ,get_full_address($icon = true) 
        ,(!empty($company_info['phone_number_1']) ? '<p><a class="site__iconlink site__iconlink-phone" href="tel:' . $company_info['phone_number_1'] . '">' . $company_info['phone_number_1'] . '</a></p>' : '')
        ,(!empty($company_info['phone_number_2']) ? '<p><a class="site__iconlink site__iconlink-phone" href="tel:' . $company_info['phone_number_2'] . '">' . $company_info['phone_number_2'] . '</a></p>' : '')
        // 2nd section
        ,wp_nav_menu(array('theme_location'=>'footer','walker'=> new Rational_Walker_Nav_Menu,'echo'=>false,'container' => 'nav','container_class'=>'navlinks'))
        // 3rd section
        ,get_social_icons()
        // 4th section
        ,return_icon_links($footer_settings['payment_types']['icon_links'])
        ,$return['copyright_banner']
    );

    

    echo $return['footer'];    


    
    
    

    // include popups
    // include_once(get_template_directory() . '/parts/popups/popup.loader.php');

    // live reload script
    if( in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1')) && !is_admin() ){ echo '<script src="//localhost:35729/livereload.js"></script>'; }
    wp_footer();
?>
</body>
</html>