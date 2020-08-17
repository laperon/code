<?php

function ph_register_custom_post_type() {
    /**
     * Register Events CPT
     */
    register_post_type( 'events', array(
        'labels'             => array(
            'name'               => __( 'Events' , 'ph' ),
            'singular_name'      => __( 'Event' , 'ph' ),
            'add_new'            => __( 'Add new event' , 'ph' ),
            'add_new_item'       => __( 'Add new event' , 'ph' ),
            'edit_item'          => __( 'Edit event' , 'ph' ),
            'view_item'          => __( 'View event' , 'ph' ),
            'search_items'       => __( 'Find events' , 'ph' ),
            'not_found'          => __( 'Events not found' , 'ph' ),
            'menu_name'          => __( 'Events' , 'ph' )
        ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => true,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title','editor','author','thumbnail','excerpt' )
    ) );

    /**
     * Register Team CPT
     */
    register_post_type( 'members', array(
        'labels'             => array(
            'name'               => __( 'Teams' , 'ph' ),
            'singular_name'      => __( 'Team' , 'ph' ),
            'add_new'            => __( 'Add new member' , 'ph' ),
            'add_new_item'       => __( 'Add new member' , 'ph' ),
            'edit_item'          => __( 'Edit member' , 'ph' ),
            'view_item'          => __( 'View member' , 'ph' ),
            'search_items'       => __( 'Find members' , 'ph' ),
            'not_found'          => __( 'Member not found' , 'ph' ),
            'menu_name'          => __( 'Teams' , 'ph' )
        ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => true,
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title','editor','author','thumbnail','excerpt' )
    ) );
}
add_action( 'init' , 'ph_register_custom_post_type' );
