		<footer class="footer">
			<div class="container">
				<!-- <?php  
					if (! is_active_sidebar(' sidebar-footer') ) {
						return;
					}
				?> -->
				
				<!-- встроенный шаблон сайдбар -->
				<div class="footer-menu-bar">
					<?php dynamic_sidebar( 'sidebar-footer' ); ?>
				</div>
				

				<!-- После footer-menu-bar будет секция footer-info -->
				<div class="footer-info">
					<div class="hideimg">
						<img width="50" height="50" src="<?php echo get_template_directory_uri() . '/assets/images/logo_f.png' ?>" alt="">
					</div>
					
				

					<!-- <?php
						if( has_custom_logo() ){
								// логотип есть выводим его
							echo 'div class="logo">' . get_custom_logo() . '</div>';
						} else {
							echo '<span class="logo-name">' . get_bloginfo('name') . '</span>';
						}
					?> -->

				<!-- <?php
					if( has_custom_logo() ){
							// логотип есть выводим его
						the_custom_logo('');
					} else {
						echo 'Universal';
					}
				?>	 -->


					<?php
						wp_nav_menu( [
							'theme_location'  => 'footer_menu',
							'container'       => 'nav',
							// 'container_class' => 'footer-nav-wrapper',
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
						<?php echo date('Y ') . '&copy; ' . get_bloginfo('name'); ?>
					</span>
				</div>


				

				<!-- /. footer-text-wrapper -->
			</div>
		</footer>
	
		<?php wp_footer(); ?>
	</body>
</html>