<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
$fieldData = new MZLDR_Registry($this->field_data);
$custom_css = $fieldData->get( 'custom_css' );
$custom_js = $fieldData->get( 'custom_js' );

// classes
$field_classes = [];
if ($this->animation != 'none') {
	$field_classes[] = '';
	$field_classes[] = 'has-animation';
}
?>
<div
	id="mazloader-item-custom-html-<?php echo esc_attr($fieldData->get('loader_id') . '-' . $fieldData->get( 'id' )); ?>"
	class="mazloader-item-custom-html<?php echo esc_attr(implode(' ', $field_classes)); ?>"
	<?php echo (isset($this->animation) && $this->animation != 'none') ? 'data-field-animation="' . esc_attr($this->animation) . '"' : ''; ?>
>
	<div class="custom-html"><?php echo wp_kses($fieldData->get( 'custom_html' ), MZLDR_Helper::getAllowedHTMLTags()); ?></div>
	<?php if (!empty($custom_css)) { ?>
	<style type="text/css" class="custom-css"><?php echo wp_filter_nohtml_kses($custom_css); ?></style>
	<?php } ?>
	<?php if (!empty($custom_js)) { ?>
	<script type="text/javascript"><?php echo esc_js($custom_js); ?></script>
	<?php } ?>
</div>