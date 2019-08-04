<?php
/**
 *      Modular Content Block: Google Map
 * 
*/
    // css
    wp_enqueue_style('mapblock', get_template_directory_uri().'/blocks/map_block/map_block.css');
    // api script
    // wp_enqueue_script('gmaps', 'https://maps.googleapis.com/maps/api/js?key='.get_option('acfext_google_api_key'), array(), '1.0.0', true);
    // rendering js
    wp_enqueue_script('mapblock', get_template_directory_uri().'/blocks/map_block/map_block.js', array(),'1.0.0', true);



    $return['maps_block'] = '';


    $guide['maps_block'] = '
        <section class="site__block block__map">
            <div class="container %s">
                %s
                %s
                <div class="acf-map">
                    <div class="marker" data-lat="%s" data-lng="%s"></div>
                </div>
            </div>
        </section>
    ';

    $return['maps_block'] .= sprintf(
        $guide['maps_block']
        ,$cB['width']
        ,( (!empty( $cB['heading'] )) ? '<h3>'.$cB['heading'].'</h3>' : '' )
        ,( (!empty( $cB['sub_heading'] )) ? '<p>'.$cB['sub_heading'].'</p>' : '' )
        ,$cB['map']['lat']
        ,$cB['map']['lng']
    );

    echo $return['maps_block'];
 ?>