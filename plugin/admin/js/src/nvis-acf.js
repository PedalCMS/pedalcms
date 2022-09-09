(function ($) {
	const acf = window.acf;
	const nvisACFData = window.nvisACFData;

	if (typeof acf === 'undefined') {
		console.warn('acf.js not loaded.'); // eslint-disable-line no-console
		return;
	}

	if (typeof nvisACFData === 'undefined') {
		console.warn('nvis-acf.js not localized properly.'); // eslint-disable-line no-console
		return;
	}

	const nvisACF = (window.nvisACF = {
		collegesFieldKey: 'field_611279af182d2',
		departmentsFieldKey: 'field_630fb69367bc5',
		departmentLoaded: null,
		collegesDepartments: {
			// cache
		},
		prepareCollege(field) {
			field.$el.on('select2:select', function (e) {
				nvisACF.collegeSet(e.params.data.id);
			});
		},
		loadDepartment(field) {
			const college = acf.getField(nvisACF.collegesFieldKey);

			if (field.val() && !nvisACF.departmentLoaded) {
				nvisACF.departmentLoaded = Number(field.val());
			}

			if (!college.val()) {
				field.disable();
			} else {
				field.enable();
				nvisACF.collegeSet(college.val());
			}
		},
		collegeSet(collegeID) {
			if (typeof nvisACF.collegesDepartments[collegeID] !== 'undefined') {
				nvisACF.setDepartments(nvisACF.collegesDepartments[collegeID]);
			} else {
				// TODO: debounce/don't make multiple calls.
				$.post(
					nvisACFData.ajax_url,
					{
						_ajax_nonce: nvisACFData.nonce,
						action: 'get_college_departments',
						college: collegeID,
					},
					function (data) {
						nvisACF.collegesDepartments[collegeID] = data;
						nvisACF.setDepartments(data);
					}
				);
			}
		},
		setDepartments(newOptions) {
			// eslint-disable-next-line no-undef
			const field = acf.getField(nvisACF.departmentsFieldKey);
			const $select = $('select', field.$el);

			$select.val(null).empty();

			if (typeof newOptions !== 'undefined') {
				if (newOptions.length) {
					$select.append(new Option(field.data.placeholder, 0, false, false));

					newOptions.forEach(function (opt) {
						const selected = opt.term_id === nvisACF.departmentLoaded;

						$select.append(
							new Option(opt.name, opt.term_id, selected, selected)
						);
					});

					field.enable();
				} else {
					$select.append(new Option(nvisACFData.label_not_found, 0));

					field.disable();
				}
			}
		},
	});

	acf.addAction(
		'prepare_field/key=' + nvisACF.collegesFieldKey,
		nvisACF.prepareCollege
	);

	acf.addAction(
		'load_field/key=' + nvisACF.departmentsFieldKey,
		nvisACF.loadDepartment
	);
})(window.jQuery);
