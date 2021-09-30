<?php

namespace InvisibleUs\Programs;

abstract class CustomContentObject {
    /**
     * singular name, display style.
     * @var string
     */
    public string $name = '';
    /**
     * plural name, display style
     * @var string
     */
    public string $plural_name = '';

    /**
     * The labels array to pass to the appropriate register function.
     *
     * @var array
     */
    public array $labels = [];

    public array $args = [];

    public string $text_domain = '';

    // This will either be the 'post_type' or the 'taxonomy'
    public string $system_name = '';

    // The file path of the template to render as contextual help on the post_type screen (admin single edit)
    public string $help = '';

    // The file path of the template to render as contextual help on the edit-post_type screen (admin list view)
    public string $edit_help = '';

    public string $help_path = 'help/';

    public function __construct() {
        $this->text_domain = Plugin::$name;
    }

    abstract protected function create_labels();

    public function register(): void {
        $this->create_labels();
        $this->setup_help();

        return;
    }

    /**
     *  Set up the help callback.
     *
     */
    protected function setup_help(): void {
        if ($this->help || $this->edit_help) {
            $this->help_path = trailingslashit(Plugin::$path) . $this->help_path;

            add_action('admin_head', [&$this, 'render_contextual_help'], 10, 3);
        }

        return;
    }

    /**
     *  Utility function to get a help file path
     *
     */
    public function get_help_file_path($file): string {
        return trailingslashit($this->help_path) . $file;
    }

    /**
     *  Callback to handle loading the help template files. Called on action 'admin_head'.
     *
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
}
