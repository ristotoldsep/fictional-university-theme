<?php get_header();  

   pageBanner(array(
    'title' => 'Past Events',
    'subtitle' => 'A recap of our past events.',
    'photo' => get_theme_file_uri('/images/events.jpg')
  ));
?>

   <!--  <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php //echo get_theme_file_uri('/images/events.jpg') ?>);"></div>
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
        Past Events
      </h1>
      <div class="page-banner__intro">
        <p>A recap of our past events. </p>
      </div>
    </div>  
  </div> -->

    <div class="container container--narrow page-section"> 
    <?php 
              $today = date('Ymd'); //Variable for todays date
              $pastEvents = new WP_Query(array( //Creating a new object from wp query class
                'paged' => get_query_var('paged', 1 ), //TELLS THE CUSTOM QUERY WHICH PAGE NUMBER THE RESULT SHOULD BE ON, gets the number from url, if no number(probably 1st page)
                //'posts_per_page' => 1,
                'post_type' => 'event', //TELLING DB WHICH POST TYPE WE WANT
                'meta_key' => 'event_date', //Telling wp the custom field we are interested in
                'orderby' => 'meta_value_num', //title = alphabetically, post_date = adding order, rand = randomly
                'order' => 'ASC', //also DESC
                'meta_query' => array( //FOR FILTERING DATES (OLD DATES DISAPPEAR)
                  array( //ONLY RETURN POSTS THAT ARE LESS THAN TODAYS DATE! (so in the past )
                    'key' => 'event_date', //event_date = Custom field name in dashboard
                    'compare' => '<',
                    'value' => $today,
                    'type' => 'numeric'
                  )
                )
              ));

        
      while($pastEvents->have_posts()) {
        $pastEvents->the_post();
        
        get_template_part('template-parts/content-event');

        /* ?>
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
      <?php */ }
      
        echo paginate_links(array(
            'total' => $pastEvents->max_num_pages
        )); //PAGINATION LINKS AS EASY AS THAT!
    ?> 

    </div>


 <?php get_footer(); ?>