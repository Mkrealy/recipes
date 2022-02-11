<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Base class for the different merge tags used throughout the plugin
 *
 */
abstract Class OIH_Merge_Tags {

	/**
	 * Array with the supported merge tags that will be
	 * replaced with data
	 *
	 * @var array
	 * @access protected
	 *
	 */
	protected $supported_tags = array();


	/**
	 * Array with the data for the merge tags
	 *
	 * @var array
	 * @access protected
	 *
	 */
	protected $tags_data = array();


	/**
	 * Constructor
	 *
	 * @param array $tags_data
	 *
	 */
	public function __construct( $tags_data = array() ) {

		$this->tags_data = $tags_data;

	}


	/**
	 * Replaces the merge tags with the corresponding data in the given content
	 *
	 * @param string $content
	 *
	 * @return string
	 *
	 */
	public function replace_tags( $content = '' ) {

		if( empty( $content ) )
			return $content;

		if( empty( $this->tags_data ) )
			return $content;

		foreach( $this->supported_tags as $key => $tag ) {

			if( isset( $this->tags_data[$tag] ) )
				$replace_with = $this->tags_data[$tag];
			else
				$replace_with = '';
			
			$content = str_replace( '{{' . $tag . '}}' , $replace_with, $content );

		}

		return $content;

	}

}