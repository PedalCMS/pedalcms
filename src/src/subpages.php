<?php

namespace InvisibleUs\Programs;

add_action('plugins_loaded', __NAMESPACE__ . '\setup_subpage_manager');

function setup_subpage_manager() {
    $mngr = new ProgramSubpageManager();
    $mngr->init();
}
