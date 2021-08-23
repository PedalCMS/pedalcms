<?php
namespace InvisibleUs\Programs;

add_action('plugins_loaded', __NAMESPACE__ . '\maybe_load_acf');

function maybe_load_acf()
{
    // If ACF is already loaded, we can bail.
    if (class_exists('ACF')) {
        return;
    }

    $subpath = '/src/acf/';
    define('NVISP_ACF_PATH', NVIS_PROGRAMS_PATH . $subpath);
    define('NVISP_ACF_URL', NVIS_PROGRAMS_URL . $subpath);

    include_once(NVISP_ACF_PATH . 'acf.php');

    add_filter('acf/settings/url', __NAMESPACE__ . '\acf_settings_url');
    add_filter('acf/settings/show_admin', '__return_false');
}

function acf_settings_url(string $url)
{
    return NVISP_ACF_URL;
}
