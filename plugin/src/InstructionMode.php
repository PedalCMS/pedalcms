<?php

namespace InvisibleUs\Programs;

/**
 * Instruction Mode custom taxonomy.
 *
 * @package NVISPrograms
 * @subpackage ContentModel
 * @since 0.1.0
 */
class InstructionMode extends CustomTaxonomy {
    public const TAXONOMY = 'nvis_instruct_mode';
    public string $name = 'Instruction Mode';
    public string $plural_name = 'Instruction Modes';

    public $object_types = [Program::POST_TYPE];

    public array $args = [
        'query_var'             => 'inst_mode',
        'rewrite'               => false,
        'description'           => '',
        'sort'                  => true,
        'rewrite'               => false,
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_quick_edit'    => false,
        'meta_box_cb'           => false,
        'show_admin_column'     => true,
        'show_in_nav_menus'     => false,
        'show_tagcloud'         => false,
    ];

    public $field_groups = [];
}
