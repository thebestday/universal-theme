<?php
/*
Template Name: Страница контакты
Template Post Type: page
*/
get_header();
?>
<section class="section-dark">
	<div class="container">
		<?php the_title('<h1 class="page-title>">', '</h1>', true); ?>
		<div class="contacts-wrapper">
			<div class="left">
				<h2 class="contacts-title">Через форму обратной связи</h2>
				<!-- <form action="form.php" class="contacts-form" method="POST">
					<input name="contact_name" type="text" class="input contacts-input" placeholder="Ваше имя">
					<input name="contact_email" type="email" class="input contacts-input" placeholder="Ваш email">
					<textarea name="contact_comment" id="" class="textarea contacts-textarea" placeholder="Ваш вопрос"></textarea>
					<button type="submit" class="button more">Отправить</button>					
				</form> -->
				<?php the_content() ?>
				<!-- <?php echo do_shortcode( '[contact-form-7 id="260" title="Контактная форма"]' )  ?> -->
			</div>
			<!-- /. left -->
			<div class="right">
				<h2 class="contacts-title">Или по этим контактам</h2>
				<!-- ЭТО самая ПРОСТАЯ КОНСТРУКЦИЯ БЕЗ ПРОВЕРКИ получения email -->
				<!-- <a href="mailto:hello@forpeople.studio"></a> -->

				<!-- ЭТО ПРОСТАЯ КОНСТРУКЦИЯ БЕЗ ПРОВЕРКИ получения email -->
				<!-- <a href="mailto:<?php echo get_post_meta(get_the_ID(), 'email', true); ?>">
					<?php echo get_post_meta(get_the_ID(), 'email', true); ?>
				</a> -->

				<!-- конструкция с проверкой  дополнительного поля email-->

				<?php
					$email = get_post_meta(get_the_ID(), 'Email', true);
					if($email) {
						echo '<a href="mailto:' . $email . '">' . $email . '</a>';
					}
				?>

				<?php
					$address = get_post_meta(get_the_ID(), 'Address', true);
					if($address) {
						echo '<address>' . $address . '</address>';
					}
				?>
			
				<?php
					$phone = get_post_meta(get_the_ID(), 'Phone', true);
					if($phone) {
						echo '<a href="tel:' . $phone . '">' . $phone . '</a>';
					}
				?>

				<!-- ACF есть спец штука позволяет выводить дополнительные поля -->

		
			</div>
		</div>			
	</div>
</section>
<?php

get_footer();
