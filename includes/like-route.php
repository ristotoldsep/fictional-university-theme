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

function createLike() {
    return 'CREATING A LIKE SOON!';
}

function deleteLike() {
    return 'DELETING A LIKE SOON!';
}

