<?php

namespace InvisibleUs\Programs;

/**
 * Manages config of each subpage.
 * 
 * @package NVISPrograms
 * @subpackage Subpages
 * @since 0.1.0
 */
class Subpage {
    /**
     * The URL slug.
     * 
     * @since 0.1.0
     *
     * @var string
     */
    public string $slug = '';

    /**
     * The proper title of the subpage. Defaults to an {@see Subpage::uslugified()} version of the slug.
     *
     * @since 0.1.0
     * 
     * @var string
     */
    public string $title = '';

    /**
     * The subpage's part of the HTML document title. Defaults to the $title property. 
     * 
     * @since 0.1.0
     *
     * @var string
     */
    public string $document_title = '';

    /**
     * The label to use in the program subnavigation and edit screen options. 
     * 
     * @since 0.1.0
     *
     * @var string
     */
    public string $tab_label = '';

    /**
     * The label to use in the breadcrumb trail. 
     * 
     * Relies on third-party plugin support. See {@see breadcrumbs.php}.
     * 
     * @since 0.1.0
     *
     * @var string
     */
    public string $breadcrumb_label = '';

    /**
     * The label to use for the aria-label attribute in program subnavigation.
     * 
     * Allows subpage to be contextualized in the case where menu items may be
     * duplicates of other navigation items. For example, news may also appear 
     * in main navigation and we use this property to make it explicit that
     * news in the subnav is specific to the current program.
     * 
     * @since 0.1.0
     *
     * @var string
     */
    public string $aria_label = '';

    /**
     * The order of this subpage in the program subnavigation. 
     * 
     * Buitin subpages are spaced 10 apart to allow user registered subpages
     * to be easily ordered in-between them.
     * 
     * @since 0.1.0
     *
     * @var integer
     */
    public int $order = 0;

    /**
     * Whether or not this subpage is native to this plugin or user registered.
     * 
     * @since 0.1.0
     *
     * @var boolean
     */
    private bool $builtin = false;

    /**
     * A list of ACF fields to register for this subpage. 
     * 
     * Will be placed on a tab in the edit screen that mirrors the program 
     * subnavigation.
     * 
     * @since 0.1.0
     *
     * @var array
     */
    public array $fields = [];

    /**
     * Creates the Subpage based on the given arguments. 
     * 
     * @since 0.1.0
     *
     * @param string $slug
     * @param array $args
     */
    public function __construct(string $slug, array $args = []) {
        $this->slug = sanitize_title($slug, '', 'save');
        $this->title = $args['title'] ?? $this->unslugify($slug);
        $this->document_title = $args['document_title'] ?? $this->title;
        $this->tab_label = $args['tab_label'] ?? $this->title;
        $this->breadcrumb_label = $args['breadcrumb_label'] ?? $this->title;
        $this->aria_label = $args['aria_label'] ?? $this->title;
        $this->order = $args['order'] ?? 1000;
        $this->builtin = $args['builtin'] ?? false;
        $this->fields = $args['fields'] ?? [];
    }

    /**
     * Whether the Subpage is native to this plugin. 
     * 
     * @since 0.1.0
     *
     * @return boolean
     */
    public function is_builtin(): bool {
        return $this->builtin;
    }

    /**
     * Attempts to make a proper title from a slug. 
     * 
     * Used in initialization of the object when not provided a title arg.
     * 
     * @since 0.1.0
     *
     * @param [type] $string
     * @return void
     */
    private function unslugify($string) {
        return ucwords(
            str_replace(
                ['-','_'], 
                ' ',
                $string
            )
        );
    }
}
