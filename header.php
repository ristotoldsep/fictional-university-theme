<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?> <!-- Everything is in functions.php (title & links etc) -->
    </head>
    <body <?php body_class()?>>
        <header class="site-header">
      <div class="container">
        <h1 class="school-logo-text float-left" style="font-weight: 700;">
          <a href="<?php echo site_url()?>"><strong>TAL</strong>TECH</a>
        </h1>

        <a href="<?php echo esc_url(site_url('/search'))?>" class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
        <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
        <div class="site-header__menu group">
          <nav class="main-navigation">
            <ul>
              <li <?php if (is_page('about-us') or wp_get_post_parent_id(0) == 17) 
              echo 'class="current-menu-item"' ?>><a href="<?php echo site_url('/about-us'); ?>">About Us</a></li>
              <li <?php if (get_post_type() == 'program' /* Then obv related to programs*/) echo 'class="current-menu-item"'; ?>><a href="<?php echo get_post_type_archive_link('program'); ?>">Programs</a></li>
              <li <?php if (get_post_type() == 'event' OR is_page('past-events') /* Then obv related to events*/) echo 'class="current-menu-item"'; ?>><a href="<?php echo get_post_type_archive_link('event'); ?>">Events</a></li>
              <li <?php if (get_post_type() == 'institution' /* Then obv related to events*/) echo 'class="current-menu-item"'; ?>><a href="<?php echo get_post_type_archive_link('institution'); ?>">Campus</a></li>
              <li <?php if (get_post_type() == 'post' /* Then obv related to blog*/) echo 'class="current-menu-item"'; ?>><a href="<?php echo site_url('/blog'); ?>">Blog</a></li>
            </ul>
            <!-- Outputting a dynamic WP connected menu -->
            <?php 
                /* wp_nav_menu(array( //only accepts an array
                    'theme_location' => 'headerMenuLocation'
                )); */
            ?>
          </nav>
          <div class="site-header__util">

            <?php //=======================LOGGED IN LOGIC===============================

              if (is_user_logged_in()) {  //Is user logged in?  ?> 

                  <a href="<?php echo esc_url(site_url('/my-notes')); ?>" class="btn btn--small btn--orange float-left push-right">My Notes</a>

                  <a href="<?php echo wp_logout_url(); ?>" class="btn btn--small btn--dark-orange float-left btn--with-photo">
                  <span class="site-header__avatar"><?php echo get_avatar(get_current_user_id(), 60); //THE USER ID AND IMAGE SIZE IN PIXELS ?></span>
                  <span class="btn__text">Log Out</span>
                  </a>

              <?php } else {  //If user is not logged in        ?>

                  <a href="<?php echo wp_login_url(); /* echo esc_url(site_url('/wp-login.php')); ONE WAY */ ?>" class="btn btn--small btn--orange float-left push-right">Login</a>
                  <a href="<?php echo wp_registration_url(); /* echo esc_url(site_url('/wp-signup.php')); */ ?>" class="btn btn--small btn--dark-orange float-left">Sign Up</a>

              <?php } ?>
              
             
              
                
            
            <a href="<?php echo esc_url(site_url('/search'))?>" class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>
    </header>
