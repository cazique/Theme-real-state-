<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

//-----------------------
// Forms Section Parent
//-----------------------
CSF::createSection( $prefix, array(
  'id'    => 'forms-section',
  'title' => esc_html__('Forms Setting', 'luxus-core'),
  'priority'  => 999,
) );

//---------------------------
// Forms Settings Section
//---------------------------
CSF::createSection( $prefix, array(
  'parent' => 'forms-section',
  'title'  => esc_html__('Forms General Setting', 'luxus-core'),
  'fields' => array(

    // A Heading
    array(
      'type'    => 'heading',
      'content' => esc_html__('Agent / Agency Contact Form', 'luxus-core'),
    ),

    // Contact Form Notify Author Email
    array(
      'id'         => 'contact-notify-author',
      'type'       => 'checkbox',
      'title'      => esc_html__('Notify Agent/Agency Email', 'luxus-core'),
      'label'      => esc_html__('Yes, Please do it.', 'luxus-core'),
      'default'    => true,
    ),

    // Contact Form Notify Admin Email
    array(
      'id'         => 'contact-notify-admin',
      'type'       => 'checkbox',
      'title'      => esc_html__('Notify Admin Email', 'luxus-core'),
      'label'      => esc_html__('Yes, Please do it.', 'luxus-core'),
      'default'    => true,
    ),

    // A Heading
    array(
      'type'    => 'heading',
      'content' => esc_html__('Property Schedule Tour Form', 'luxus-core'),
    ),

    // Schedule Tour Notify Author Email
    array(
      'id'         => 'schedule-notify-author',
      'type'       => 'checkbox',
      'title'      => esc_html__('Notify Agent/Agency Email', 'luxus-core'),
      'label'      => esc_html__('Yes, Please do it.', 'luxus-core'),
      'default'    => true,
    ),

    // Schedule Tour Notify Admin Email
    array(
      'id'         => 'schedule-notify-admin',
      'type'       => 'checkbox',
      'title'      => esc_html__('Notify Admin Email', 'luxus-core'),
      'label'      => esc_html__('Yes, Please do it.', 'luxus-core'),
      'default'    => true,
    ),

  )

) );
