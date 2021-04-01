<?php
/**
 * Вывод виджета во Фронт-энде
 *
 * @param array $args     аргументы виджета.
 * @param array $instance сохраненные данные из настроек
 */

function widget( $args, $instance ) {
	$count = $instance['count'];
	echo $args['before_widget'];
	if ($count%4 ===0) {
		echo '<div class="container post-widget-wrapper">';
		//Цикл
		global $post;
		$posts = get_posts( array(	'numberposts' => $count,) );
		$category = get_the_category();
		rsort($category);
		$cat_add_id = $category[0]->term_id;
		$real_id = get_the_ID();

		$set = array('cat' =>$cat_add_id);
		$posts = get_posts($set);

		foreach( $posts as $post ){
			setup_postdata($post);
			if ($post->ID <> $real_id){
			?>
				<a href="<?php the_permalink(); ?> class="post-widget-permalink"">
					<img src="<?php 
					if ( has_post_thumbnail() ) {
						echo get_the_post_thumbnail_url();
						}
						else {
							echo get_template_directory_uri() . '/assets/images/img-default.png';
						} ?>" alt="" class="post-widget-thumb">
						
					<h4 class="post-widget-title"><?php echo mb_strimwidth(get_the_title(),0, 45, '...'); ?></h4>
					<div class="post-widget-info">
						<div class="eye">
							<svg width="15" height="15" fill= "#BCBFC2" class="icon likes-icon">
								<use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#eye"></use>
							</svg>
							<span class="eye-counter"><?php comments_number('0', '1', '%')?></span>
						</div>
						<div class="comments">
							<svg width="15" height="15" fill= "#BCBFC2" class="icon comments-icon">
								<use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#comment"></use>
							</svg>                                                        
							<span class="comments-counter"><?php comments_number('0', '1', '%')?></span>
						</div>
						
					</div>
				</a> 
			<?php
			}
		}
		wp_reset_postdata();
		echo '</div>';							
	}
	echo $args['after_widget'];
}