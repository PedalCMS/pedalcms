(function (wp) {
  var el = wp.element.createElement;
  var registerBlockType = wp.blocks.registerBlockType;
  var TextControl = wp.components.TextControl;
  var useSelect = wp.data.useSelect;
  var useEntityProp = wp.coreData.useEntityProp;
  var useBlockProps = wp.blockEditor.useBlockProps;

  registerBlockType('nvis/job-title', {
    title: 'Job Title',
    edit: function (props) {
      var blockProps = useBlockProps();
      var postType = useSelect(function (select) {
        return select('core/editor').getCurrentPostType();
      }, []);
      var entityProp = useEntityProp('postType', postType, 'meta');
      var meta = entityProp[0];
      var setMeta = entityProp[1];

      var jobTitle = meta['job_title'];

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
    },
    save: function () {
      return null;
    },
  });
})(window.wp);
