<?php get_header();  

pageBanner(array(
  'title' => get_the_archive_title(), //WAS just the_archive_title() but we dont want it to echo anything (just return), so put get_ in front!
  'subtitle' => get_the_archive_description(),
  'photo' => get_theme_file_uri('/images/raamatukogu.jpg')

));
?>

    <!-- <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php //echo get_theme_file_uri('/images/raamatukogu.jpg') ?>);"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title">
        <?php 
            //the_archive_title(); //New WP function, if I want to customize I can use the logic below
        /* if (is_category()) { //CATEGORIES OR AUTHOR PAGES LOGIC
            single_cat_title(); //Outputting the category name
        }
        if (is_author()) {
           echo 'Posts by: '; the_author();
        } */?>
      </h1>
      <div class="page-banner__intro">
        <p><?php //the_archive_description();?></p>
      </div>
    </div>  
  </div> -->

    <div class="container container--narrow page-section"> 
    <?php 
      while(have_posts()) {
        the_post(); ?>
        <div class="post-item">
          <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

          <div class="metabox">
            <p>Posted by: <?php the_author_posts_link( );?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list( ', ' )?></p>
          </div>

          <div class="generic-content">
            <?php the_excerpt(  );?> <!-- SHows just a little bit !!!!! -->
            <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Read more &raquo;</a></p> <!--  raquo adds arrows-->
          </div>
          
        </div>
      <?php }
      
        echo paginate_links(); //PAGINATION LINKS AS EASY AS THAT!
    ?> 

    </div>


 <?php get_footer(); ?>