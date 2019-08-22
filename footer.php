<?php
/**
 * Footer template.
 *
 * @package P2
 */
?>
	<?php get_sidebar(); ?>

	<div class="clear"></div>

</div> <!-- // wrapper -->

<div id="footer">
	<p class="credit">
		<?php echo prologue_poweredby_link(); ?>
	    <?php printf( __( 'Theme: %1$s by %2$s.', 'Lunar' ), 'Lunar', '<a href="http://woothemes.com/" rel="designer">WooThemes</a>' ); ?>
	</p>
</div>

<div id="notify"></div>

<div id="help">
	<dl class="directions">
		<dt>c</dt><dd><?php _e( 'compose new post', 'Lunar' ); ?></dd>
		<dt>j</dt><dd><?php _e( 'next post/next comment', 'Lunar' ); ?></dd>
		<dt>k</dt> <dd><?php _e( 'previous post/previous comment', 'Lunar' ); ?></dd>
		<dt>r</dt> <dd><?php _e( 'reply', 'Lunar' ); ?></dd>
		<dt>e</dt> <dd><?php _e( 'edit', 'Lunar' ); ?></dd>
		<dt>o</dt> <dd><?php _e( 'show/hide comments', 'Lunar' ); ?></dd>
		<dt>t</dt> <dd><?php _e( 'go to top', 'Lunar' ); ?></dd>
		<dt>l</dt> <dd><?php _e( 'go to login', 'Lunar' ); ?></dd>
		<dt>h</dt> <dd><?php _e( 'show/hide help', 'Lunar' ); ?></dd>
		<dt><?php _e( 'shift + esc', 'Lunar' ); ?></dt> <dd><?php _e( 'cancel', 'Lunar' ); ?></dd>
	</dl>
</div>

<?php wp_footer(); ?>

</body>
</html>
