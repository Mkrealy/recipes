<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
$extra_classes = ! empty( $this->get_field_data( 'class' ) ) ? ' ' . implode( ' ', $this->get_field_data( 'class' ) ) : '';
$bind_atts     = MZLDR_Helper::getHTMLAttributes( $this->get_field_data( 'bind' ) );
$extra_atts	   = MZLDR_Helper::getHTMLAttributes( $this->get_field_data( 'extra_atts' ) );
$id = $this->get_field_data( 'id' );
$min = $this->get_field_data( 'min' );
$max = $this->get_field_data( 'max' );
$step = $this->get_field_data( 'step' );
$name = $this->get_field_data( 'name' );
$field_id = $this->get_field_data( 'field_id' );
?>
<input
	type="number"
	<?php if ( ! empty( $field_id ) ) { ?>
	data-field-id="<?php echo esc_attr( $field_id ); ?>"
	<?php } ?>
	<?php if ( ! empty( $id ) ) { ?>
	id="<?php echo esc_attr( $id ); ?>"
	<?php } ?>
	<?php if ( ! empty( $min ) || $min === 0 ) { ?>
	min="<?php echo esc_attr( $min ); ?>"
	<?php } ?>
	<?php if ( ! empty( $max ) || $max === 0 ) { ?>
	max="<?php echo esc_attr( $max ); ?>"
	<?php } ?>
	<?php if ( ! empty( $step ) || $step === 0 ) { ?>
	step="<?php echo esc_attr( $step ); ?>"
	<?php } ?>
	<?php if ( ! empty( $name ) ) { ?>
	name="<?php echo esc_attr( $name ); ?>"
	<?php } ?>
	value="<?php echo esc_attr( stripslashes( $this->get_field_data( 'value' ) ) ); ?>"
	placeholder="<?php echo esc_attr( $this->get_field_data( 'placeholder' ) ); ?>"
	class="mzldr-control-input-item<?php echo esc_attr( $extra_classes ); ?>"
	<?php echo wp_kses_data($bind_atts); ?>
	<?php echo wp_kses_data($extra_atts); ?>
/>
