<?php
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
            'element' => 'body',
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
            'element' => '.navlinks',
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


 ?>