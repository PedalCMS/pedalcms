<?php

namespace InvisibleUs\Programs;

class Program extends CustomPostType {
    /**
     * The post type to register.
     */
    public const post_type = 'nvis_program';

    /**
     * The proper name.
     *
     * @var string
     */
    public $name = 'Program';

    /**
     * The plural version of the proper name.
     *
     * @var string
     */
    public $plural_name = 'Programs';

    /**
     * The args to pass to register_post_type.
     *
     * Gets updated throughout the setup process.
     *
     * @var array
     */
    public $args = [
        'has_archive'         => 'programs',
        'rewrite'             => ['slug' => 'program', 'with_front' => true],
        // We're overriding this in the constructor.
        'capability_type'     => 'post',
        'menu_icon'           => 'dashicons-welcome-learn-more',
        'menu_position'       => 5,
        'description'         => '',
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'exclude_from_search' => true,
        'map_meta_cap'        => true,
        'hierarchical'        => false,
        'supports'            => ['title', 'thumbnail'],
    ];

    /**
     * A list of field group arrays to pass to acf_add_local_field_group.
     *
     * @var array
     */
    public $field_groups = [

    ];

    public function __construct() {
        parent::__construct();
        $this->args['capability_type'] = self::post_type;
    }
}
