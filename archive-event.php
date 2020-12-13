<?php get_header();  ?>

    <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/events.jpg') ?>);"></div>
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
        All Events
      </h1>
      <div class="page-banner__intro">
        <p>See what is going on in our campus.</p>
      </div>
    </div>  
  </div>

    <div class="container container--narrow page-section"> 
    <?php 
      while(have_posts()) {
        the_post(); ?>
        <div class="event-summary">
                  <a class="event-summary__date t-center" href="<?php the_permalink();?>">
                    <span class="event-summary__month"><?php 
                        //the_field('event_date', ); //TO ADD OUR CUSTOM FIELD DATE 
                        $eventDate = new DateTime(get_field('event_date')); //Creating new object that uses DateTime class as a blueprint
                        echo $eventDate->format('M'); //Looking inside that object and printing out 3 letter month
                      ?></span>
                    <span class="event-summary__day"><?php echo $eventDate->format('d'); //Looking inside that object and printing out 3 letter month ?></span>
                  </a>
                  <div class="event-summary__content">
                    <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
                    <p><?php echo wp_trim_words(get_the_content(), 18); //first 18 words ?> <a href="<?php the_permalink();?>" class="nu gray">Learn more</a></p>
                  </div>
                </div>
      <?php }
      
        echo paginate_links(); //PAGINATION LINKS AS EASY AS THAT!
    ?> 

    </div>


 <?php get_footer(); ?>