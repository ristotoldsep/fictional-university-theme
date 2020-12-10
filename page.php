<?php get_header(); 

    while(have_posts()) {
        the_post(); ?>
        
        <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>);"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title(); ?></h1>
      <div class="page-banner__intro">
        <p>DONT FORGET TO REPLACE ME!!</p>
      </div>
    </div>  
  </div>

  <div class="container container--narrow page-section">

  <?php 
    // echo get_the_ID();
    $Parent = wp_get_post_parent_id(get_the_ID()); //Creating variable for the parent page ID of current page!
    if ($Parent) { ?>
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($Parent); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($Parent); ?></a> <span class="metabox__main"><?php the_title(); ?></span></p>
        </div>
    <?php } 
  ?>  

   <?php 
    $testArray = get_pages(array(
      'child_of' => get_the_ID()
    ));

    if ($Parent or $testArray) { ?>
    <div class="page-links">
      <h2 class="page-links__title"><a href="<?php echo get_permalink($Parent); ?>"><?php echo get_the_title($Parent); ?></a></h2>
      <ul class="min-list">
        <?php
          if ($Parent) {
            $findChildrenOf = $Parent;
          } else {
            $findChildrenOf = get_the_ID();
          }

          wp_list_pages(array(
            'title_li' => NULL,
            'child_of' => $findChildrenOf,
            'sort_column' => 'menu_order' //Can add custom order from admin dashboard!!
          ));
        ?>
      </ul>
    </div>
    <?php } ?>

    <div class="generic-content">
      <?php the_content(); ?>
    </div>

  </div>
        
    <?php }

get_footer(); ?>