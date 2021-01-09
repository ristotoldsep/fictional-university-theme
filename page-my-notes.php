<?php get_header();  //POWERS ABOUT US PAGE!!!!!!

    while(have_posts()) {
        the_post(); 
     
    pageBanner(
      /* array( 
      'title' => 'Haha',
      'subtitle' => 'Just testing out the subtitle'
      'photo' => 
      ) */ //I CAN PASS IN THESE AS ARGUMENTS IF I WANT, BUT WP WILL ALSO GET THEM AUTOMATICALLY, IF $ARGS is set to NULL in functions.php
    ); //Declaration in functions.php (adds custom thumbnail and subtitle) 
?>
        <!-- PAGE BANNER DIV WAS HERE PREVIOUSLY -->
        

  <div class="container container--narrow page-section">

    Custom code will go here!

  </div>
        
    <?php }

get_footer(); ?>