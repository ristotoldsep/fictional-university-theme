<?php
 //==========================
    //CUSTOMIZING THE REST API / CREATING OUR OWN CUSTOM URL ROUTES to have more control //CREATING CUSTOM REST API " POST and DELETE " ENDPOINT
//=========================

add_action('rest_api_init', 'universityLikeRoutes');

function universityLikeRoutes() {
    //POST method
    register_rest_route('university/v1', 'manageLike', array(
        'methods' => 'POST',
        'callback' => 'createLike' //callback is just a function that we want to run when a request is sent to one of these routes
    ));
    //DELETE method
    register_rest_route('university/v1', 'manageLike', array(
        'methods' => 'DELETE',
        'callback' => 'deleteLike'
    ));
}

function createLike($data) {
    // return 'CREATING A LIKE SOON!'; initial test, returned to console...

    //Only logged in users can like
    if (is_user_logged_in()) {
        $professor = sanitize_text_field($data['professorID']); //This gets passed from /wp-json/university/v1/manageLike?professorID=...'

        //This query will only output something if the current user has already liked the professor with this ID
        $existQuery = new WP_Query(array(
            'author' => get_current_user_id(),
            'post_type' => 'like',
            'meta_query' => array(
                array(
                    'key' => 'liked_professor_id',
                    'compare' => '=',
                    'value' => $professor
                )
            )
        ));

        if ($existQuery->found_posts == 0 AND get_post_type($professor) == 'professor') {  //if the current user has not already liked the requested professor then go ahead and create that like post to dashboard (AND the id definitely belongs to professor post type)
            //CREATING A NEW POST TO DASHBOARD FROM PHP CODE
            return wp_insert_post(array(
                'post_type' => 'like',
                'post_status' => 'publish',
                'post_title' => get_post_field('post_title', $professor) . ' User ID# ' . get_current_user_id(),
                'meta_input' => array( //this will create WordPress custom fields or sometimes
                    'liked_professor_id' => $professor
                )
            )); 
            return 'Like added!';
        } else {
            die("ALREADY LIKED/Invalid professor id");
        }

    } else {
        die("Only logged in users can create a like.");
    }
    
}

function deleteLike($data) {
    // return 'DELETING A LIKE SOON!';

    $likeID = sanitize_text_field($data['like']); //'like' needs to match the name of the property that we're sending from your javascript.

    //get_post_field = first argument is what information you want about that post 
    //second argument is the ID of the post that you want information about.
    if (get_current_user_id() == get_post_field('post_author', $likeID) AND get_post_type($likeID) == 'like') {
        
         //First argument is obviously the ID of the post that we want to delete.
        //second argument is if you want to send it to the trash first or if you just want to skip the trash and permanently delete (true = skip trash)
        wp_delete_post($likeID, true);

        return 'Like deleted!';
    } else {
        die("You do not have permission to delete that.");
    }
}

