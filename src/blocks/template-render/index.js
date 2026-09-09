/**
 * Editor registration for the pedalcms/template-render block.
 *
 * The block is server-rendered: its callback loads the matching legacy PHP
 * template, which runs the main loop. That cannot render meaningfully inside
 * the Site Editor, so the editor shows a placeholder naming the template
 * instead of a live preview.
 *
 * Registering here is what stops the Site Editor treating the block as an
 * unsupported block, since a PHP-only registration is invisible to the
 * editor's client-side block registry.
 */
(function (wp) {
  var el = wp.element.createElement;
  var registerBlockType = wp.blocks.registerBlockType;
  var useBlockProps = wp.blockEditor.useBlockProps;
  var Placeholder = wp.components.Placeholder;
  var __ = wp.i18n.__;
  var sprintf = wp.i18n.sprintf;

  registerBlockType('pedalcms/template-render', {
    edit: function (props) {
      var blockProps = useBlockProps();
      var name = props.attributes.name;

      var instructions = name
        ? sprintf(
            /* translators: %s: PedalCMS template slug, e.g. archive-program. */
            __('The "%s" template is rendered here on the front end.', 'pedalcms'),
            name
          )
        : __('A PedalCMS template is rendered here on the front end.', 'pedalcms');

      return el(
        'div',
        blockProps,
        el(Placeholder, {
          icon: 'layout',
          label: __('PedalCMS Template', 'pedalcms'),
          instructions: instructions,
        })
      );
    },
    save: function () {
      return null;
    },
  });
})(window.wp);
