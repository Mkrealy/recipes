<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$settings   			= get_option( 'oih_settings', array() );

$opt_in_id		 		= $this->_opt_in->get('id');
$opt_in_type     		= $this->_opt_in->get('type');
$opt_in_options  		= $this->_opt_in->get('options');
$opt_in_data_attributes = $this->_data_attributes;
$required_fields 		= OIH_Opt_In_Form_Handler::get_required_fields( $opt_in_id );

$opt_in_image_url 		= ( ! empty( $opt_in_options['opt_in_image'] ) ? wp_get_attachment_image_url( (int)$opt_in_options['opt_in_image'], 'large' ) : false );
$alt = esc_html__('image', 'optin-hound');
?>

<div id="opt-in-hound-opt-in-<?php echo esc_attr( $opt_in_id ); ?>" class="opt-in-hound-opt-in-wrapper <?php echo 'opt-in-hound-opt-in-form-position-' . ( ! empty( $opt_in_options['form_position'] ) ? esc_attr( $opt_in_options['form_position'] ) : 'bottom' ); ?> <?php echo 'opt-in-hound-opt-in-form-fields-orientation-' . ( ! empty( $opt_in_options['form_fields_orientation'] ) ? esc_attr( $opt_in_options['form_fields_orientation'] ) : 'inline' ); ?> <?php echo ( ( $opt_in_image_url ) ? 'opt-in-hound-opt-in-has-image' : '' ); ?>" <?php echo $opt_in_data_attributes; ?>>

	<div class="opt-in-hound-opt-in-content-wrapper">

		<?php if( $opt_in_image_url ): ?>
			<div class="opt-in-hound-opt-in-image-wrapper">
				<img src="<?php echo esc_attr( $opt_in_image_url ); ?>" alt="<?php echo esc_attr($alt);?>" />
			</div>
		<?php endif; ?>

		<?php if( ! empty( $opt_in_options['opt_in_heading'] ) ): ?>
			<h3 class="opt-in-hound-opt-in-heading"><?php echo wp_kses_post(strip_tags($opt_in_options['opt_in_heading'])); ?></h3>
		<?php endif; ?>

		<?php if( ! empty( $opt_in_options['opt_in_content'] ) ): ?>
			<?php echo wpautop( $opt_in_options['opt_in_content'] ); ?>
		<?php endif; ?>

	</div>

	<div class="opt-in-hound-opt-in-form-wrapper">
		<form class="opt-in-hound-opt-in-form opt-in-hound-opt-in-form-fields-<?php echo ( ! empty( $opt_in_options['form_fields'] ) ? count( $opt_in_options['form_fields'] ) + 1 : '1' ); ?>">

			<?php if( ! empty( $opt_in_options['form_fields']['first_name'] ) ): ?>
				<div class="opt-in-hound-opt-in-form-input">
					<?php $field_placeholder = ( isset( $opt_in_options['form_field_placeholder_first_name'] ) ? $opt_in_options['form_field_placeholder_first_name'] : __( 'First Name', 'opt-in-hound' ) ); ?>
					<input type="text" data-name="oih_first_name" placeholder="<?php echo esc_attr( apply_filters( 'oih_opt_in_template_form_field_first_name_placeholder', $field_placeholder, $opt_in_id ) ) . ( in_array( 'first_name' , $required_fields ) ? ' *' : '' ); ?>" <?php echo ( in_array( 'first_name' , $required_fields ) ? 'required' : '' ); ?> />
				</div>
			<?php endif; ?>

			<?php if( ! empty( $opt_in_options['form_fields']['last_name'] ) ): ?>
				<div class="opt-in-hound-opt-in-form-input">
					<?php $field_placeholder = ( isset( $opt_in_options['form_field_placeholder_last_name'] ) ? $opt_in_options['form_field_placeholder_last_name'] : __( 'Last Name', 'opt-in-hound' ) ); ?>
					<input type="text" data-name="oih_last_name" placeholder="<?php echo esc_attr( apply_filters( 'oih_opt_in_template_form_field_last_name_placeholder', $field_placeholder, $opt_in_id ) ) . ( in_array( 'last_name' , $required_fields ) ? ' *' : '' ); ?>" <?php echo ( in_array( 'last_name' , $required_fields ) ? 'required' : '' ); ?> />
				</div>
			<?php endif; ?>

			<div class="opt-in-hound-opt-in-form-input">
				<?php $field_placeholder = ( isset( $opt_in_options['form_field_placeholder_email'] ) ? $opt_in_options['form_field_placeholder_email'] : __( 'E-mail', 'opt-in-hound' ) ); ?>
				<input type="email" data-name="oih_email" placeholder="<?php echo esc_attr( apply_filters( 'oih_opt_in_template_form_field_email_placeholder', $field_placeholder, $opt_in_id ) ) . ' *'; ?>" required />
			</div>

			<div class="opt-in-hound-opt-in-form-button">
				<button>

					<span><?php echo ( ! empty( $opt_in_options['form_button_text'] ) ? esc_attr( $opt_in_options['form_button_text'] ) : '' ) ?></span>

					<span class="oih-loading-spinner">
						<span class="oih-loading-spinner-bounce-1"><!-- --></span>
						<span class="oih-loading-spinner-bounce-2"><!-- --></span>
						<span class="oih-loading-spinner-bounce-3"><!-- --></span>
					</span>

				</button>
			</div>

			<input type="hidden" data-name="oih_opt_in_id" value="<?php echo esc_attr( $opt_in_id ); ?>" />
			<input type="hidden" data-name="oih_token" value="<?php echo wp_create_nonce( 'oih_opt_in_form_subscribe_' . $opt_in_id ); ?>" />

		</form>

		<?php if( ! empty( $opt_in_options['form_footer_text'] ) ): ?>
			<div class="opt-in-hound-opt-in-form-footer-text"><?php echo wpautop( $opt_in_options['form_footer_text'] ); ?></div>
		<?php endif; ?>

		<div class="opt-in-hound-opt-in-form-errors"><!-- --></div>

		<?php if( OIH_VERSION_TYPE == 'free' && empty( $settings['hide_attribution_links'] ) ): ?>
			<div class="opt-in-hound-opt-in-promo">
		    	<img src="<?php echo OIH_PLUGIN_DIR_URL; ?>/assets/img/powered-by.svg" />
		    	<a target="_blank" href="https://www.devpups.com/opt-in-hound/?utm_source=plugin&utm_medium=powered-by&utm_campaign=opt-in-hound"><?php echo sprintf( __( 'by %s', 'opt-in-hound' ), 'Opt-In Hound' ); ?></a>
		    </div>
		<?php endif; ?>
	
	</div>

	<div class="opt-in-hound-opt-in-success-message-wrapper">

		<?php if( ! empty( $opt_in_options['opt_in_success_message_heading'] ) ): ?>
			<h3 class="opt-in-hound-opt-in-success-message-heading"><?php echo wp_kses_post(strip_tags($opt_in_options['opt_in_success_message_heading'])); ?></h3>
		<?php endif; ?>

		<?php
			if( ! empty( $opt_in_options['opt_in_success_message'] ) ) {
				echo wpautop( $opt_in_options['opt_in_success_message'] );
			}
		?>

	</div>

</div>