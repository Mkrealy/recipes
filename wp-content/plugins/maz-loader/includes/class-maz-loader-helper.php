<?php
/**
 * MAZ Loader Helper
 *
 * @link       https://www.feataholic.com
 * @since      1.4.1 Free
 *
 * @package    MZLDR
 * @subpackage MZLDR/includes
 */

/**
 * MAZ Loader Helper.
 *
 * This class defines all helper methods used within MAZ Loader.
 *
 * @since      1.4.1 Free
 * @package    MZLDR
 * @subpackage MZLDR/includes
 * @author     Stergos Zamagias <stergosz1@gmail.com>
 */
class MZLDR_Helper {

	/**
	 * Redirects user to a page
	 * 
	 * @return  void
	 */
	public static function customAdminRedirect( $redirect_admin_page ) {
		$data = [];

		wp_redirect(
			esc_url_raw(
				add_query_arg(
					[],
					admin_url( 'admin.php?page=' . $redirect_admin_page )
				)
			)
		);
		exit;
	}

	/**
	 * Transforms an array(key, value) into html attributes
	 *
	 * @param   array  $atts
	 *
	 * @return  string
	 */
	public static function getHTMLAttributes( $atts ) {
		if ( ! is_array( $atts ) ) {
			return '';
		}

		$html = ' ' . implode(
			' ',
			array_map(
				function ( $k, $v ) {
					$v = is_array($v) ? htmlspecialchars( json_encode( $v ) ) : $v;

					return $k . '="' . esc_attr($v) . '"'; },
				array_keys( $atts ),
				$atts
			)
		) . ' ';

		return $html;
	}

	/**
	 * Transforms an array(key, value) into style css attributes
	 *
	 * @param   array  $atts
	 *
	 * @return  string
	 */
	public static function getCSSAttributes( $atts ) {
		if ( ! is_array( $atts ) ) {
			return '';
		}

		$html = ' style="' . implode(
			'',
			array_map(
				function ( $k, $v ) {
					if ( ! empty( $v ) ) {
						return $k . ':' . $v . ';';
					}
				},
				array_keys( $atts ),
				$atts
			)
		) . '" ';

		return $html;
	}

	/**
	 * Returns the version
	 * 
	 * @return  string
	 */
	public static function getVersion() {
		$xml = [];
		
		if (function_exists('simplexml_load_file')) {
			$xml = simplexml_load_file(dirname(__DIR__) . '/plugin.xml');
		}

		$version = isset($xml->version) ? $xml->version : '1.0.0';
		
		return (string) $version;
	}
	
	/**
	 * The Status of the plugin
	 * 
	 * @return  string
	 */
	public static function getStatus() {
		return (self::isFree()) ? __('Free', 'maz-loader') : __('Pro', 'maz-loader');
	}

	/**
	 * Returns whether we have Free version or not
	 * 
	 * @return  boolean
	 */
	public static function isFree() {
		$status = 0;
		if (defined('MZLDR_STATUS')) {
			$status = MZLDR_STATUS;
		}
		return $status == 0 ? true : false;
	}

	/**
	 * Returns whether we have Pro version or not
	 * 
	 * @return  boolean
	 */
	public static function isPro() {
		return !self::isFree();
	}

	/**
	 * Sanitizes the fields data
	 * 
	 * @return  array
	 */
	public static function sanitize_fields_data( $data ) {
		if (empty($data)) {
			return [];
		}

		$data = (array) $data;
		
		$return_data = [];
		
		foreach( $data as $key => $value ) {
			foreach ( $data[$key] as $_key => $_value ) {
				switch ( $_key ) {
					case 'id':
					case 'size':
					case 'padding_top':
					case 'padding_right':
					case 'padding_bottom':
					case 'padding_left':
					case 'margin_top':
					case 'margin_right':
					case 'margin_bottom':
					case 'margin_left':
					case 'border_radius':
						$return_data[$key][$_key] = absint( $_value );
						break;
					case 'type':
					case 'padding_link':
					case 'padding_type':
					case 'margin_link':
					case 'margin_type':
					case 'icon':
					case 'icon_tab':
						$return_data[$key][$_key] = sanitize_key( $_value );
						break;
					case 'width':
					case 'height':
						$return_data[$key][$_key] = sanitize_text_field( $_value );
						break;
					case 'image':
					case 'custom_url':
						$return_data[$key][$_key] = esc_url_raw( $_value );
						break;
					case 'custom_css':
					case 'custom_js':
					case 'json':
						$return_data[$key][$_key] = sanitize_textarea_field($_value);
						break;
					// case 'json':
					case 'custom_html':
						$return_data[$key][$_key] = wp_kses($_value, self::getAllowedHTMLTags());
						break;
					default:
						$return_data[$key][$_key] = sanitize_text_field( $_value );
						break;
				}
			}
		}
		
		return $return_data;
	}

	/**
	 * Sanitizes the loader settings data
	 * 
	 * @return  array
	 */
	public static function sanitize_loader_settings( $data ) {
		$data = (array) $data;
		
		$return_data = [];
		
		foreach( $data as $key => $value ) {
			switch ( $key ) {
				case 'minimum_loading_time':
				case 'duration':
				case 'delay':
					$return_data[$key] = absint( $value );
					break;
				case 'background_image_type':
				case 'background_image_position':
				case 'content_position':
				case 'items_side_by_side':
				case 'disable_page_scroll':
					$return_data[$key] = sanitize_key( $value );
					break;
				case 'background':
					$return_data[$key] = esc_url_raw( $value );
					break;
				default:
					$return_data[$key] = sanitize_text_field( $value );
					break;
			}
		}
		
		return $return_data;
	}

	/**
	 * Sanitizes an array of integers
	 * 
	 * @param   array  $data
	 * 
	 * @return  array $data
	 */
	public static function sanitize_int_array( $data ) {
		foreach ( (array) $data as $k => $v ) {
			if ( is_array( $v ) ) {
				$data[$k] = self::sanitize_int_array( $v );
			} else {
				$data[$k] = absint( $v );
			}
		}

		return $data;
	}

	public static function getAllowedHTMLTags()
	{
		$allowed_html_tags = [
			'span' => [
				'class' => true
			],
			'div' => [
				'class' => true
			],
			'svg' => [
				'class' => true,
				'aria-hidden' => true,
				'aria-labelledby' => true,
				'role' => true,
				'xmlns' => true,
				'x' => true,
				'y' => true,
				'width' => true,
				'height' => true,
				'viewbox' => true
			],
			'path' => [
				'class' => true,
				'fill' => true,
				'd' => true,
			],
			'g' => [
				'fill' => true,
				'clip-path' => true,
			],
			'clippath' => [
				'id' => true,
				'path' => [
					'class' => true,
					'fill' => true,
					'd' => true,
				],
			],
			'rect' => [
				'x' => true,
				'y' => true,
				'rx' => true,
				'ry' => true,
				'width' => true,
				'height' => true,
				'fill' => true,
				'animate' => [
					'attributeName' => true,
					'values' => true,
					'keytimes' => true,
					'dur' => true,
					'begin' => true,
					'repeatcount' => true,
				]
			],
		];

		return array_merge(wp_kses_allowed_html('post'), $allowed_html_tags);
	}
}
