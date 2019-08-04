<?php 
    // instantiate navhandler class
    // $navHandler = new NavHandler();

    // get header settings field group
    $settings = get_field('header_settings', 'options');
    $company_info = get_field('company_info', 'options');

    $return['header_nav'] = '';
    
    $guide['header_nav'] = '
        <header class="header header__style_one">
            <div class="container">

                <div>
                    <figure class="logo">
                        <img src="%s" width="240">
                    </figure>    
                    <div>
                        %s
                        <div class="site__telnums">
                            <p>Call us Today</p>
                            %s
                            %s
                        </div>
                    </div>
                </div>
                <div>
                    %s
                    %s
                </div>
            </div>
        </header>
    ';



    $return['header_nav'] .= sprintf(
        $guide['header_nav']
        ,$settings['logo']['url']
        ,get_full_address($icon = true)
        ,(!empty($company_info['phone_number_1']) ? '<a class="site__iconlink site__iconlink-phone" href="tel:' . $company_info['phone_number_1'] . '">' . $company_info['phone_number_1'] . '</a>' : '')
        ,(!empty($company_info['phone_number_2']) ? '<a class="site__iconlink site__iconlink-phone" href="tel:' . $company_info['phone_number_2'] . '">' . $company_info['phone_number_2'] . '</a>' : '')
        ,wp_nav_menu(array('theme_location'=>'header','walker'=> new Rational_Walker_Nav_Menu,'echo'=>false,'container' => 'nav','container_class'=>'navlinks'))
        ,get_social_icons()
    );
    

    echo $return['header_nav'];
 ?>