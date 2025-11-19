/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { RichText, useBlockProps } from '@wordpress/block-editor';

import { useSelect } from '@wordpress/data';
import { useEntityProp } from '@wordpress/core-data';

import { __experimentalInputControl as InputControl } from '@wordpress/components';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit() {
	const blockProps = useBlockProps();

	const currentPostType = useSelect( ( select ) => {
		return select( 'core/editor' ).getCurrentPostType();
	}, []);

	const [ meta, setMeta ] = useEntityProp( 'postType', currentPostType, 'meta' );

	const { projects_address, projects_phoneNumber, projects_website } = meta;

	const updateMeta = ( key, value ) => {
		setMeta( { ...meta, [key]: value } );
	};

	return (
		<div { ...blockProps }>
			<h2>{ __( 'Project Details', 'projects-cpt' ) }</h2>
			<hr />
			<div className="projects__meta-wrapper">
				<InputControl
					label={ __( 'Address', 'projects-cpt' ) }
					value={ projects_address }
					onChange={ ( nextValue ) =>  updateMeta("projects_address", nextValue) }
        />
        <InputControl
					label={ __( 'Phone Number', 'projects-cpt' ) }
					value={ projects_phoneNumber }
					onChange={ ( nextValue ) =>  updateMeta("projects_phoneNumber", nextValue) }
					placeholder="555.555.5555"
        />
        <div className="richtext-component">
	        <span className="richtext-component__label">{ __( 'Website', 'projects-cpt' ) }</span>
	        <RichText
	          tagName="a"
	          value={ projects_website }
	          allowedFormats={ ['core/link'] }
	          disableLineBreaks
	          onChange={ ( nextValue ) => updateMeta("projects_website", nextValue) }
	        />
        </div>
			</div>
		</div>
	);
}