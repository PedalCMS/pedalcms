(function (wp) {
	const el = wp.element.createElement;
	const registerBlockType = wp.blocks.registerBlockType;
	const TextControl = wp.components.TextControl;
	const useSelect = wp.data.useSelect;
	const useEntityProp = wp.coreData.useEntityProp;
	const useBlockProps = wp.blockEditor.useBlockProps;

	function JobTitleEdit() {
		const blockProps = useBlockProps();
		const postType = useSelect(function (select) {
			return select('core/editor').getCurrentPostType();
		}, []);
		const entityProp = useEntityProp('postType', postType, 'meta');
		const meta = entityProp[0];
		const setMeta = entityProp[1];

		const jobTitle = meta.job_title;

		function updateJobTitle(newValue) {
			setMeta(
				Object.assign({}, meta, {
					job_title: newValue,
				})
			);
		}

		return el(
			'div',
			blockProps,
			el(TextControl, {
				label: 'Job Title',
				placeholder: 'Associate Professor',
				value: jobTitle,
				onChange: updateJobTitle,
			})
		);
	}

	registerBlockType('pdl/job-title', {
		title: 'Job Title',
		edit: JobTitleEdit,
		save() {
			return null;
		},
	});
})(window.wp);
