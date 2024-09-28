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
import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl } from "@wordpress/components";
import { useSelect } from '@wordpress/data';

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

	const postTypes = useSelect( (select ) => {
		const data = select("core").getEntityRecords("root", "postType",{
			per_page: -1,
		});
		return data?.filter(
			(item) => item.visibility.show_in_nav_menus && item.visibility.show_ui
		); 
	});

	const posts = useSelect(
		(select) => {
			const data = select("core").getEntityRecords(
				"postType",
				props.attributes.postType,
				{
					per_page: -1,
				}
			);
			return data;
		},
		[props.attributes.postType]
	);
	console.log( { posts } );

	const blockProps = useBlockProps();

	return (

		<>

		<InspectorControls>
			<PanelBody>
			<SelectControl
			label="Type"
			value={props.attributes.postTypes}
			onChange={(newValue) => {
				props.setAttributes({
					postType: newValue,
				});
			}}
			options={[
				{
					label: "Select a post type...",
					value: "",
				},
				...(postTypes || []).map((postType) => ({
					label: postType.labels.singular_name,
					value: postType.slug,
				})),
			]}
			 />
			</PanelBody>
		</InspectorControls>
		<div {...blockProps}>
			<RichText
			placeholder='Label Text'
			value={props.attributes.labelText}
			allowedFormats={[]}
			multiline={false}
			onSplit={ () => {}}
			onReplace={ () => {}}
			onChange={ (newValue) => {
				props.setAttributes({
					labelText: newValue,
				})
			}} 
			/>
			{!!props.attributes.postType && (
				<SelectControl
				label={`Linked ${props.attributes.postType}`}
				value={props.attributes.linkedPost}
				onChange={(newValue) => {
					props.setAttributes({
						linkedPost: newValue ? parseInt(newValue) : null,
					});
				}}
				options={[
					{
						label: `Select a ${props.attributes.postType} to link to`,
						value: "",
					},
					...(posts || []).map((post) => ({
						label: post.title.rendered,
						value: post.id,
					})),
				]}

				 />
			)}
		</div>

		
		</>
	);
}
