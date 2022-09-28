function tinymce_init_callback(editor) {
    // Full editor for admins
    let breadSettings = JSON.parse(editor.getElement().getAttribute('data-editor-settings'));
    if(!breadSettings) {
        breadSettings = {};
    }
    let newSettings = Object.assign({}, editor.settings, breadSettings, {
        language: 'de',
        min_height: 250,
        link_list: '/admin/link-list',
        init_instance_callback: (newEditor) => {
            newEditor.theme.resizeTo(null, 250);
        },
        table_default_attributes: {
            class: 'table'
        },
        table_class_list: [
            {title: 'Normal', value: 'table'},
            {title: 'Light', value: 'table table-light'},
            {title: 'Dark', value: 'table table-dark'},
        ]
    });
    // Re-initialize the editor
    tinymce.remove(editor);
    tinymce.init(newSettings);
}