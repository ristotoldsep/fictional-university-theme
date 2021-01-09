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

    <!-- Create Note Form -->
    <div class="create-note">

        <h2 class="headline headline--medium">Create New note</h2>
        <input class="new-note-title" type="text" placeholder="Title">
        <textarea class="new-note-body" placeholder="Your note here..." name="" id="" cols="30" rows="10"></textarea>
        <span class="submit-note">Create Note</span>

    </div>
    
    <!-- Existing Notes List -->
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
                
                <li data-id="<?php the_ID(); ?>">
                    
                    <input readonly class="note-title-field" type="text" value="<?php 
                    
                    /* str_replace arguments - 1st - string of text that you want to search for withing 3rd arg., 2nd - what you want to replace the 2nd arg with , 3rd - text that you want to begin with or that you want to manipulate */
                    echo str_replace('Private: ' , '', esc_attr(get_the_title())); //To get rid of "Private: " in our title (cause of post type permissions)
                    
                    ?>">

                    <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span>

                    <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span>

                    <textarea readonly class="note-body-field"><?php echo esc_textarea(wp_strip_all_tags(get_the_content())); //esc for security, strip tags to remove wordpress html tags and comments! ?></textarea>

                    <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i>Save</span>
                </li>
        
            <?php } ?>
        
    </ul>

  </div>
        
    <?php }

get_footer(); ?>