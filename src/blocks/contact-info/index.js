(function (wp) {
  var el = wp.element.createElement;
  var registerBlockType = wp.blocks.registerBlockType;
  var TextControl = wp.components.TextControl;
  var useSelect = wp.data.useSelect;
  var useEntityProp = wp.coreData.useEntityProp;
  var useBlockProps = wp.blockEditor.useBlockProps;

  registerBlockType('pdl/contact-info', {
    title: 'Contact Info',
    edit: function (props) {
      var blockProps = useBlockProps();
      var postType = useSelect(function (select) {
        return select('core/editor').getCurrentPostType();
      }, []);
      var entityProp = useEntityProp('postType', postType, 'meta');
      var meta = entityProp[0];
      var setMeta = entityProp[1];

      var officePhone = meta['office_phone'];
      var emailAddress = meta['email_address'];
      var office = meta['office'];

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
    },
    save: function () {
      return null;
    },
  });
})(window.wp);
