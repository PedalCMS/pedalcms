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

		const officePhone = meta.office_phone;
		const emailAddress = meta.email_address;
		const office = meta.office;

		function updatePhone(newValue) {
			setMeta(
				Object.assign({}, meta, {
					office_phone: newValue,
				})
			);
		}

		function updateEmail(newValue) {
			setMeta(
				Object.assign({}, meta, {
					email_address: newValue,
				})
			);
		}

		function updateOffice(newValue) {
			setMeta(
				Object.assign({}, meta, {
					office: newValue,
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

	registerBlockType('pdl/contact-info', {
		title: 'Contact Info',
		edit: ContactInfoEdit,
		save() {
			return null;
		},
	});
})(window.wp);
