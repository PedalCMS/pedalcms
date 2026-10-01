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
 * @param {Window['wp']} wp WordPress global.
 */
(function (wp) {
	const el = wp.element.createElement;
	const registerBlockType = wp.blocks.registerBlockType;
	const useBlockProps = wp.blockEditor.useBlockProps;
	const Placeholder = wp.components.Placeholder;
	const __ = wp.i18n.__;
	const sprintf = wp.i18n.sprintf;

	function TemplateRenderEdit(props) {
		const blockProps = useBlockProps();
		const name = props.attributes.name;

		const instructions = name
			? sprintf(
					/* translators: %s: PedalCMS template slug, e.g. archive-program. */
					__(
						'The "%s" template is rendered here on the front end.',
						'pedalcms'
					),
					name
				)
			: __(
					'A PedalCMS template is rendered here on the front end.',
					'pedalcms'
				);

		return el(
			'div',
			blockProps,
			el(Placeholder, {
				icon: 'layout',
				label: __('PedalCMS Template', 'pedalcms'),
				instructions,
			})
		);
	}

	registerBlockType('pedalcms/template-render', {
		edit: TemplateRenderEdit,
		save() {
			return null;
		},
	});
})(window.wp);
