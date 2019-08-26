<?php


// for 1-6 loop conrols for h1-h6
for ($i=1; $i < 7; $i++) { 

    Kirki::add_field('kirki_config', [
        'type'        => 'typography',
        'settings'    => 'site_type-headings-h' . $i,
        'label'       => esc_html__('H' . $i, 'kirki'),
        'section'     => 'site_type-headings',
        'default'     => [
            'font-family'    => 'Montserrat',
            'variant'        => '',
            'font-size'      => '',
            'letter-spacing' => '',
        ],
        'priority'    => 10,
        'transport'   => 'auto',
        'output'      => [
            [
                'element' => 'h'.$i,
            ],
        ],
    ]);
}
// 


// the body font literally
Kirki::add_field('kirki_config', [
    'type'        => 'typography',
    'settings'    => 'site_type-body',
    'label'       => esc_html__('Body','kirki'),
    'section'     => 'site_type-body',
    'default'     => [
        'font-family'    => 'Lato',
        'variant'        => '',
        'font-size'      => '',
        'letter-spacing' => '',
    ],
    'priority'    => 10,
    'transport'   => 'auto',
    'output'      => [
        [
            'element' => 'body', // this goes on the body element
        ],
    ],
]);

Kirki::add_field('kirki_config', [
    'type'        => 'typography',
    'settings'    => 'site_type-nav',
    'label'       => esc_html__('Nav', 'kirki'),
    'section'     => 'site_type-nav',
    'default'     => [
        'font-family'    => 'Lato',
        'variant'        => '',
        'font-size'      => '',
        'letter-spacing' => '',
    ],
    'priority'    => 10,
    'transport'   => 'auto',
    'output'      => [
        [
            'element' => '.navlinks', // 
        ],
    ],
]);

Kirki::add_field('kirki_config', [
    'type'        => 'typography',
    'settings'    => 'site_type-buttons',
    'label'       => esc_html__('Buttons', 'kirki'),
    'section'     => 'site_type-buttons',
    'default'     => [
        'font-family'    => 'Lato',
        'variant'        => '',
        'font-size'      => '',
        'letter-spacing' => '',
    ],
    'priority'    => 10,
    'transport'   => 'auto',
    'output'      => [
        [
            'element' => '.site__button',
        ],
    ],
]);

Kirki::add_field('kirki_config', [
    'type'        => 'typography',
    'settings'    => 'site_type-alt-text',
    'label'       => esc_html__('Alt-Text', 'kirki'),
    'section'     => 'site_type-alt-text',
    'default'     => [
        'font-family'    => 'Lato',
        'variant'        => '',
        'font-size'      => '',
        'letter-spacing' => '',
    ],
    'priority'    => 10,
    'transport'   => 'auto',
    'output'      => [
        [
            'element' => '.alt-text',
        ],
    ],
]);


/**
 *      Hero Space Controls:
*/

// create 3x3 button group for alignment of hero foreground
Kirki::add_field('kirki_config', [
    'type'        => 'radio-buttonset',
    'settings'    => 'site_section_styles-hero-alignment',
    'label'       => esc_html__('Hero Foreground Alignment', 'kirki'),
    'section'     => 'site_section_styles-hero',
    'default'     => 'middlecenter',
    'priority'    => 10,
    'choices'     => [
        'topleft'   => esc_html__('', 'kirki'),
        'topcenter'   => esc_html__('', 'kirki'),
        'topright'   => esc_html__('', 'kirki'),
        'middleleft'   => esc_html__('', 'kirki'),
        'middlecenter'   => esc_html__('', 'kirki'),
        'middleright'   => esc_html__('', 'kirki'),
        'bottomleft'   => esc_html__('', 'kirki'),
        'bottomcenter'   => esc_html__('', 'kirki'),
        'bottomright'   => esc_html__('', 'kirki'),
    ],
]);

 ?>