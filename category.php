<?php get_header();?>
<div class="container">
	<h1 class="category-title">		
		<?php single_cat_title(); ?>
	</h1>	
	<div class="post-list">
		<?php while ( have_posts() ){ the_post(); ?>
			<div class="post-card">
				<img src="<?php if(has_post_thumbnail() ){
									echo get_the_post_thumbnail_url();																						
								} 
								else {
									echo get_template_directory_uri(). '/assets/images/img-default.png';
								}			
							?>" alt="" class="post-card-thumb">
				<div class="post-card-text">
					<h2 class="post-card-title"><?php echo mb_strimwidth(get_the_title(), 0, 20, '...') ?></h2>			
					<a href="<?php the_permalink() ?>"						
						<p><?php echo mb_strimwidth(get_the_excerpt(), 0, 90, '...');?></p>
					</a>

					<div class="author">
						<?php $author_id = get_the_author_meta('ID'); ?>
						<img src="<?php echo get_avatar_url($author_id); ?>" alt="" class="author-avatar">
						<div class="author-info">
							<span class="author-name"><strong><?php the_author();?></strong></span>	
							<span class="date"><?php the_time('j F');?></span>

							<div class="comments">
								<!-- <img src="<?echo get_template_directory_uri() . '/assets/images/comment-white.svg' ?>" alt="icon: comment" class="comments-icon"> -->
								<svg width="19" height="15" fill="#fff" class="icon comments-icon">
									<use xlink:href="<?php echo get_template_directory_uri() ?>. /assets/images/sprite.svg#comment"></use>
								</svg>
								<span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
							</div>

							<div class="likes">
								<svg width="19" height="15" fill="#BCBFC2" class="likes-icon">
									<use xlink:href="<?php echo get_template_directory_uri() ?>. /assets/images/sprite.svg#heart"></use>
								</svg>
								<!-- <img src="<?php echo get_template_directory_uri() . '/assets/images/heart.svg' ?>" alt="icon: like" class="likes-icon"> -->
								<span class="likes-counter"><?php comments_number('0', '1', '%') ?></span>
							</div>
						</div>
						<!-- /.author-info -->
					</div>
					<!-- /.author-->
				</div>
			</div>	
			<!-- /. post-card -->
		<?php } ?>
		<?php if ( ! have_posts() ){ ?>
			Записей нет.
		<?php } ?>
		
	</div>	
	<!-- /. post-list -->
	<?php
		$args = array(
			'prev_text' => '&larr; Назад',
			'next_text' => 'Вперед &rarr;',
		);
		the_posts_pagination();	
	?>
</div>

<?php get_footer();?>
