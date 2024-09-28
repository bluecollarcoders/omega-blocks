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
import { useBlockProps, useInnerBlocksProps, BlockControls, JustifyContentControl, } from '@wordpress/block-editor';
import { parseValue } from '../../utils/parseValue';

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
export default function Edit(props) {
	console.log({ props });

	const blockGap = parseValue(props.attributes.style?.spacing?.blockGap || "");
	const blockProps = useBlockProps({
		style: { gap: blockGap, justifyContent: props.attributes.justifyContent }
	});
	const innerBlocksProps = useInnerBlocksProps( blockProps, {
		template: [["omega/clickybutton", {}]],
		allowedBlocks: [ "omega/clickybutton" ]
	} );

	return (
		<>
		<BlockControls>
			<JustifyContentControl
				value={props.attributes.justifyContent}
				allowedControls={["left", "center", "right"]}
				onChange={(newValue) => {
					props.setAttributes({
						justifyContent: newValue,
					})
				}}
			 />
		</BlockControls>
		<div {...innerBlocksProps} />
		</>
		
	);
}
 