<?php //POWERS ABOUT US PAGE!!!!!!

//REDIRECTING THE USER if he somehow gets to this URL and is not logged in! - MUST come before get_header()
    if (!is_user_logged_in()) {
        wp_redirect(esc_url(site_url('/')));
        exit; //Stop using server resources
    }

get_header();  

    

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

    <ul class="min-list link-list" id="my-notes">
        <?php  
            //Creating a custom query object to retrieve notes from WP database (mySQL)
            $userNotes = new WP_Query(array(
                'post_type' => 'note',
                'posts_per_page' => -1,
                'author' => get_current_user_id()
            ));

            while($userNotes->have_posts()) {
                $userNotes->the_post(); ?>
                
                <li>
                    <input class="note-title-field" type="text" value="<?php echo esc_attr(get_the_title()); ?>">

                    <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span>

                    <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span>

                    <textarea class="note-body-field"><?php echo esc_attr(wp_strip_all_tags(get_the_content())); //esc for security, strip tagas to remove wordpress html tags and comments! ?></textarea>
                </li>
        
            <?php } ?>
        
    </ul>

  </div>
        
    <?php }

get_footer(); ?>