<?php

namespace InvisibleUs\Programs;

/**
 * Base class for common custom content tasks in WordPress.
 *
 * @version 0.1.0
 * @package NVISPrograms
 * @subpackage StandardLib
 * @since 0.1.0
 */
abstract class CustomContentObject {
    /**
     * Associative array of instances of child classes by class name.
     *
     * @var array
     */
    private static array $instances = [];

    /**
     * singular name, display style.
     * @var string
     */
    public string $name = '';

    /**
     * plural name, display style.
     * @var string
     */
    public string $plural_name = '';

    /**
     * The label to use in document title.
     *
     * @var string
     */
    public string $document_title_label = '';

    /**
     * The label to use in breadcrumb trails.
     *
     * @var string
     */
    public string $breadcrumb_label = '';

    /**
     * The args array passed to the appropriate register function.
     *
     * @var array
     */
    public array $args = [];

    /**
     * Slug style machine name, either the 'post_type' or the 'taxonomy'.
     *
     * @var string
     */
    public string $system_name = '';

    /**
     * The file path of the template to render as contextual help on the post_type screen (admin single edit).
     *
     * @var string
     */
    public string $help = '';

    /**
     * The file path of the template to render as contextual help on the edit-post_type screen (admin list view).
     *
     * @var string
     */
    public string $edit_help = '';

    /**
     * The base path to help templates. Relative to the plugin root.
     *
     * @var string
     */
    public string $help_path = 'help/';

    /**
     * A list of field group arrays to pass to acf_add_local_field_group.
     *
     * @since 0.1.0
     *
     * @var array
     */
    public $field_groups = [];

    /**
     * Whether this class has been instantiated.
     *
     * @var boolean
     */
    protected bool $init = false;


    /**
     * Constructor.
     */
    protected function __construct() {
        $this->setup_field_group();
        $this->setup_labels();
        $this->setup_help();
        $this->name = $this->args['labels']['singular_name'] ?? '';
        $this->plural_name = $this->args['labels']['name'] ?? '';
        $this->document_title_label = $this->args['labels']['archives'] ?? '';
    }

    /**
     * Singleton pattern instance function.
     *
     * Do _NOT_ call this function before the `init` hook. Many text labels are
     * created on instantiation and that cannot happen before the text domain
     * is loaded.
     *
     * @return CustomContentObject
     */
    public static function get_instance(): CustomContentObject {
        $class = static::class;
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();
        }

        return self::$instances[$class];
    }

    /**
     * Helper function to prevent necessitating overriding the constructor.
     *
     * @return void
     */
    protected function init() {

    }

    /**
     * Called by the final class to create the appropriate labels for this content type.
     *
     * @return void
     */
    abstract protected function setup_labels();

    /**
     * Registers the custom content object.
     *
     * @return void
     */
    abstract public function register(): void;

    /**
     * Set up the help callback.
     *
     * @return void
     */
    protected function setup_help(): void {
        if ($this->help || $this->edit_help) {
            $this->help_path = trailingslashit(Plugin::$path) . $this->help_path;

            add_action('admin_head', [&$this, 'render_contextual_help'], 10, 3);
        }

        return;
    }

    /**
     * Utility function to get an absolute help file path.
     *
     * @param string $file The relative file path.
     * @return string The absolute path.
     */
    public function get_help_file_path($file): string {
        return trailingslashit($this->help_path) . $file;
    }

    /**
     * Callback to handle loading the help template files.
     *
     * Called on action 'admin_head'.
     *
     * @return void
     */
    public function render_contextual_help(): void {
        $tabs = null;
        $screen = get_current_screen();
        // first, figure out what screen we are on and get our tabs
        switch ($screen->id) {
            case $this->system_name:
                if ($this->help) {
                    $tabs = $this->help;
                }

                break;
            case 'edit-'.$this->system_name:
                if ($screen->base == 'term') {
                    // Both taxonomy lists and edit screens have the same id
                    if ($this->help) {
                        $tabs = $this->help;
                    }
                } elseif ($this->edit_help) {
                    $tabs = $this->edit_help;
                }

                break;
            default:
                break;
        }

        // if we have any tabs, let's deal with them
        if ($tabs) {
            // first, look to see if it is a single string
            if (!is_array($tabs)) {
                // convert it to a "tab" using WordPress compatibility strategy
                $tabs = [
                    [
                        'id'      => $this->system_name.'_overview',
                        'title'   => 'Overview',
                        'content' => $tabs
                    ]
                ];
            }
            $sidebar_content = '';
            // process each tab
            foreach ($tabs as $tab) {
                // only create tabs that we have content for
                if (!empty($tab['content'])) {
                    $content_file = $this->get_help_file_path($tab['content']);
                    // if the 'content' is a file path, grab the contents
                    if (is_file($content_file)) {
                        ob_start();
                        include($content_file);
                        $content = ob_get_contents();
                        ob_end_clean();
                        $tab['content'] = $content;
                    }
                    // finally, add the tab using the screen API
                    if ('sidebar' == $tab['id']) {
                        $sidebar_content = $tab['content'];
                    } else {
                        $screen->add_help_tab($tab);
                    }
                }
            }
            // The sidebar must be added _after_ all tabs.
            if ($sidebar_content) {
                $screen->set_help_sidebar($sidebar_content);
            }
        }

        $this->help = null;
        $this->edit_help = null;

        return;
    }

    protected function setup_field_group() {

    }

    public static function get_field_group(): array {
        $instance = static::get_instance();

        return $instance->field_groups[0] ?? [];
    }

    abstract public static function get_content_type(): string;

    public static function get_document_title_label(): string {
        $instance = static::get_instance();

        $document_title_label = $instance->document_title_label ?
            $instance->document_title_label :
            $instance->plural_name;

        return apply_filters(
            'nvis/content_type_document_title_label',
            $document_title_label,
            $instance->system_name,
            static::get_content_type(),
            $instance
        );
    }


    public static function get_breadcrumb_label(): string {
        $instance = static::get_instance();

        if ($instance->breadcrumb_label) {
            $breadcrumb_label = $instance->breadcrumb_label;
        } else if ($instance->document_title_label) {
            $breadcrumb_label = $instance->document_title_label;
        } else {
            $breadcrumb_label = $instance->plural_name;
        }

        return apply_filters(
            'nvis/content_type_breadcrumb_label',
            $breadcrumb_label,
            $instance->system_name,
            static::get_content_type(),
            $instance
        );
    }
}
