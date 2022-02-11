<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<?php oih_admin_header(); ?>
<div class="wrap oih-wrap">

	<form method="GET" action="<?php echo admin_url( 'admin.php' ); ?>">

		<input type="hidden" name="page" value="<?php echo esc_attr( $this->menu_slug ); ?>" />
		<input type="hidden" name="subpage" value="add_new" />

		<h1><?php echo __( 'Add New Opt-In', 'opt-in-hound' ); ?></h1>

		<div id="oih-add-new-opt-in-select-type" class="oih-boxed oih-has-footer">

			<h2><?php echo __( 'Select Opt-In Type', 'opt-in-hound' ); ?></h2>

			<div class="">
				<?php 
					$opt_in_types = oih_get_opt_in_types();

					if( ! empty( $opt_in_types ) ) {
						foreach( $opt_in_types as $type => $type_data ) {
							echo '<div class="oih-select-opt-in-type">';
								echo '<input id="oih-opt-in-type-' . esc_attr( $type ) . '" name="opt_in_type" type="radio" value="' . esc_attr( $type ) . '" />';
								echo '<label for="oih-opt-in-type-' . esc_attr( $type ) . '">';
									echo '<img src="' . esc_attr( $type_data['image'] ) . '" />';
								echo '</label>';

								echo '<span>' . esc_html( $type_data['name'] ) . '</span>';
							echo '</div>';
						}
					}
				?>
			</div>

			<!-- Footer -->
			<div class="oih-opt-in-settings-footer">

				<div id="oih-select-new-opt-in-type-wrapper">
					<input disabled id="oih-select-new-opt-in-type" type="submit" class="button-primary" value="<?php echo __( 'Continue', 'opt-in-hound' ); ?>" />
					<div class="spinner"><!-- --></div>
				</div>

			</div>

		</div>

	</form>

</div>