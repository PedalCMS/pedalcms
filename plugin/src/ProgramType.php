<?php

namespace InvisibleUs\Programs;

class ProgramType extends CustomTaxonomy {
    public const TAXONOMY = 'nvis_program_type';
    public $name = 'Program Type';
    public $plural_name = 'Program Types';

    public $object_types = [Program::POST_TYPE];

    public $args = [
        'query_var'             => 'prog_type',
        'rewrite'               => ['slug' => 'type'],
        'description'           => '',
        'sort'                  => true,
        'rewrite'               => false,
        'hierarchical'          => true,
        'public'                => true,
        'show_ui'               => true,
        'show_in_quick_edit'    => false,
        'meta_box_cb'           => false,
        'show_admin_column'     => true,
        'show_in_nav_menus'     => false,
        'show_tagcloud'         => false,
    ];

    public static $field_groups = [
        [
            'key'         => 'group_6123fad662541',
            'title'       => 'Application Deadlines',
            'description' => '',
            'location'    => [
                [
                    [
                        'param'    => 'taxonomy',
                        'operator' => '==',
                        'value'    => self::TAXONOMY,
                    ],
                ]
            ],
            'menu_order'            => 0,
            'position'              => 'normal',
            'style'                 => 'default',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'active'                => true,
            'fields'                => [
                [
                    'key'          => 'field_61156b547d402',
                    'label'        => 'Application Deadlines',
                    'name'         => 'nvis_application_deadlines',
                    'type'         => 'repeater',
                    'instructions' => '',
                    'collapsed'    => 'field_61156b777d403',
                    'layout'       => 'block',
                    'button_label' => 'Add Deadline',
                    'sub_fields'   => [
                        [
                            'key'          => 'field_61156b777d403',
                            'label'        => 'Deadline Label',
                            'name'         => 'deadline_label',
                            'type'         => 'text',
                            'instructions' => '',
                            'required'     => 1,
                            'placeholder'  => 'Fall, Spring, etc.',
                            'maxlength'    => '',
                        ],
                        [
                            'key'          => 'field_61156bbe7d404',
                            'label'        => 'Deadline Info',
                            'name'         => 'deadline_info',
                            'type'         => 'text',
                            'instructions' => '',
                            'placeholder'  => 'e.g. June 24th',
                            'maxlength'    => '',
                        ],
                    ],
                ],
            ],
        ]
    ];
}
