<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

Class OIH_Merge_Tags_Subscribers extends OIH_Merge_Tags {

	/**
	 * Constructor
	 *
	 * @param array $tags_data
	 *
	 */
	public function __construct( $tags_data = array() ) {

		$this->supported_tags = array(
			'subscriber_email',
			'subscriber_first_name',
			'subscriber_last_name'
		);

		parent::__construct( $tags_data );

	}

}