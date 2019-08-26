<?php
// 
// 
// library / requirements
require('includes/util.general.php');       // helpers
require('includes/acf.extensions.php');     // php extensions for acf (options pages, manually defined fields, other stuff?)
require('classes/class.NavWalker.php');     // wordpress built in nav
require('classes/class.NavHandler.php');    // handler for creating theme headers

// 
// setup the theme
require('classes/class.Setup.php');         // Theme Setup / Init
require('classes/class.UserRoles.php');     // Custom Users and Roles
require('classes/class.customposts.php'); // custom posts
require('classes/ext.kirki.php');




// USE THIS HAMMER IF NEED
// careful! hammer big!
// remove_theme_mods();
// 
// 



if (!function_exists('return_icon_links')) {
    /**
     * Return Icon Links String
     *
     * @param array $res
     * @return string
     */
    function return_icon_links( $res ){
        // safety first
        if (!empty($res)) {
            
            // create empty return string
            $return['iconlinks'] = '';
            
            // create format string
            $guide['iconlinks'] = '%s';

            // open container
            $return['iconlinks'] = '<ul class="site__iconlinks">';
            
            // iterate thru icon links
            // $rec['icon'] is an object
            foreach ($res as $rec) {
                
                // open item
                $return['iconlinks'] .= '<li>';
                
                // write anchor if exists
                $return['iconlinks'] .= ( !empty($rec['url']) ? '<a href="'.$rec['url'].'">' : '' );

                // get icon
                $icon = ( 
                    // if svg url exists
                    ( !empty($rec['image']['url']) ) 
                    // use svg url
                    ? '<figure><img src="'.$rec['image']['url'].'" alt=""></figure>' 
                    // else use font icon
                    : '<i class="'.$rec['icon']->class.'"></i>'
                );
                
                // compile the output
                $return['iconlinks'] .= sprintf(
                    $guide['iconlinks']
                    ,$icon
                );
                
                // close anchor tag if exists
                $return['iconlinks'] .= ( !empty($rec['url']) ? '</a>' : '' );

                // close line item
                $return['iconlinks'] .= '</li>';
            }

            // close container
            $return['iconlinks'] .= '</ul>';

            // return compiled string
            return $return['iconlinks'];
        }
        else {
            // something went wrong...
            return false;
        }
    }
}   // end return_icon_links

 
function get_menu_items($menu_style, $item){

    switch($menu_style){
        case 'menu_photo_list': 
        $format = '
            <li class="menu_item site__fade site__fade-up">
                %s
                <div>
                    <h3>%s</h3>
                    <div class="menu__item-description">%s</div>
                    %s
                </div>
            </li>
        ';

        $return = sprintf(
            $format
            ,(!empty($item['image']) ? '<div class="image_provided block" style="background-image:url('.$item['image']['url'].');"></div>' : '')
            ,(!empty($item['title']) ? $item['title'] : '')
            ,(!empty($item['description']) ? $item['description'] : '')
            ,(!empty($item['price']) ? '<div class="menu__item-price">$'.$item['price'].'</div>' : '')
        );
        break;

        case 'menu_photo_tiled_x3':
        $price = (!empty($item['price']) ? $item['price'] : '');
        $priceArr = explode('.',$price);
        $format = '
            <li class="menu_item site__fade site__fade-up">
                %s
                <h3 class="menu__item-price">%s <div>$%s.<span>%s</span></div></h3>
                <div class="menu__item-description">%s</div>
            </li>
        ';

        $return = sprintf(
            $format
            ,(!empty($item['image']) ? '<div class="image_provided block" style="background-image:url('.$item['image']['url'].');"></div>' : '')
            ,(!empty($item['title']) ? $item['title'] : '')
            ,$priceArr[0]
            ,$priceArr[1]
            ,(!empty($item['description']) ? $item['description'] : '')
        );
        break;

        default: 
        $format = '
            <li class="menu_item site__fade site__fade-up">
                <h3 class="menu__item-price">%s <span class="menu_price">%s</span></h3>
                <div class="menu__item-description">%s</div>
            </li>
        ';
        
        $return = sprintf(
            $format
            ,(!empty($item['title']) ? $item['title'] : '')
            ,(!empty($item['price']) ? $item['price'] : '')
            ,(!empty($item['description']) ? $item['description'] : '')
        );
        break;
    }
    return $return;
}

function my_acf_init() {
    
    // this is required for acf maps to work in the back end!!!
    acf_update_setting('google_api_key', 'AIzaSyBOKWaxjiKG_kyx9exUfs32OFb8fwEqVBY');

    
    
    // this is your bullshit kyle....
    if( empty(get_option('acfext_google_api_key')) ){
        add_option('acfext_google_api_key', 'AIzaSyBOKWaxjiKG_kyx9exUfs32OFb8fwEqVBY');
    }



    // this is used in the theme to get the key w/o exposing it!
    function get_gmaps_api_key()
    {
        return 'AIzaSyCfDxwoigWRerVQMojFfT6nk0MMOYsz8XA';
    }

    
}

add_action('acf/init', 'my_acf_init');

function get_site_logo() {
    // look for a 'custom logo'
    $content_logo = '';
    // if we have a custom logo

    if (!empty(get_theme_mod('custom_logo'))) {
        $logo_src = wp_get_attachment_image_src(get_theme_mod('custom_logo'));
        $logo_srcset = wp_get_attachment_image_srcset(get_theme_mod('custom_logo'));
        $format_logo = '
            <a class="site__custom_logo" href="%s" title="Logo button">
                <img src="%s" srcset="%s" alt="%s">
            </a>
        ';
        $content_logo .= sprintf(
            $format_logo,
            site_url(),
            $logo_src,
            $logo_srcset,
            get_bloginfo('sitename')
        );
    }
    return $content_logo;
}
/**
 * Returns the SITE NAV
 *
 * @param string $pre
 * @return void
 */
function get_site_nav($pre = 'navlinks')
{

    if (get_field('header', 'options')['long_scroll']) {

        // get them fields
        $fields = get_fields(get_option('page_on_front'));

        $return['blocks_links'] = '';

        if (!empty($fields['content_blocks'])) {

            $guide['blocks_links'] = '<li class="navlinks-item"><a class="navlinks-item-link scroll" href="#%s">%s</a></li>';
            $return['blocks_links'] = '<ul class="navlinks nav__spyscroll">';

            foreach ($fields['content_blocks'] as $i => $cB) {
                if ($cB['anchor_enabled']) {
                    $return['blocks_links'] .= sprintf(
                        $guide['blocks_links'],
                        strtolower(str_replace(' ', '_', $cB['anchor_link_text'])),
                        $cB['anchor_link_text']
                    );
                }
            }
            $return['blocks_links'] .= '</ul>';
        }

        return $return['blocks_links'];
    } else {

        // create an unwrapped site nav
        $site__nav = wp_nav_menu(array(
            'menu' => 'nav__header', 'container' => '', 'items_wrap' => '<ul class="nav-menu navlinks">%3$s</ul>', 'walker' => new Rational_Walker_Nav_Menu, 'echo' => false
        ));
        return $site__nav;
    }
}

/**
 *       G. PLEASE CLEAN UP THIS JUNK BELOW. 
 */



function get_phone_number_1()
{
    $company_info = get_field('company_info', 'options');
    return (!empty($company_info['phone_number_1']) ? '<a href="tel:'.$company_info['phone_number_1'].'">'.$company_info['phone_number_1'].'</a>' : '');
}

function get_phone_number_2()
{
    $company_info = get_field('company_info', 'options');
    return (!empty($company_info['phone_number_2']) ? '<a href="tel:'.$company_info['phone_number_1'].'">'.$company_info['phone_number_2'].'</a>' : '');
}

function get_email()
{
    $company_info = get_field('company_info', 'options');
    return (!empty($company_info['email']) ? $company_info['email'] : '');
}

function get_social_icons()
{
    $company_info = get_field('company_info', 'options');

    $content_social_icons = '';
    // if we have social media icons
    if (!empty($company_info['social_media'])) {
        $content_social_icons .= '<ul class="site__social-media">';
        $format_social_icons = '
			<li>
				<a href="%s" title="Social icon button" target="_blank">
					%s
				</a>
			</li>
		';
        foreach ($company_info['social_media'] as $social_icon) {
            $url = $social_icon['url'];
            $img = $social_icon['image'];
            $fa = $social_icon['icon'];
            $custom_png_url = '';
            $icon_url = '';
            // we have a preconfigured URL
            if (strpos($url, 'booksy')) {
                $custom_png_url = get_template_directory_uri() . '/library/img/social_icons/booksy.png';
            }
            if (strpos($url, 'groupon')) {
                $custom_png_url = get_template_directory_uri() . '/library/img/social_icons/groupon.png';
            }
            if (strpos($url, 'pinterest')) {
                $custom_png_url = get_template_directory_uri() . '/library/img/social_icons/pinterest.png';
            }
            if (!empty($custom_png_url)) {
                $icon_url = $custom_png_url;
            } else {
                // we have img
                if (!empty($img)) {
                    $icon_url = $img;
                }
                // img is empty, we have fa
                else if (!empty($fa)) {
                    $icon_url = '';
                    $fa_icon = '<i class="fab ' . $fa . '"></i>';
                }
                // img and fa are empty
                // something went wrong...
                else {
                    $icon_url = '';
                }
            }
            if (!empty($url)) {
                $content_social_icons .= sprintf(
                    $format_social_icons,
                    $url,
                    (!empty($icon_url)) ? '<img src="' . $icon_url . '">' : $fa_icon
                );
            }
        }
        $content_social_icons .= '</ul>';
    }
    return $content_social_icons;
}

function get_full_address_br()
{
    $company_info = get_field('company_info', 'options');

    $location = ($company_info['location'] ? $company_info['location'] : '');

    $full_address_br = '';
    if (!empty($location['address_street'])) {
        $street_1 = $location['address_street'];
        $street_2 = $location['address_street_2'];
        $city = $location['address_city'];
        $state = $location['address_state'];
        $postcode = $location['address_postcode'];
        $country = $location['address_country'];

        $format_full_address_br = '%s %s <br/>%s, %s %s';

        $full_address_br = sprintf(
            $format_full_address_br,
            $street_1,
            $street_2,
            $city,
            $state,
            $postcode
            // ,$country
        );
    }

    return $full_address_br;
}

function get_full_address($icon = false)
{
    // get data
    $company_info = get_field('company_info', 'options');
    $street_1 = (!empty($company_info['location']['address_street']) ? '<span>' . $company_info['location']['address_street'] . '</span>' : '');
    $street_2 = (!empty($company_info['location']['address_street_2']) ? '<span>' . $company_info['location']['address_street_2'] . '</span>' : '');
    $city = ( !empty($company_info['location']['address_city'])  ? $company_info['location']['address_city'] . ',' : '');
    $state = ( !empty($company_info['location']['address_state'])  ? ' '.$company_info['location']['address_state'] : '');
    $zip = ( !empty($company_info['location']['address_postcode'])  ? ' '.$company_info['location']['address_postcode'] : '');


    if( $icon == true ){

    }
    
    // create return string
    $return['address'] = '';

    // create format string
    $guide['address'] = '
        <div class="site__address">
            %s
            <div>
                %s
                %s
                %s
            </div>
        </div>
    ';

    // wring return string
    $return['address'] .= sprintf(
        $guide['address']
        ,( ($icon == true ) ? '<i class="fas fa-map-marker-alt"></i>' : '' )
        ,$street_1
        ,$street_2
        ,'<span>'.$city.$state.$zip.'</span>'
    );
    return $return['address'];
}
?>