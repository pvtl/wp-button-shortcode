(function() {
    tinymce.PluginManager.add('button-shortcode', function( editor, url ) {
        editor.addButton( 'button-shortcode', {
            text: 'Button',
            icon: 'mce-ico mce-i-pluscircle',
            onclick: function() {
                editor.windowManager.open( {
                    title: 'Add Button',
                    body: [
                        {
                            type: 'listbox',
                            label: 'Size',
                            name: 'size',
                            values: [
                                { text: 'Small', value: 'small' },
                                { text: 'Regular', value: 'regular' },
                                { text: 'Large', value: 'large' },
                            ],
                            value: ''
                        },
                        {
                            type: 'listbox',
                            label: 'Style',
                            name: 'style',
                            values: [
                                { text: 'Solid', value: 'solid' },
                                { text: 'Hollow', value: 'hollow' },
                            ],
                            value: ''
                        },
                        {
                            type: 'textbox',
                            label: 'Button Text',
                            name: 'text',
                            // tooltip: 'Some nice tooltip to use',
                            value: 'Learn More'
                        },
                        {
                            type: 'textbox',
                            label: 'Link (URL)',
                            name: 'href',
                            tooltip: 'If linking to another page, please use a relative URL - eg. /about not http://google.com/about',
                            value: '/about-us'
                        },
                        {
                            type: 'listbox',
                            label: 'Target',
                            name: 'target',
                            values: [
                                { text: 'Current Tab', value: '' },
                                { text: 'New Tab', value: '_blank' },
                            ],
                            value: ''
                        },
                    ],
                    onsubmit: function( e ) {
                        editor.insertContent( '[button size="' + e.data.size + '" style="' + e.data.style + '" text="' + e.data.text + '" href="' + e.data.href + '" target="' + e.data.target + '"]');
                    }
                });
            },
        });
    });

})();
