		<footer class="footer">
			<div class="container">
				<!-- встроенный шаблон сайдбар -->
				<div class="footer-menu-bar">
					<?php dynamic_sidebar( 'sidebar-footer' ); ?>
				</div>
				<!-- /. footer-menu-bar -->
				<!-- После footer-menu-bar будет секция footer-info -->
				<div class="footer-info">
					<?php
						wp_nav_menu( [
							'theme_location'  => 'footer_menu',
							'container'       => 'nav', 
							'menu_class'      => 'footer-nav', 				
							'echo'            => true				
						] );
					?>

					<?php 
						$instance = array(
							'link_Facebook' => 'https://www.facebook.com/',
							'link_Instagram' => 'https://www.instagram.com/',
							'link_Youtube'   => 'https://www.youtube.com/',
							'link_Twitter'   => 'https://twitter.com/',
							'title' => '',
						);
						$args = array(
							'before_widget' => '<div class="footer-social">',
							'after_widget' => '</div>',
						);
						the_widget( 'Social_Widget', $instance, $args );
					?>
				</div>
				<!-- /. footer-info -->
				<?php  
					if (! is_active_sidebar(' sidebar-footer') ) {
						return;
					}
				?>
				
				<div class="footer-text-wrapper">				
					<?php dynamic_sidebar( 'sidebar-footer-text' ); ?>
					<span class="footer-copyright">
						<?php echo date('Y') . '&copy;' . get_bloginfo('name'); ?>
					</span>
				</div>
				<!-- /. footer-text-wrapper -->
			</div>

		</footer>
		
		<?php wp_footer(); ?>
	</body>
</html>