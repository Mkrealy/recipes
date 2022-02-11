<?php
// get post terms
function fn_post_terms($ajax_parameters = '')
{	
	
	$selectedPostSlugs = [];
	$selectedPostNames = [];
	$selectedTerms = [];
	$isAjaxCall = false;
	
	if (empty($ajax_parameters)) {
		
		$isAjaxCall = true;
		
	
	
		$ajax_parameters = array (
			'post_type' 		=> '',
		);


		if (!empty($_POST['current_post_type'])) {
			$ajax_parameters['post_type'] 		= $_POST['current_post_type'];
		}

		$post_type  = $ajax_parameters['post_type'];

		// post cats
		
		if( $post_type == 'page' )
		{
			// do nothing
		}
		else if( $post_type != '' )
		{
			$taxonomys = get_object_taxonomies( $post_type );
			$exclude = array( 'post_tag', 'post_format' );

			if($taxonomys != '')
			{
				foreach($taxonomys as $taxonomy)
				{
					// exclude post tags
					if( in_array( $taxonomy, $exclude ) ) { continue; }

					$terms = get_terms($taxonomy, array('hide_empty' => true));
					foreach ( $terms as $term ) 
					{
						array_push($selectedPostSlugs, $term->slug);
						array_push($selectedPostNames, $term->name);
					}
				}
			}
			
			array_push($selectedTerms, $terms);
		}
		else
		{

		}
		
	}
	
	$buffyArray = array(
        'data_slugs' 	=> $selectedPostSlugs,
        'data_names' 	=> $selectedPostNames,
        'data_terms' 	=> $selectedTerms,
    );
	
	
	
	
	if ( true === $isAjaxCall ) 
	{
        die(json_encode($buffyArray));
    } 
	else 
	{
        return json_encode($buffyArray);
    }
	
	// custom post cats
	//return $selectedPostTerms;
}