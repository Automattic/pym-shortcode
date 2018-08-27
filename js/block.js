( function( wp ) {
	/**
	 * Registers a new block provided a unique name and an object defining its behavior.
	 * @see https://github.com/WordPress/gutenberg/tree/master/blocks#api
	 */
	var registerBlockType = wp.blocks.registerBlockType;

	/**
	 * Returns a new element of given type. Element is an abstraction layer atop React.
	 * @see https://github.com/WordPress/gutenberg/tree/master/element#element
	 */
	var el = wp.element.createElement;

	/**
	 * Rendering
	 */
	var ServerSideRender = wp.components.ServerSideRender;

	/**
	 * Text tools
	 */
	var TextControl = wp.components.TextControl;

	/**
	 * The sidebar controls I think?
	 * @todo check definition
	 */
	var InspectorControls = wp.editor.InspectorControls;

	/**
	 * Retrieves the translation of text.
	 * @see https://github.com/WordPress/gutenberg/tree/master/i18n#api
	 */
	var __ = wp.i18n.__;

	/**
	 * Every block starts by registering a new block type definition.
	 * @see https://wordpress.org/gutenberg/handbook/block-api/
	 */
	registerBlockType( 'pym-shortcode/pym', {
		/**
		 * This is the display title for your block, which can be translated with `i18n` functions.
		 * The block inserter will show this name.
		 */
		title: __( 'Pym Embed' ),

		/**
		 * An icon property should be specified to make it easier to identify a block.
		 * These can be any of WordPress’ Dashicons, or a custom svg element.
		 */
		icon: 'analytics',

		/**
		 * Blocks are grouped into categories to help users browse and discover them.
		 * The categories provided by core are `common`, `embed`, `formatting`, `layout` and `widgets`.
		 */
		category: 'embed',

		/**
		 * Gutenberg features supported by this block
		 * @link https://wordpress.org/gutenberg/handbook/block-api/#supports-optional
		 */
		supports: {
			// Removes support for an HTML mode.
			html: false,
			align: true,
			alignWide: true,
			anchor: true,
			customClassName: true,
			className: true,
			inserter: true,
			multiple: true,
		},

		/**
		 * Describe the block for the block inspector
		 */
		description: 'Embed a webpage using NPR\'s Pym.js',

		/**
		 * Make the block easier to find by including keywords
		 */
		keywords: [ __( 'NPR' ) ],

		/**
		 * The edit function describes the structure of your block in the context of the editor.
		 * This represents what the editor will render when the block is used.
		 * @see https://wordpress.org/gutenberg/handbook/block-edit-save/#edit
		 *
		 * @param {Object} [props] Properties passed from the editor.
		 * @return {Element}       Element to render.
		 */
		edit: function( props ) {
			return [
				// https://gist.github.com/pento/cf38fd73ce0f13fcf0f0ae7d6c4b685d#file-php-block-js-L59
				/*
				 * The ServerSideRender element uses the REST API to automatically call
				 * php_block_render() in your PHP code whenever it needs to get an updated
				 * view of the block.
				 */
				el( ServerSideRender, {
					block: 'pym-shortcode/pym',
					attributes: props.attributes,
				} ),
				/*
				 * InspectorControls lets you add controls to the Block sidebar. In this case,
				 * we're adding a TextControl, which lets us edit the 'foo' attribute (which
				 * we defined in the PHP). The onChange property is a little bit of magic to tell
				 * the block editor to update the value of our 'foo' property, and to re-render
				 * the block.
				 */
				el( InspectorControls, {},
					el( TextControl, {
						label: 'Child URL',
						value: props.attributes.src,
						onChange: ( value ) => { props.setAttributes( { src: value } ); },
					} )
				),
				el( InspectorControls, {},
					el( TextControl, {
						label: 'Pym.js URL (optional)',
						value: props.attributes.pymsrc,
						onChange: ( value ) => { props.setAttributes( { pymsrc: value } ); },
					} )
				),
				el( InspectorControls, {},
					el( TextControl, {
						label: 'Pym Options',
						value: props.attributes.pymoptions,
						onChange: ( value ) => { props.setAttributes( { pymoptions: value } ); },
					} )
				),
				el( InspectorControls, {},
					el( TextControl, {
						label: 'Element ID for this frame (optional)',
						value: props.attributes.parent_id,
						onChange: ( value ) => { props.setAttributes( { parent_id: value } ); },
					} )
				),
				el( InspectorControls, {},
					el( TextControl, {
						label: 'CSS Classes to add to frame (optional)',
						value: props.attributes.className,
						onChange: ( value ) => { props.setAttributes( { class: value } ); },
					} )
				)
			];
		},

		/**
		 * The save function defines the way in which the different attributes should be combined
		 * into the final markup, which is then serialized by Gutenberg into `post_content`.
		 * @see https://wordpress.org/gutenberg/handbook/block-edit-save/#save
		 *
		 * @return {Element}       Element to render.
		 */
		save: function() {
			// null because this is rendered serverside in PHP.
			return null;
		},

		/**
		 * @todo provide transformation from shortcode
		 * @todo provide transformation to plain embed
		 *
		 * @link https://wordpress.org/gutenberg/handbook/block-api/#transforms-optional
		 */
		transforms: {
			from: [
				{
					type: 'shortcode',
					tag: 'pym',
					attributes: {
						src: {
							type: 'string',
							shortcode: function( named ) {
								return named.src ? named.src : '';
							},
						},
						pymsrc: {
							type: 'string',
							shortcode: function( named ) {
								return named.pymsrc ? named.pymsrc : '';
							},
						},
						pymoptions: {
							type: 'string',
							shortcode: function( named ) {
								return named.pymoptions ? named.pymoptions : '';
							},
						},
						parent_id: {
							type: 'string',
							shortcode: function( named ) {
								return named.id ? named.id : '';
							},
						},
						className: {
							type: 'string',
							shortcode: function( named ) {
								return named.class ? named.class : '';
							},
						},
						align: {
							type: 'string',
							shortcode: function( named ) {
								var align = named.align ? named.align : 'alignnone';
								return align.replace( 'align', '' );
							},
						},
					},
				},
			]
			// @todo provide "to" transformations for embed, plain HTML, etc
		},
	} );
} )(
	window.wp
);
