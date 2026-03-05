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
import { useBlockProps, InspectorControls, PanelColorSettings } from '@wordpress/block-editor';
import { SelectControl, PanelBody } from '@wordpress/components';
import { useSelect } from '@wordpress/data';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import metadata from './block.json'; // Import metadata for text domain

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit( props ) {

	const { attributes, setAttributes } = props;
	const { postType, selectPostId, buttonBackgroundColor, buttonTextColor } = attributes;

	// Use useBlockProps for automatic block props and class names.
	const blockProps = useBlockProps();

	// Fetch all available post types.
	const postTypes = useSelect( ( select ) => {
		return select('core').getPostTypes( { per_page: -1 } );
	}, []);

	// Fetch posts from the selected post type.
	const posts = useSelect( ( select ) => {
		if ( !postType ) return null;
		return select('core').getEntityRecords('postType', postType, { per_page: -1});
	}, [postType]);

	// Fetch the selected post's data, including featured image.
	const selectedPost = useSelect( ( select ) => {
		if ( !selectPostId ) return null;
		return select('core').getEntityRecord( 'postType', postType, selectPostId )
	}, [selectPostId] );

    // Fetch the featured image based on the selected post's featured_media ID.
    const featuredImage = useSelect( ( select ) => {
        if ( !selectedPost?.featured_media ) return null;
        return select('core').getMedia( selectedPost.featured_media );
    }, [selectedPost?.featured_media]);

	const onPostTypeChange = (newPostType) => {
		setAttributes( { postType: newPostType, selectPostId: 0 } );
	};

	const onPostChange = (newPostId) => {
		setAttributes( { selectPostId: parseInt( newPostId, 10 ) } );
	}

	// Helper functions to get title and content based on post type
	const getTitle = () => {
		if ( postType === 'service' ) {
			return attributes.serviceTitle || selectedPost?.title?.rendered || 'No Title';
		} else if ( postType === 'testimonial' ) {
			return attributes.testimonialAuthor || selectedPost?.title?.rendered || 'No Author';
		}
		return selectedPost?.title?.rendered || 'No Title';
	};

	const getContent = () => {
		if ( postType === 'service' ) {
			return attributes.serviceDescription || selectedPost?.excerpt?.rendered || 'No description available';
		} else if ( postType === 'testimonial' ) {
			return attributes.testimonialContent || selectedPost?.excerpt?.rendered || 'No content available';
		}
		return selectedPost?.excerpt?.rendered || 'No description available';
	};

	return (
		<>

			<InspectorControls>
				<PanelBody title={ __( 'Settings', metadata.textdomain ) }>
					
					{/* Select the post type. */}
					<SelectControl
						label={ __( "Select Post Type", metadata.textdomain ) }
						value={postType}
						options={postTypes?.map( (type) => ({
							label: type.name,
							value: type.slug
						}))}
						onChange={onPostTypeChange}
					/>

					{/* Select the specific post from the selected post type */}
					{ posts && (
						<SelectControl
							label={ __( "Select Post", metadata.textdomain ) }
							value={selectPostId}
							options={posts.map( ( post ) => ({
								label: post.title.rendered,
								value: post.id,
							}))}
							onChange={onPostChange} 
						/>
					)}

				</PanelBody>

                <PanelBody title={ __( "Button Settings", metadata.textdomain ) }>
                    <PanelColorSettings
                        title={ __( "Button Color Settings", metadata.textdomain ) }
                        initialOpen={false}
                        colorSettings={[
                            {
                                value: buttonBackgroundColor,
                                onChange: (color) => setAttributes({ buttonBackgroundColor: color }),
                                label: __( 'Button Background Color', metadata.textdomain ),
                            },
                            {
                                value: buttonTextColor,
                                onChange: (color) => setAttributes({ buttonTextColor: color }),
                                label: __( 'Button Text Color', metadata.textdomain ),
                            },
                        ]}
                    />
                </PanelBody>
			</InspectorControls>

			<div {...blockProps}>
				{selectedPost && (
					<div className='custom-card'>
						{featuredImage && (
							<img 
								src={featuredImage.source_url}
								alt={featuredImage.alt_text || 'Post Image'}
							/>
						)}

						{/* Post details based on the selected post type */}
						<h2>{ getTitle() }</h2>
						<p>{ getContent() }</p>

						<a
							href={selectedPost?.link}
							className='read-more-btn'
							target='_blank'
							rel='noopener noreferrer'
							style={{ backgroundColor: buttonBackgroundColor, color: buttonTextColor}}
						>
							{ __( 'Read More', metadata.textdomain ) }
						</a>

					</div>
				)}
			</div>
			
		</>
	);
}
