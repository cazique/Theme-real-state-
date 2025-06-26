<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

// Control core classes for avoid errors
if( class_exists( 'CSF' ) ) {

  // Set a unique slug-like ID
  $prefix = 'luxus_profile_options';

  //
  // Create profile options
  CSF::createProfileOptions( $prefix, array(
    'data_type' => 'unserialize', // The type of the database save options. `serialize` or `unserialize`
  ) );

  //
  // Create a section
  CSF::createSection( $prefix, array(

    'fields' => array(

      // Heading
      array(
        'type'    => 'heading',
        'content' => esc_html__( 'Additional Information', 'luxus-core' ),
      ),

      // User Profile Image
      array(
        'id'        => 'luxus_user_profile_img',
          'type'    => 'media',
          'title'   => esc_html__( 'Upload Profile Image', 'luxus-core' ),
          'library' => 'image',
          'url'     =>  false,
      ),

      // User Thumbnail Image
      array(
        'id'        => 'luxus_user_profile_thumbnail',
          'type'    => 'media',
          'title'   => esc_html__( 'Upload Thumbnail Image', 'luxus-core' ),
          'library' => 'image',
          'url'     =>  false,
      ),

      // Gender
      array(
        'id'          => 'luxus_user_gender',
        'type'        => 'select',
        'title'       => esc_html__( 'Gender', 'luxus-core' ),
        'chosen'      => true,
        'placeholder' => esc_html__( 'Select Gender', 'luxus-core' ),
        'options'     => array(
          'male'      => esc_html__( 'Male', 'luxus-core' ),
          'female'    => esc_html__( 'Female', 'luxus-core' ),
          'other'     => esc_html__( 'Other', 'luxus-core' ),
        ),
        'default'     => '',
        'settings'    => array (
        'width'     => '50%',
        ),
      ),

      // Designation
      array(
        'id'      => 'luxus_user_designation',
        'type'    => 'text',
        'title'   => esc_html__( 'Designation', 'luxus-core' ),
      ),

      // License Number
      array(
        'id'      => 'luxus_user_license',
        'type'    => 'text',
        'title'   => esc_html__( 'License #', 'luxus-core' ),
      ),

      // Tax Number
      array(
        'id'      => 'luxus_user_tax',
        'type'    => 'text',
        'title'   => esc_html__( 'Tax #', 'luxus-core' ),
      ),

      // Phone Number
      array(
        'id'      => 'luxus_user_phone',
        'type'    => 'text',
        'title'   => esc_html__( 'Phone #', 'luxus-core' ),
      ),

      // Fax Number
      array(
        'id'      => 'luxus_user_fax',
        'type'    => 'text',
        'title'   => esc_html__( 'Fax #', 'luxus-core' ),
      ),

      // Mobile Number
      array(
        'id'      => 'luxus_user_mobile',
        'type'    => 'text',
        'title'   => esc_html__( 'Mobile #', 'luxus-core' ),
      ),

      // Address Lisne 1
      array(
        'id'      => 'luxus_user_address_one',
        'type'    => 'text',
        'title'   => esc_html__( 'Address Line 1', 'luxus-core' ),
      ),

      // Address Lisne 2
      array(
        'id'      => 'luxus_user_address_two',
        'type'    => 'text',
        'title'   => esc_html__( 'Address Line 2', 'luxus-core' ),
      ),

      // Address Lisne 2
      array(
        'id'      => 'luxus_user_city',
        'type'    => 'text',
        'title'   => esc_html__( 'City', 'luxus-core' ),
      ),

      // Postcode / Zip
      array(
        'id'      => 'luxus_user_postcode',
        'type'    => 'text',
        'title'   => esc_html__( 'Postcode / Zip', 'luxus-core' ),
      ),

      // Select Country
      array(
        'id'          => 'luxus_user_country',
        'type'        => 'select',
        'title'       => esc_html__( 'Select Country', 'luxus-core' ),
        'chosen'      => true,
        'placeholder' => esc_html__( 'Select Country', 'luxus-core' ),
        'options'     => 'luxus_countries_list',
        'class'       => 'luxus_user_countries',
        'default'     => '',
        'settings'    => array (
          'width'     => '50%',
        ),
      ),

      // Select States
      array(
        'id'          => 'luxus_user_state',
        'type'        => 'select',
        'title'       => esc_html__( 'Select State', 'luxus-core' ),
        'chosen'      => true,
        'placeholder' => esc_html__( 'Select State', 'luxus-core' ),
        'options'     => 'luxus_states_list',
        'class'       => 'luxus_user_states',
        'default'     => '',
        'settings'    => array (
          'width'     => '50%',
        ),
      ),

      // Location Map
      array(
        'id'    => 'luxus_user_map',
        'type'  => 'map',
        'address_field' => 'luxus_user_address_one',
        'title' => esc_html__('Map', 'luxus-core'),
        'height'   => '350px',
        'settings' => array(
          'scrollWheelZoom' => true,
          'zoom' => 4,
        )
      ),

      // Agents
      array(
        
        'id'          => 'luxus_user_agents',
        'type'        => 'select',
        'title'       => esc_html__( 'Select Agents', 'luxus-core' ),
        'chosen'      => true,
        'multiple'      => true,
        'placeholder' => esc_html__( 'Select Agents', 'luxus-core' ),
        'options'     => 'luxus_agents_list',
        'class'       => 'luxus_user_agents',
        'default'     => '',
        'settings'    => array (
          'width'     => '50%',
        ),
      ),

      // Social Media

      // Heading
      array(
        'type'    => 'heading',
        'content' => esc_html__( 'Social Media', 'luxus-core' ),
      ),

      // Facebook
      array(
        'id'      => 'luxus_user_facebook',
        'type'    => 'text',
        'title'   => esc_html__( 'Facebook', 'luxus-core' ),
      ),

      // Instagram
      array(
        'id'      => 'luxus_user_instagram',
        'type'    => 'text',
        'title'   => esc_html__( 'Instagram', 'luxus-core' ),
      ),

      // Twitter
      array(
        'id'      => 'luxus_user_twitter',
        'type'    => 'text',
        'title'   => esc_html__( 'Twitter', 'luxus-core' ),
      ),

      // Linkedin
      array(
        'id'      => 'luxus_user_linkedin',
        'type'    => 'text',
        'title'   => esc_html__( 'Linkedin', 'luxus-core' ),
      ),

      // Pinterest
      array(
        'id'      => 'luxus_user_pinterest',
        'type'    => 'text',
        'title'   => esc_html__( 'Pinterest', 'luxus-core' ),
      ),

      // Youtube
      array(
        'id'      => 'luxus_user_youtube',
        'type'    => 'text',
        'title'   => esc_html__( 'Youtube', 'luxus-core' ),
      ),

    )

  ) );

}