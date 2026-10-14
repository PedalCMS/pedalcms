(function (wp) {
	const el = wp.element.createElement;
	const registerBlockType = wp.blocks.registerBlockType;
	const TextControl = wp.components.TextControl;
	const useSelect = wp.data.useSelect;
	const useEntityProp = wp.coreData.useEntityProp;
	const useBlockProps = wp.blockEditor.useBlockProps;

	function ContactInfoEdit() {
		const blockProps = useBlockProps();
		const postType = useSelect(function (select) {
			return select('core/editor').getCurrentPostType();
		}, []);
		const entityProp = useEntityProp('postType', postType, 'meta');
		const meta = entityProp[0];
		const setMeta = entityProp[1];

		const officePhone = meta.pedalcms_office_phone;
		const emailAddress = meta.pedalcms_email_address;
		const office = meta.pedalcms_office;

		function updatePhone(newValue) {
			setMeta(
				Object.assign({}, meta, {
					pedalcms_office_phone: newValue,
				})
			);
		}

		function updateEmail(newValue) {
			setMeta(
				Object.assign({}, meta, {
					pedalcms_email_address: newValue,
				})
			);
		}

		function updateOffice(newValue) {
			setMeta(
				Object.assign({}, meta, {
					pedalcms_office: newValue,
				})
			);
		}

		return el(
			'div',
			blockProps,
			el(TextControl, {
				label: 'Office Phone',
				placeholder: '(919) 555-1212',
				value: officePhone,
				onChange: updatePhone,
			}),
			el(TextControl, {
				label: 'Email Address',
				placeholder: 'jdoe@college.edu',
				value: emailAddress,
				onChange: updateEmail,
			}),
			el(TextControl, {
				label: 'Office',
				placeholder: 'Main Building, 448C',
				value: office,
				onChange: updateOffice,
			})
		);
	}

	registerBlockType('pedalcms/contact-info', {
		title: 'Contact Info',
		edit: ContactInfoEdit,
		save() {
			return null;
		},
	});
})(window.wp);
