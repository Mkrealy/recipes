<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
$total_loaders               = isset( $this->statistics->total_loaders ) ? number_format_i18n( $this->statistics->total_loaders ) : 0;
$enabled_loaders             = isset( $this->statistics->enabled_loaders ) ? number_format_i18n( $this->statistics->enabled_loaders ) : 0;
$seen_by_visitors            = isset( $this->statistics->seen_by_visitors ) ? number_format_i18n( $this->statistics->seen_by_visitors ) : 0;
$total_fields                = isset( $this->statistics->total_fields ) ? number_format_i18n( $this->statistics->total_fields ) : 0;
$total_impressions           = isset( $this->statistics->total_impressions ) ? number_format_i18n( $this->statistics->total_impressions ) : 0;
$average_impressions         = ( $total_loaders != 0 ) ? $this->statistics->total_impressions / $this->statistics->total_loaders : 0;
$total_impressions_yesterday = isset( $this->statistics->total_impressions_yesterday ) ? number_format_i18n( $this->statistics->total_impressions_yesterday ) : 0;
$total_impressions_today     = isset( $this->statistics->total_impressions_today ) ? number_format_i18n( $this->statistics->total_impressions_today ) : 0;
$month_projection            = isset( $this->statistics->month_projection ) ? number_format_i18n( $this->statistics->month_projection ) : 0;
?>
<div class="mzldr-page-settings">
	<div class="row">
		<div class="col-xs-8">
			<!-- Quick Menu -->
			<div class="mzldr-dashboard-actions quick-menu">
				<div class="row">
					<div class="item-outer col-xs-4">
						<div class="item">
							<a href="<?php echo esc_attr( get_admin_url( get_current_blog_id(), 'admin.php?page=maz-loader' ) ); ?>"><?php _e( 'New Loader', 'maz-loader' ); ?></a>
						</div>
					</div>
					<div class="item-outer col-xs-4">
						<div class="item">
							<a href="<?php echo esc_attr( get_admin_url( get_current_blog_id(), 'admin.php?page=maz-loader-list' ) ); ?>"><?php _e( 'View Loaders', 'maz-loader' ); ?></a>
						</div>
					</div>
					<div class="item-outer col-xs-4">
						<div class="item">
							<a href="<?php echo esc_attr( MZLDR_Constants::getSettingsURL() ); ?>"><?php _e( 'Settings', 'maz-loader' ); ?></a>
						</div>
					</div>
				</div>
			</div>
			<!-- /Quick Menu -->
			<!-- Statistics -->
			<div class="mzldr-dashboard-actions statistics">
				<h2 class="dashboard-section-title"><?php _e( 'Analytics', 'maz-loader' ); ?></h2>
				<div class="row">
					<div class="item-outer col-xs-4">
						<div class="item">
							<h2><?php echo esc_html( $total_loaders ); ?></h2>
							<span><?php _e( 'Loaders', 'maz-loader' ); ?></span>
						</div>
					</div>
					<div class="item-outer col-xs-4">
						<div class="item">
							<h2><?php echo esc_html( $enabled_loaders ); ?>/<?php echo esc_html( $total_loaders ); ?></h2>
							<span><?php _e( 'Loaders enabled', 'maz-loader' ); ?></span>
						</div>
					</div>
					<div class="item-outer col-xs-4">
						<div class="item">
							<h2><?php echo esc_html( $seen_by_visitors ); ?>/<?php echo esc_html( $total_loaders ); ?></h2>
							<span><?php _e( 'Seen by visitors', 'maz-loader' ); ?></span>
						</div>
					</div>
					<div class="item-outer col-xs-4">
						<div class="item">
							<h2><?php echo esc_html( $total_fields ); ?></h2>
							<span><?php _e( 'Total fields used in Loaders', 'maz-loader' ); ?></span>
						</div>
					</div>
					<div class="item-outer col-xs-4">
						<div class="item">
							<h2><?php echo esc_html( $total_impressions ); ?></h2>
							<span><?php _e( 'Total impressions', 'maz-loader' ); ?></span>
						</div>
					</div>
					<div class="item-outer col-xs-4">
						<div class="item">
							<h2><?php echo number_format( $average_impressions, 1 ); ?></h2>
							<span><?php _e( 'Average impressions per Loader', 'maz-loader' ); ?></span>
						</div>
					</div>
					<div class="item-outer col-xs-4">
						<div class="item">
							<h2><?php echo esc_html( $total_impressions_yesterday ); ?></h2>
							<span><?php _e( 'Impressions yesterday', 'maz-loader' ); ?></span>
						</div>
					</div>
					<div class="item-outer col-xs-4">
						<div class="item">
							<h2><?php echo esc_html( $total_impressions_today ); ?></h2>
							<span><?php _e( 'Impressions today', 'maz-loader' ); ?></span>
						</div>
					</div>
					<div class="item-outer col-xs-4">
						<div class="item">
							<h2><?php echo esc_html( $month_projection ); ?></h2>
							<span><?php _e( 'Current Month Impressions Projection', 'maz-loader' ); ?></span>
						</div>
					</div>
				</div>
			</div>
			<!-- /Statistics -->
			<!-- Recent Loaders -->
			<div class="mzldr-dashboard-actions mzldr-recent-loaders">
				<h2 class="dashboard-section-title"><?php _e( 'Recent Loaders', 'maz-loader' ); ?></h2>
				<?php if ( count( $this->loaders ) ) { ?>
				<table>
					<thead>
						<tr>
							<th><?php _e('ID', 'maz-loader'); ?></th>
							<th><?php _e('Loader', 'maz-loader'); ?></th>
							<th><?php _e('Impressions', 'maz-loader'); ?></th>
							<th><?php _e('Created at', 'maz-loader'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ( $this->loaders as $loader ) {
							$id          = $loader->id;
							$name        = $loader->name;
							$impressions = $loader->impressions;
							$created_at  = $loader->created_at;
							?>
							<tr>
								<td><?php echo esc_html( $id ); ?></td>
								<td><a href="?page=maz-loader&action=edit&loader_id=<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $name ); ?></a></td>
								<td><?php echo esc_html( $impressions ); ?></td>
								<td><?php echo esc_html( $created_at ); ?></td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
				<?php } else { ?>
				<p class="mzldr-info-message"><?php _e( 'No loaders found. Start adding one by clicking <a href="' . esc_attr( get_admin_url( get_current_blog_id(), 'admin.php?page=maz-loader' ) ) . '">here</a>' ); ?></p>
				<?php } ?>
			</div>
			<!-- /Recent Loaders -->
		</div>
		<?php require __DIR__ . '/sidebar.php'; ?>
	</div>
</div>