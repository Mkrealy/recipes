<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
$fieldData = new MZLDR_Registry($this->field_data);
$loader_id = $fieldData->get('loader_id');
$id = $loader_id . '-' . $fieldData->get('id');
$lottie_settings = [
	'loader_id' => $fieldData->get('loader_id'),
	'id' => $id,
	'method' => $fieldData->get('method'),
	'json' => $fieldData->get('json'),
	'url' => $fieldData->get('url'),
	'num_of_times' => (int) $fieldData->get('num_of_times'),
	'loop' => $fieldData->get('loop') == 'on'
];
wp_enqueue_script('mzldr-lottie-field', MZLDR_PUBLIC_MEDIA_URL . 'js/lottie.min.js', array(), MZLDR_VERSION, true);
?>
<div
	id="mazloader-item-lottie-<?php echo esc_attr($id); ?>"
	style="max-width: <?php echo esc_attr($fieldData->get('width')); ?>;"
	data-settings="<?php echo htmlspecialchars(json_encode($lottie_settings), ENT_QUOTES, 'UTF-8'); ?>"
	class="mazloader-item-lottie">
</div>