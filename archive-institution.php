<?php get_header();  

pageBanner(array(
  'title' => 'Our Campus',
  'subtitle' => 'You can find all our buildings on the map.',
  'photo' => get_theme_file_uri('/images/program.png')
))
?>

    <!-- <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php //echo get_theme_file_uri('/images/program.png') ?>);"></div>
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
        All Programs
      </h1>
      <div class="page-banner__intro">
        <p>There is something for everyone!</p>
      </div>
    </div>  
  </div> -->

    <div class="container container--narrow page-section"> 
        <div class="acf-map">
            <?php 
            while(have_posts()) {
                the_post(); 
                $mapLocation = get_field('map_location');
                ?>

                <div class="marker" data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng'] ?>">
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <?php echo $mapLocation['address']; ?>
                </div>
              <!--   <li><a href="<?php //the_permalink(); ?>">
                
                    the_title(); 
                    $mapLocation = get_field('map_location');
                    print_r($mapLocation);  
                
                </a></li> -->
            <?php } ?> 
        </div>
    </div>


 <?php get_footer(); ?>