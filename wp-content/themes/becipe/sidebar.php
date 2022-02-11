<div class="becipe_fn_sidebar">
	<div class="becipe_fn_sidebar_in">
		<div class="forheight">
			<?php 
				if(is_single()){
					if ( is_active_sidebar( 'main-sidebar' ) ){
						dynamic_sidebar('Main Sidebar');
					}
				}else {
					if ( is_active_sidebar( 'main-sidebar' ) ){
						dynamic_sidebar('Main Sidebar');
					}
				}
			?>
		</div>
	</div>
</div>