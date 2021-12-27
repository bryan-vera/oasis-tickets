<?php
$current_user = wp_get_current_user();
$banner_1x 	  = forminator_plugin_url() . 'assets/images/poll_with_images.png';
$banner_2x 	  = forminator_plugin_url() . 'assets/images/poll_with_images@2x.png';
?>

<div
	id="forminator-new-feature"
	class="sui-dialog sui-dialog-onboard"
	aria-hidden="true"
>

	<div class="sui-dialog-overlay sui-fade-out" data-a11y-dialog-hide="forminator-new-feature" aria-hidden="true"></div>

	<div
		class="sui-dialog-content sui-fade-out"
		role="dialog"
	>

		<div class="sui-slider forminator-feature-modal" data-prop="forminator_dismiss_feature_11412" data-nonce="<?php echo esc_attr( wp_create_nonce( 'forminator_dismiss_notification' ) ); ?>">

			<ul role="document" class="sui-slider-content">

				<li class="sui-current sui-loaded" data-slide="1">

					<div class="sui-box">

						<div class="sui-box-banner" role="banner" aria-hidden="true" style="background: #0073AA;">
							<img
								src="<?php echo esc_url( $banner_1x ); ?>"
								srcset="<?php echo esc_url( $banner_1x ); ?> 1x, <?php echo esc_url( $banner_2x ); ?> 2x"
								class="sui-image"
								alt="Forminator"
							/>
						</div>

						<div class="sui-box-header sui-block-content-center">

							<button data-a11y-dialog-hide="forminator-new-feature" class="sui-dialog-close forminator-dismiss-new-feature" aria-label="<?php esc_html_e( 'Close this dialog window', 'forminator' ); ?>"></button>

							<?php //if ( FORMINATOR_PRO ) { ?>

								<h2 class="sui-box-title"><?php esc_html_e( 'New! Support for images in Poll answers', 'forminator' ); ?></h2>

							<?php //} else { ?>

						 	<?php //} ?>

						</div>

						<div class="sui-box-body sui-block-content-center" style="padding-bottom:30px;">

								<p class="sui-description"><?php printf( esc_html__( 'Hey, %s! Polls just got an exciting improvement: you can now use images or a combination of images and text in Poll answers. Give it a try!', 'forminator' ), ucfirst( $current_user->display_name ) ); ?></p>

								<p class="sui-description"><?php esc_html_e( 'We’ve also added Bulk Approval for User Registration submissions. Site Admins can now filter and approve users individually or in bulk.', 'forminator' ); ?></p>

						</div>

						<?php
						/* <div class="sui-box-body" sui-spacing-bottom="0" style="padding-bottom:30;">

							<ul class="sui-list" sui-type="bullets">

								<li>
									<p class="sui-description"></p>
								</li>

							</ul>

						</div> */
						?>

						<div class="sui-box-footer sui-block-content-center">

							<button class="sui-button forminator-dismiss-new-feature" type="button" data-a11y-dialog-hide="forminator-new-feature"><?php esc_html_e( 'Got It', 'forminator' ); ?></button>

						</div>

					</div>

				</li>

			</ul>

		</div>

	</div>

</div>

<script type="text/javascript">
	jQuery( '#forminator-new-feature .forminator-dismiss-new-feature' ).on( 'click', function( e ) {
		e.preventDefault();

		var $notice = jQuery( e.currentTarget ).closest( '.forminator-feature-modal' );
		var ajaxUrl = '<?php echo forminator_ajax_url();// phpcs:ignore ?>';

		jQuery.post(
			ajaxUrl,
			{
				action: 'forminator_dismiss_notification',
				prop: $notice.data('prop'),
				_ajax_nonce: $notice.data('nonce')
			}
		).always( function() {
			$notice.hide();
		});
	});
</script>
