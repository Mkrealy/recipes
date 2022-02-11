<?php

/**
 * Loader Block
 *
 * @link       https://www.feataholic.com
 * @since      1.4.1 Free
 *
 * @package    MZLDR
 * @subpackage MZLDR/includes/forms
 */

/**
 * Loader Block.
 *
 * Provides helper methods to run all form fields.
 *
 * @since      1.4.1 Free
 * @package    MZLDR
 * @subpackage MZLDR/includes/forms
 * @author     Stergos Zamagias <stergosz1@gmail.com>
 */
class MZLDR_Loader_Block {

	public static function canRender() {
		if ( ! function_exists( 'register_block_type' ) ) {
			// Gutenberg is not active.
			return false;
		}

		return true;
	}

	public function register_block() {
		register_block_type(
			'maz-loader/loader',
			array(
				'editor_script' => 'maz-loader-loader-block'
			)
		);
	}

	public function register_block_script() {
		wp_enqueue_script(
			'maz-loader-loader-block',
			MZLDR_ADMIN_MEDIA_URL . '/js/src/mazloader/mazloader-admin/blocks/mazloader-loader-block.js',
			array('wp-i18n', 'wp-blocks', 'wp-editor', 'wp-components'),
			true
		);
	}

	public function register_block_category($categories, $context) {
		$allowed_types = [
			'post',
			'page'
		];

		global $post;
		
		if (isset($post->post_type) && !in_array($post->post_type, $allowed_types))
		{
			return $categories;
		}

		return array_merge(
			$categories,
			array(
				array(
					'slug' => 'maz-loader',
					'title' => __( 'MAZ Loader', 'maz-loader' ),
					'icon'  => 'update',
				),
			)
		);
	}

}