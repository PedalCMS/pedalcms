<?php

namespace InvisibleUs\Programs;

class Plugin {
    public static $name = '';
    public static $path = '';
    public static $url = '';
    public static $template_path = '/templates';
    public $field_groups = [

    ];

    public function __construct() {
        self::$name = basename(dirname(__DIR__, 2));
        self::$path = dirname(__DIR__, 2);
        self::$url = plugins_url(self::$name);
        self::$template_path = self::$path . self::$template_path;
    }
}
