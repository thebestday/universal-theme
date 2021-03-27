<?php

if ( ! is_active_sidebar( 'main-sidebar-bottom' ) ) {
	return;
}


?>

<aside class="sidebar-front-page">
	<?php dynamic_sidebar( 'main-sidebar-bottom' ); ?>
</aside>




