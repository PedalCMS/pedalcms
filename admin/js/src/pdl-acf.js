(function ($) {
	'use strict';

	const pedalcmsACFData = window.pedalcmsACFData;

	if (typeof pedalcmsACFData === 'undefined') {
		console.warn('pedalcms-department not localized properly.'); // eslint-disable-line no-console
		return;
	}

	const $collegeSelect = $('[data-field-name="pedalcms_college"] select');
	const $departmentSelect = $('[data-field-name="pedalcms_department"] select');

	// Fields are only present on the program post-edit screen.
	if (!$collegeSelect.length || !$departmentSelect.length) {
		return;
	}

	// Cache AJAX responses by college ID.
	const cache = {};

	// Capture the pre-selected department ID (if editing an existing post)
	// so it can be re-selected after the AJAX-populated options are inserted.
	let preselectedDepartmentId = Number($departmentSelect.val()) || null;

	// Capture the placeholder text from the server-rendered select before
	// we start manipulating it.
	const placeholder =
		$departmentSelect.find('option[value=""]').first().text() ||
		pedalcmsACFData.label_not_found;

	function setDepartments(options) {
		$departmentSelect.val(null).empty();

		if (options && options.length) {
			$departmentSelect.append(
				new window.Option(placeholder, '', false, false)
			);

			options.forEach(function (opt) {
				const selected = opt.term_id === preselectedDepartmentId;
				$departmentSelect.append(
					new window.Option(opt.name, opt.term_id, selected, selected)
				);
			});

			$departmentSelect.prop('disabled', false);
		} else {
			$departmentSelect.append(
				new window.Option(pedalcmsACFData.label_not_found, '')
			);
			$departmentSelect.prop('disabled', true);
		}
	}

	function loadForCollege(collegeId) {
		if (cache[collegeId] !== undefined) {
			setDepartments(cache[collegeId]);
			return;
		}

		$.post(
			pedalcmsACFData.ajax_url,
			{
				_ajax_nonce: pedalcmsACFData.nonce,
				action: 'pedalcms_get_college_departments',
				college: collegeId,
			},
			function (data) {
				cache[collegeId] = Array.isArray(data) ? data : [];
				setDepartments(cache[collegeId]);
			}
		);
	}

	// Initialise on page load.
	const initialCollege = $collegeSelect.val();
	if (!initialCollege) {
		$departmentSelect.prop('disabled', true);
	} else {
		loadForCollege(initialCollege);
	}

	// React to college changes.
	$collegeSelect.on('change', function () {
		const collegeId = $(this).val();
		// Don't try to restore editing pre-selection after a manual change.
		preselectedDepartmentId = null;

		if (!collegeId) {
			$departmentSelect.val(null).empty();
			$departmentSelect.append(new window.Option(placeholder, ''));
			$departmentSelect.prop('disabled', true);
		} else {
			loadForCollege(collegeId);
		}
	});
})(window.jQuery);
