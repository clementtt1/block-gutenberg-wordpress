jQuery( document ).ready(function($) {
    valeur = php_vars.valeur;
});

wp.blocks.registerBlockType('gutenberg/custom-block', {
    title: 'Custom block Gutenberg',
    icon: 'welcome-write-blog',
    category: 'design',
    attributes: {
        wordToShow: { type: 'string' }
    },
    edit: function(props){
        return React.createElement("div", null,
            React.createElement("label", null, valeur),
        React.createElement("br", null),
    );
    },
    save: function(props){
        return null;
    }
})