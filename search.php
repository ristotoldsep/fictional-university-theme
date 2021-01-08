<?php get_header();  //THIS IS THE FALLBACK SEARCH RESULTS PAGE - page-search.php submits the form and directs here!

  pageBanner(array(
    'title' => 'Search Results for:',
    'subtitle' => '&ldquo;' . esc_html(get_search_query(false)) . '&rdquo;', //esc does not let input malicious code! getsearchquery does that too, but we can no set it to false
    'photo' => get_theme_file_uri('/images/raamatukogu.jpg')
  ));
?>

    <!-- <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php //echo get_theme_file_uri('/images/raamatukogu.jpg') ?>);"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title">Welcome to our blog!</h1>
      <div class="page-banner__intro">
        <p>Keep up with our latest news.</p>
      </div>
    </div>  
  </div> -->

    <div class="container container--narrow page-section"> 
    <?php 

      if (have_posts()) {
            while(have_posts()) {
            the_post(); 

            //LOOPING THROUGH THE SEARCH RESULTS AND EACH POST TYPE GETS THEIR DISTINCTIVE LAYOUT
            get_template_part('template-parts/content', get_post_type());
            
            // if (get_post_type() == 'professor') { //One way of outputting post category
            //     echo '<h1>I am a professor</h1>';
            // }
            }
            echo paginate_links(); //PAGINATION LINKS AS EASY AS THAT!
      } else {
            echo '<h2 class="headline headline--small-plus">No results match that search.</h2>';
      }

      get_search_form(); //THIS GETS THE SEARCH FORM AND WE WONT HAVE TO DUPLICATE CODE, searchform.php (NAME OF THIS FILE IS IMPORTANT)

    ?> 

    </div>


 <?php get_footer(); ?>