<?php

if ( ! is_active_sidebar( 'sidebar-category' ) ) {
	return;
}


?>

<aside class="sidebar-front-page">
	<?php dynamic_sidebar( 'sidebar-category' ); ?>
</aside>



