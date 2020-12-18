<?php get_header(); 
    while(have_posts()) {
        the_post(); 
        // IF THERE IS A BG IMAGE INSERTED FROM DASHBOARD, PASS THAT TO FX, ELSE PASS DEFAULT PROGRAMS PIC
        if (get_field('page_banner_background_image')) { 
            $customPic = get_field('page_banner_background_image')['sizes']['pageBanner'];
            //print_r($customPic);
        } else {
            $customPic = get_theme_file_uri('/images/program.png');
        }

        pageBanner(array(
          'photo' => $customPic
        ));
        ?>
       <!--  <div class="page-banner">
            <div class="page-banner__bg-image" style="background-image: url(<?php //echo get_theme_file_uri('/images/program.png') ?>);"></div>
                <div class="page-banner__content container container--narrow">
                     <h1 class="page-banner__title"><?php //the_title(); ?></h1>
                        <div class="page-banner__intro">
                            <p>DONT FORGET TO REPLACE ME!!</p>
                        </div>
                </div>  
        </div> -->
        
        <div class="container container--narrow page-section">
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('institution'); /* dynamic function, if we ever change url we don't also need to change it here*/?>"><i class="fa fa-home" aria-hidden="true"></i> All Institutions</a> <span class="metabox__main"><?php the_title(); ?></span></p>
            </div>

            <div class="generic-content">
                <?php the_content( );?>
            </div>

            <div class="acf-map">
                <?php 
                    $mapLocation = get_field('map_location');
                ?>

                <div class="marker" data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng'] ?>">
                <h3><?php the_title(); ?></h3>
                <?php echo $mapLocation['address']; ?>
                </div>
              <!--   <li><a href="<?php //the_permalink(); ?>">
                
                    the_title(); 
                    $mapLocation = get_field('map_location');
                    print_r($mapLocation);  
                
                </a></li> -->
           
        </div>

            <?php 
                //CUSTOM QUERIES FOR RELATED PROGRAMS !!!!!!!!!!!!!!!!!!!!!!
                //====================================
              $relatedPrograms = new WP_Query(array( //Creating a new object from wp query class
                'posts_per_page' => -1, //SHOWING ALL PROFESSORS (for example -1 returns all that meets these requirements)
                'post_type' => 'program', //TELLING DB WHICH POST TYPE WE WANT
                'orderby' => 'title', //title = alphabetically, post_date = adding order, rand = randomly
                'order' => 'ASC', //also DESC
                'meta_query' => array( //FOR FILTERING 
                  array( //ADDING SECOND QUERY FILTER HERE, ONLY SHOWING POSTS(professors) THAT ARE RELATED TO THIS PROGRAM
                      'key' => 'related_institution', //if the array of related programs
                      'compare' => 'LIKE', //CONTAINS
                      'value' => '"'. get_the_id() .'"' //The currently opened program/major (and its ID)
                  )
                )
              ));
                
              if ($relatedPrograms->have_posts()) { //if the subject has related professors
                echo '<hr class="section-break">';
                echo '<h2 class="headline headline--medium">' .get_the_title(). ' Programs</h2>'; //Subject + professors
                //PROFESSOR IMAGES LIST 
                echo '<ul class="min-list link-list">';
                while ($relatedPrograms->have_posts()) { 
                $relatedPrograms->the_post(); ?>
                
                <li>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </li>
              <?php }
              echo '</ul>';
              //====================
              }
              //====================
              wp_reset_postdata(); //SO EVENTS WOULD NOT DISAPPEAR //Because relates professors changes the page ID, can check with the_ID();
              //====================
              //RELATED EVENTS LIST FOR THIS INSTITUTION
              $today = date('Ymd'); //Variable for todays date
              $relatedEvents = new WP_Query(array( //Creating a new object from wp query class
                'posts_per_page' => -1, //SHOWING ONLY 2 EVENTS (for example -1 returns all that meets these requirements)
                'post_type' => 'event', //TELLING DB WHICH POST TYPE WE WANT
                'meta_key' => 'event_date', //Telling wp the custom field we are interested in
                'orderby' => 'meta_value_num', //title = alphabetically, post_date = adding order, rand = randomly
                'order' => 'ASC', //also DESC
                'meta_query' => array( //FOR FILTERING DATES (OLD DATES DISAPPEAR)
                  array( //ONLY RETURN POSTS THAT ARE GREATER THAN OR EQUAL OF TODAYS DATE!
                    'key' => 'event_date', //event_date = Custom field name in dashboard
                    'compare' => '>=',
                    'value' => $today,
                    'type' => 'numeric'
                  ),
                  array( //ADDING SECOND QUERY FILTER HERE, ONLY SHOWING POSTS THAT ARE RELATED TO THIS PROGRAM
                      'key' => 'related_institution', //if the array of related programs
                      'compare' => 'LIKE', //CONTAINS
                      'value' => '"'. get_the_id() .'"' //The currently opened program/major (and its ID)
                  )
                )
              ));
              //print_r($relatedEvents);
              if ($relatedEvents->have_posts()) {
                echo '<hr class="section-break">';
                echo '<h2 class="headline headline--medium">Upcoming ' .get_the_title(). ' events</h2>';

                //Returning 2 events and showing them in order (Only dates that are today or in the future)
                while ($relatedEvents->have_posts()) { 
                $relatedEvents->the_post();
                
                //GETTING RID OF DUPLICATE CODE
                /*ALSO CAN ADD SECOND ARGUMENT => get_template_part('template-parts/event', 'get_post_type()); , so it would be dynamic, [SEARCHES FOR content-event.php] */
                get_template_part('template-parts/content-event');

                /* ?>
                
                  <div class="event-summary">
                  <a class="event-summary__date t-center" href="<?php the_permalink();?>">
                    <span class="event-summary__month">
                      <?php 
                        //the_field('event_date', ); //TO ADD OUR CUSTOM FIELD DATE 
                        $eventDate = new DateTime(get_field('event_date')); //Creating new object that uses DateTime class as a blueprint
                        echo $eventDate->format('M'); //Looking inside that object and printing out 3 letter month
                      ?>
                    </span>
                    <span class="event-summary__day">
                      <?php 
                        echo $eventDate->format('d'); //Looking inside that object and printing out day number
                      ?>
                    </span>
                  </a>
                  <div class="event-summary__content">
                    <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
                    <p><?php 
                  if (has_excerpt()) { //If the post has handmade custom excerpt
                    echo get_the_excerpt(); //Display it
                  } else {
                    echo wp_trim_words(get_the_content(), 18); //first 18 words 
                  } ?> <a href="<?php the_permalink();?>" class="nu gray">Learn more</a></p>
                  </div>
                </div>
                <?php */ }
              }

            ?>

        </div>
        
    <?php }

 get_footer();?>