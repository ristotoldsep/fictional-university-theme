<?php get_header();  ?>

    <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/taltech.jpg') ?>);"></div>
      <div class="page-banner__content container t-center c-white">
        <h1 class="headline headline--large">Welcome!</h1>
        <h2 class="headline headline--medium">This is the official page for TalTech students.</h2>
        <h3 class="headline headline--small">Why don&rsquo;t you check out the <strong>major</strong> you&rsquo;re interested in?</h3>
        <a href="#" class="btn btn--large btn--blue">Find Your Major</a>
      </div>
    </div>

    <div class="full-width-split group">
      <div class="full-width-split__one">
        <div class="full-width-split__inner">
          <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>
            
            <?php 
              $homepageEvents = new WP_Query(array(
                'posts_per_page' => 2, //SHOWING ONLY 2 EVENTS
                'post_type' => 'event' //TELLING DB WHICH POST TYPE WE WANT
              ));

                while ($homepageEvents->have_posts()) { 
                $homepageEvents->the_post(); ?>
                
                  <div class="event-summary">
                  <a class="event-summary__date t-center" href="<?php the_permalink();?>">
                    <span class="event-summary__month"><?php the_time('M');?></span>
                    <span class="event-summary__day"><?php the_time('d');?></span>
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
              <?php }
            ?>

          <p class="t-center no-margin"><a href="<?php echo get_post_type_archive_link('event'); ?>" class="btn btn--blue">View All Events</a></p>
        </div>
      </div>
      <div class="full-width-split__two">
        <div class="full-width-split__inner">
          <h2 class="headline headline--small-plus t-center">From Our Blogs</h2>
          <?php 
            //=============================
            //CUSTOM QUERIES!!!!!!!!!
            //=============================
            $homepagePosts = new WP_Query(array( //Creating a variable (custom object) that accesses wp query class //TELLING THE ARRAY WHAT INFO WE WANT FROM THE DB
              'posts_per_page' => 2, //Queries 2 posts
              //'post_type' => 'post' //queries all the posts
              // 'post_type' => 'page' //Queries all the pages
              //'category_name' => 'test' //Only queries posts with test category
            )); //THIS IS WORDPRESS TEMPLATE CLASS THAT WE CAN ACCESS and create our own object! We have to tell this class what do we want to query! Wp does all the heavy lifting like db querys etc. Need to pass in array of arguments

            while ($homepagePosts->have_posts()) {
              $homepagePosts->the_post(); ?>
              <div class="event-summary">
                  <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink();?>">
                      <span class="event-summary__month"><?php the_time('M');?></span>
                      <span class="event-summary__day"><?php the_time('d');?></span>
                  </a>
                <div class="event-summary__content">
                  <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_title();?>"><?php the_title();?></a></h5>
                  <p><?php 
                  if (has_excerpt()) { //If the post has handmade custom excerpt
                    echo get_the_excerpt(); //Display it
                  } else {
                    echo wp_trim_words(get_the_content(), 18); //first 18 words 
                  } ?>
                  <a href="<?php the_permalink();?>" class="nu gray">Read more</a></p>
                </div>
              </div>
            <?php } wp_reset_postdata(); //ALWAYS SHOULD DO THIS AFTES CUSTOM QUERY, resetting wp data and global variables and returning to default queries
            //===================================== CUSTOM QUERY END
          ?>
         

          <p class="t-center no-margin"><a href="<?php echo site_url('/blog')?>" class="btn btn--yellow">View All Blog Posts</a></p>
        </div>
      </div>
    </div>

    <div class="hero-slider">
      <div data-glide-el="track" class="glide__track">
        <div class="glide__slides">
          <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/bus.jpg') ?>);">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">Free Transportation</h2>
                <p class="t-center">All students have free unlimited bus fare.</p>
                <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
          <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/apples.jpg') ?>);">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">An Apple a Day</h2>
                <p class="t-center">Our dentistry program recommends eating apples.</p>
                <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
          <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/bread.jpg') ?>);">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">Free Food</h2>
                <p class="t-center">Fictional University offers lunch plans for those in need.</p>
                <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
        </div>
        <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]"></div>
      </div>
    </div>

 <?php get_footer(); ?>