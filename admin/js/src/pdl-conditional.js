(function ($) {
	'use strict';

	/**
	 * Return the element to show/hide for a given field wrapper.
	 *
	 * @param {Object} $el Field wrapper element.
	 *                     On WordPress settings/metabox tables fields live inside <td> inside <tr>.
	 *                     We toggle the <tr> so the <th> label row is also shown/hidden.
	 *                     Falls back to the wrapper itself outside of table contexts.
	 */
	function rowOrSelf($el) {
		const $tr = $el.closest('tr');
		return $tr.length ? $tr : $el;
	}

	/**
	 * Conditional Checkbox Toggle
	 *
	 * Reads `data-conditional-toggle` from checkbox wrapper elements.
	 * The attribute is a comma-separated list of field names to show when
	 * the checkbox is checked and hide when unchecked.
	 */
	function initConditionalToggles() {
		$('[data-conditional-toggle]').each(function () {
			const $wrapper = $(this);
			const $checkbox = $wrapper.find('input[type="checkbox"]').first();
			const targets = $wrapper.data('conditional-toggle');

			if (!$checkbox.length || !targets) {
				return;
			}

			const fieldNames = String(targets)
				.split(',')
				.map(function (s) {
					return s.trim();
				})
				.filter(Boolean);

			if (!fieldNames.length) {
				return;
			}

			// Scope searches to the nearest table so we don't leak across metaboxes.
			const $scope = $wrapper.closest('table');

			function toggle() {
				const checked = $checkbox.is(':checked');
				fieldNames.forEach(function (name) {
					const $target = $scope
						.find('[data-field-name="' + name + '"]')
						.first();
					if ($target.length) {
						rowOrSelf($target).toggle(checked);
					}
				});
			}

			toggle();
			$checkbox.on('change', toggle);
		});
	}

	/**
	 * Value-based Show/Hide
	 *
	 * Reads `data-pdl-show-if` from field wrappers.
	 * The attribute is a JSON object { field, value } — the wrapper is shown
	 * only when the named field equals the given value.
	 */
	function initShowIfFields() {
		$('[data-pdl-show-if]').each(function () {
			const $wrapper = $(this);
			const config = $wrapper.data('pdl-show-if');

			if (!config || !config.field) {
				return;
			}

			const $scope = $wrapper.closest('table');
			const $controller = $scope
				.find('[data-field-name="' + config.field + '"]')
				.first();
			if (!$controller.length) {
				return;
			}

			const $input = $controller.find('select, input').first();
			if (!$input.length) {
				return;
			}

			function check() {
				rowOrSelf($wrapper).toggle(
					String($input.val()) === String(config.value)
				);
			}

			check();
			$input.on('change', check);
		});
	}

	$(document).ready(function () {
		initConditionalToggles();
		initShowIfFields();
	});
	$(document).on('cassette-cmf-fields-added', function () {
		initConditionalToggles();
		initShowIfFields();
	});
})(window.jQuery);
