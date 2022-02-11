<?php
if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class UpdateNotice {
	public function init()
	{
		$this->registerAjax();

		if (!$this->canRun())
		{
			return false;
		}

		$this->loadMedia();
	}

	private function canRun()
	{
		global $pagenow;
		if (!$pagenow || $pagenow != 'admin.php')
		{
			return false;
		}

		$page = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : '';

		$allowed_pages = [
			'maz-loader-dashboard',
			'maz-loader-list',
			'maz-loader-settings',
			'maz-loader'
		];
		
		if (!in_array($page, $allowed_pages))
		{
			return false;
		}
		
		return true;
	}

	private function registerAjax()
	{
		add_action('wp_ajax_mzldr_show_update_notice', [$this, 'mzldr_show_update_notice']);
	}

	public function mzldr_show_update_notice()
	{
		$nonce = isset($_GET['nonce']) ? sanitize_text_field($_GET['nonce']) : '';

		if( ! wp_verify_nonce( $nonce, 'mzldr-admin-nonce' ) ) {
			return;
		}

		if (!current_user_can('manage_options'))
		{
			return;
		}
		
		$response = wp_remote_get(MZLDR_GET_LICENSE_VERSION_URL);

		if (!is_array($response))
		{
			return false;
		}

		$response_decoded = null;

		try
		{
			$response_decoded = json_decode( $response['body'] );
		}
		catch ( Exception $ex )
		{
			return false;
		}

		$new_version = $response_decoded->version;

		if (!version_compare(MZLDR_VERSION, $new_version, '<'))
		{
			return false;
		}

		// load update notice
		$name = 'MAZ Loader';
		$version = $new_version;
		ob_start();
		include MZLDR_ADMIN_PATH . 'partials/templates/update_notice.php';
		$notice = ob_get_clean();
		
		echo json_encode([
			'html' => $notice
		]);
		wp_die();
	}

	private function loadMedia()
	{
		// load update notice js
		wp_register_script(
			'mzldr-update-notice-js',
			MZLDR_ADMIN_MEDIA_URL . 'js/mzldr-update-notice.js',
			[],
			MZLDR_VERSION,
			false
		);
		wp_enqueue_script( 'mzldr-update-notice-js' );
	}
}