<?php

namespace PedalCMS\Core;

define('NVISP_FREEMIUS_START', dirname(__FILE__) . '/freemius/start.php');

if (!function_exists('nvis_prog_freemius') && file_exists(NVISP_FREEMIUS_START)) :

/**
 * Helper function for easy Freemius SDK access.
 *
 * @return void
 */
function nvis_prog_freemius() {
    global $nvis_prog_freemius;

    if (!isset($nvis_prog_freemius)) {
        require_once NVISP_FREEMIUS_START;

        $fs_args = [
            'id'                  => '11142',
            'slug'                => 'pedalcms',
            'type'                => 'plugin',
            'public_key'          => 'pk_44e5d6d9560fb16310d89b80eefe0',
            'is_premium'          => true,
            'is_premium_only'     => true,
            'has_addons'          => false,
            'has_paid_plans'      => true,
            'is_org_compliant'    => false,
            'trial'               => [
                'days'               => 180,
                'is_require_payment' => true,
            ],
            'menu'                => [
                'slug'           => 'edit.php?post_type=nvis_program',
                'support'        => false,
                'contact'        => false,
            ],
        ];

        if (defined('NVISP_FREEMIUS_SECRET_KEY')) {
            $fs_args['secret_key'] = NVISP_FREEMIUS_SECRET_KEY;
        }

        $nvis_prog_freemius = fs_dynamic_init($fs_args);
    }

    return $nvis_prog_freemius;
}

// Init Freemius.
nvis_prog_freemius();

// Signal that SDK was initiated.
do_action('nvis_prog_freemius_loaded');

endif;