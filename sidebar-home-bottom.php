<?php

if ( ! is_active_sidebar( 'main-sidebar-bottom' ) ) {
	return;
}


?>

<aside id="secondary" class="sidebar-front-page">
	<?php dynamic_sidebar( 'main-sidebar-bottom' ); ?>
</aside>




