<?php
/**
 * SEO Configuration for CSIRT Kabupaten Cianjur
 * @see https://github.com/artesaos/seotools
 */

return [
    'inertia' => env('SEO_TOOLS_INERTIA', false),
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => "CSIRT Kabupaten Cianjur", // default title
            'titleBefore'  => false, // Put defaults.title before page title
            'description'  => 'Tim Respons Insiden Keamanan Siber Kabupaten Cianjur - Melindungi infrastruktur digital dan masyarakat dari ancaman siber', // default description
            'separator'    => ' - ',
            'keywords'     => ['CSIRT', 'Keamanan Siber', 'Cianjur', 'Cyber Security', 'Computer Security Incident Response Team'],
            'canonical'    => 'current', // Use current URL
            'robots'       => 'all', // index,follow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'CSIRT Kabupaten Cianjur',
            'description' => 'Tim Respons Insiden Keamanan Siber Kabupaten Cianjur',
            'url'         => null, // Use current URL
            'type'        => 'website',
            'site_name'   => 'CSIRT Kabupaten Cianjur',
            'images'      => [
                // Add default CSIRT Cianjur logo/image URL here
                // env('APP_URL').'/images/csirt-cianjur-og-image.jpg'
            ],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            'card'        => 'summary_large_image',
            'site'        => '@csirt_cianjur', // Add official Twitter handle if available
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title'       => 'CSIRT Kabupaten Cianjur',
            'description' => 'Tim Respons Insiden Keamanan Siber Kabupaten Cianjur',
            'url'         => null, // Use current URL
            'type'        => 'Organization',
            'images'      => [
                // Add default CSIRT Cianjur logo/image URL here
                // env('APP_URL').'/images/csirt-cianjur-logo.jpg'
            ],
        ],
    ],
];

