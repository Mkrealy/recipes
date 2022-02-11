<?php 
$reasons = array(
		1 => '<li><label><input type="radio" name="oih_disable_reason" value="missing feature"/>' . __( 'Missing Feature', 'opt-in-hound' ) . '</label></li>
		<li><textarea name="oih_disable_text[]" placeholder="' . __( 'Please describe the feature that you need. This will help us prioritize our tasks and work on features that you requested.', 'opt-in-hound' ) . '"></textarea></li>',
		2 => '<li><label><input type="radio" name="oih_disable_reason" value="technical issue"/>' . __( 'Technical Issue', 'opt-in-hound' ) . '</label></li>
		<li><textarea name="oih_disable_text[]" placeholder="' . __( 'Please describe the issue. This will help us solve the problem for other users who might experience this.', 'opt-in-hound' ) . '"></textarea></li>',
    );
    
    shuffle( $reasons );

    $reasons[] = '<li><label><input type="radio" name="oih_disable_reason" value="other"/>' . __( 'Other Reason', 'opt-in-hound' ) . '</label></li>
                  <li><textarea name="oih_disable_text[]" placeholder="' . __( 'Please let us know how we can improve the experience for you.', 'opt-in-hound' ) . '"></textarea></li>'

?>


<div id="oih-deactivate-modal" style="display: none;">
    <div id="oih-deactivate-inner">
    	<form action="" method="post">
    	    <h3><strong><?php echo __( 'Thank you for using Opt-In Hound', 'opt-in-hound' ); ?></strong></h3>

            <p><strong><?php echo __( 'Please let us know what did not work for you. We would love to help you out.', 'opt-in-hound' ) ?></strong></p>

    	    <ul>
                <?php
                foreach( $reasons as $reason ) {
                    echo $reason;
                }
                ?>
    	    </ul>

    	    <?php if ( $email ) : ?>

                <div id="oih-deactivate-contact-me">
                    <label>
                        <input type="checkbox" value="yes" name="oih_contact_me" checked />
                        <?php echo __( 'Check this if you wish to be contacted by our support team to help you out with the issue.', 'opt-in-hound' ); ?>
                    </label>
            	    <input type="email" name="oih_disable_from" value="<?php echo esc_attr( $email ); ?>" placeholder="<?php echo __( 'Your email address', 'opt-in-hound' ); ?>" />
                </div>

    	    <?php endif; ?>

    	    <input disabled id="oih-feedback-submit" class="button button-primary" type="submit" name="oih-feedback-submit" value="<?php echo __( 'Submit & Deactivate', 'opt-in-hound' ); ?>"/>

    	    <a id="oih-only-deactivate" class="button"><?php echo __( 'Only Deactivate', 'opt-in-hound'); ?></a>
    	    <a class="oih-deactivate-close" href="#"><?php echo __( 'Don\'t deactivate', 'opt-in-hound'); ?></a>
    	</form>
    </div>
</div>