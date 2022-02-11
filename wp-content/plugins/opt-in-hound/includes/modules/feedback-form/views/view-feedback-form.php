<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<!-- Feedback form button -->
<div id="oih-feedback-button" class="oih-inactive">
	
	<img src="<?php echo OIH_PLUGIN_DIR_URL . 'includes/modules/feedback-form/assets/img/corgi-100x100.png' ?>" />
	<span class="oih-close dashicons dashicons-no-alt"></span>

</div>

<!-- Feedback form -->
<div id="oih-feedback-form-wrapper" class="oih-inactive">

	<!-- Form Header -->
	<div id="oih-feedback-form-header">

		<div id="oih-feedback-form-header-image">
			<img src="<?php echo OIH_PLUGIN_DIR_URL . 'includes/modules/feedback-form/assets/img/corgi-100x100.png' ?>" />
		</div>

		<strong><?php echo __( "I'm here to help", 'opt-in-hound' ); ?></strong>

	</div>

	<!-- Form Inner -->
	<div id="oih-feedback-form-inner">
		
		<!-- Panel 1 -->
		<div id="oih-feedback-form-panel-1" class="oih-feedback-form-panel oih-doing">

			<label class="oih-feedback-form-panel-label"><?php echo __( 'Hey there! How can I help you?', 'opt-in-hound' ); ?></label>

			<input id="oih-feedback-form-radio-bug" type="radio" name="issue" value="Bug" />
			<label for="oih-feedback-form-radio-bug" class="oih-selection-label"><?php echo __( 'I think I found a bug. Something is not working right.', 'opt-in-hound' ); ?></label>

			<input id="oih-feedback-form-radio-setup" type="radio" name="issue" value="Setup" />
			<label for="oih-feedback-form-radio-setup" class="oih-selection-label"><?php echo __( "I don't know how to set up the plugin.", 'opt-in-hound' ); ?></label>

			<input id="oih-feedback-form-radio-feature" type="radio" name="issue" value="Feature" />
			<label for="oih-feedback-form-radio-feature" class="oih-selection-label"><?php echo __( 'I want to propose a new feature for the plugin.', 'opt-in-hound' ); ?></label>

			<input id="oih-feedback-form-radio-other" type="radio" name="issue" value="Other" />
			<label for="oih-feedback-form-radio-other" class="oih-selection-label"><?php echo __( 'Some other thing...', 'opt-in-hound' ); ?></label>

		</div>

		<!-- Panel 2 -->
		<div id="oih-feedback-form-panel-2" class="oih-feedback-form-panel oih-todo">

			<label class="oih-feedback-form-panel-label"><?php echo __( 'Please detail a bit more:', 'opt-in-hound' ); ?></label>

			<textarea placeholder="<?php echo __( 'Write the details here...', 'opt-in-hound' ); ?>"></textarea>

			<p id="oih-feedback-form-description-char-count-1" class="description">Minimum 250 characters</p>
			<p id="oih-feedback-form-description-char-count-2" class="description"><span id="oih-feedback-form-char-count">250</span> characters remaining</p>

		</div>

		<!-- Panel 3 -->
		<div id="oih-feedback-form-panel-3" class="oih-feedback-form-panel oih-todo">

			<label class="oih-feedback-form-panel-label"><?php echo __( 'Please enter your email address:', 'opt-in-hound' ); ?></label>

			<input type="email" value="" placeholder="<?php echo __( 'Write the email address here...', 'opt-in-hound' ); ?>" />

			<p class="description"><?php echo __( "Let us know where to contact you regarding your request.", 'opt-in-hound' ); ?></p>

		</div>

		<!-- Panel 4 - Success message -->
		<div id="oih-feedback-form-panel-4" class="oih-feedback-form-panel oih-todo">

			<span class="dashicons dashicons-yes"></span>
			<p><?php echo __( 'Thank you for reaching out! We will get back to you as soon as possible.', 'opt-in-hound' ); ?></p>

		</div>

	</div>

	<!-- Form Navigation -->
	<div id="oih-feedback-form-navigation">

		<a id="oih-feedback-form-back" href="#"><?php echo __( 'Back', 'opt-in-hound' ); ?></a>
		<a id="oih-feedback-form-next" class="oih-inactive" href="#"><?php echo __( 'Next', 'opt-in-hound' ); ?></a>
		<a id="oih-feedback-form-send" class="oih-inactive" href="#"><?php echo __( 'Send', 'opt-in-hound' ); ?></a>

		<div class="spinner"><!-- --></div>

	</div>

	<!-- Nonce -->
	<?php wp_nonce_field( 'oih_feedback_form', 'oih_token', false ); ?>

</div>