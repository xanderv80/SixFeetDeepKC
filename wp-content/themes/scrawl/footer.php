<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package scrawl
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'scrawl' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'scrawl' ), 'WordPress' ); ?></a>
			<span class="sep"> ~ </span>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'scrawl' ), 'Scrawl', '<a href="https://wordpress.com/themes/scrawl" rel="designer">WordPress.com</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>