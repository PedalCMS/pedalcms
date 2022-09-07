(function($){
	if (typeof acf === 'undefined') {
		return;
	}
	
	window.nvis_acf = {
		collegesFieldKey: 'field_611279af182d2',
		departmentsFieldKey: 'field_630fb69367bc5',
		departmentLoaded: null,
		collegesDepartments: {
			// cache
		},
		prepareCollege: function(field) {
			field.$el.on('select2:select', function(e) {
				nvis_acf.collegeSet(e.params.data.id)
			});
		},
		loadDepartment: function(field) {
			const college = acf.getField(nvis_acf.collegesFieldKey);

			if (field.val() && !nvis_acf.departmentLoaded) {
				nvis_acf.departmentLoaded = Number(field.val());
			}
			
			if (!college.val()) {
				field.disable();
			} else {
				field.enable();
				nvis_acf.collegeSet(college.val());
			}
		},
		collegeSet: function(collegeID) {
			if (typeof nvis_acf.collegesDepartments[collegeID] !== 'undefined') {
				nvis_acf.setDepartments(
					nvis_acf.collegesDepartments[collegeID]
				);
			} else {
				// TODO: debounce/don't make multiple calls.
				$.post(
					nvis_acf_data.ajax_url, 
					{         
						_ajax_nonce: nvis_acf_data.nonce,     
						action: 'get_college_departments',            
						college: collegeID
					}, 
					function(data) {                 
						nvis_acf.collegesDepartments[collegeID] = data;
						nvis_acf.setDepartments(data);
					}
				);
			}
			
		},
		setDepartments: function(newOptions) {
			const field = acf.getField(nvis_acf.departmentsFieldKey);
			const $select = $('select', field.$el);

			$select
				.val(null)
				.empty()
				.trigger('change');

			if (typeof newOptions !== 'undefined')	{ 
				if (newOptions.length) {					
					$select.append(new Option(
						field.data.placeholder, 0, false, false
					));

					newOptions.forEach(function(opt) {
						const selected = opt.term_id === nvis_acf.departmentLoaded;

						$select
							.append(new Option(opt.name, opt.term_id, selected, selected))
							.trigger('change');
					});

					field.enable();

					// $select.select2({ajax: null, data:[]});
				} else {
					$select
						.append(new Option(nvis_acf_data.label_not_found, 0))
						.trigger('change');

					field.disable();
				}
			} 

			$select.trigger('change');			
		}
	}

	acf.addAction('prepare_field/key=field_611279af182d2', nvis_acf.prepareCollege);
	acf.addAction('load_field/key=field_630fb69367bc5', nvis_acf.loadDepartment);

})(jQuery);