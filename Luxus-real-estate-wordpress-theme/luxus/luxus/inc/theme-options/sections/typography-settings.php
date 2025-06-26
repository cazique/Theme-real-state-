<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

//---------------------
// Typography Section
//---------------------
CSF::createSection( $prefix, array(
  'title'  => esc_html__( 'Typography', 'luxus' ),
  'fields' => array(

    // Body Font
    array(
      'id'      => 'body-font',
      'type'    => 'typography',
      'title'   => esc_html__( 'Body Font', 'luxus' ),
      'output'  => 'body',
      'color'  => false,
      'default' => array(
        'font-family'    => 'Roboto',
        'font-size'      => '16',
        'font-weight'    => 400,
        'line-height'    => '24',
        'letter-spacing' => '0',
        'text-align'     => '',
        'text-transform' => '',
        'subset'         => '',
        'type'           => 'google',
        'unit'           => 'px',
      ),
    ),

    // Heading 1
    array(
      'id'      => 'theme-font-h1',
      'type'    => 'typography',
      'title'   => esc_html__( 'Heading 1', 'luxus' ),
      'output'  => 'h1',
      'default' => array(
        'color'          => '#00072D',
        'font-family'    => 'Inter',
        'font-size'      => '44',
        'font-weight'    => 700,
        'line-height'    => '50',
        'letter-spacing' => '0',
        'text-align'     => '',
        'text-transform' => '',
        'subset'         => '',
        'type'           => 'google',
        'unit'           => 'px',
      ),
    ),

    // Heading 2
    array(
      'id'      => 'theme-font-h2',
      'type'    => 'typography',
      'title'   => esc_html__( 'Heading 2', 'luxus' ),
      'output'  => 'h2',
      'default' => array(
        'color'          => '#00072D',
        'font-family'    => 'Inter',
        'font-size'      => '34',
        'font-weight'    => 700,
        'line-height'    => '44',
        'letter-spacing' => '0',
        'text-align'     => '',
        'text-transform' => '',
        'subset'         => '',
        'type'           => 'google',
        'unit'           => 'px',
      ),
    ),

    // Heading 3
    array(
      'id'      => 'theme-font-h3',
      'type'    => 'typography',
      'title'   => esc_html__( 'Heading 3', 'luxus' ),
      'output'  => 'h3',
      'default' => array(
        'color'          => '#00072D',
        'font-family'    => 'Inter',
        'font-size'      => '28',
        'font-weight'    => 700,
        'line-height'    => '38',
        'letter-spacing' => '0',
        'text-align'     => '',
        'text-transform' => '',
        'subset'         => '',
        'type'           => 'google',
        'unit'           => 'px',
      ),
    ),

    // Heading 4
    array(
      'id'      => 'theme-font-h4',
      'type'    => 'typography',
      'title'   => esc_html__( 'Heading 4', 'luxus' ),
      'output'  => 'h4',
      'default' => array(
        'color'          => '#00072D',
        'font-family'    => 'Inter',
        'font-size'      => '24',
        'font-weight'    => 700,
        'line-height'    => '34',
        'letter-spacing' => '0',
        'text-align'     => '',
        'text-transform' => '',
        'subset'         => '',
        'type'           => 'google',
        'unit'           => 'px',
      ),
    ),

    // Heading 5
    array(
      'id'      => 'theme-font-h5',
      'type'    => 'typography',
      'title'   => esc_html__( 'Heading 5', 'luxus' ),
      'output'  => 'h5',
      'default' => array(
        'color'          => '#00072D',
        'font-family'    => 'Inter',
        'font-size'      => '20',
        'font-weight'    => 700,
        'line-height'    => '28',
        'letter-spacing' => '0',
        'text-align'     => '',
        'text-transform' => '',
        'subset'         => '',
        'type'           => 'google',
        'unit'           => 'px',
      ),
    ),

    // Heading 6
    array(
      'id'      => 'theme-font-h6',
      'type'    => 'typography',
      'title'   => esc_html__( 'Heading 6', 'luxus' ),
      'output'  => 'h6',
      'default' => array(
        'color'          => '#00072D',
        'font-family'    => 'Inter',
        'font-size'      => '18',
        'font-weight'    => 700,
        'line-height'    => '26',
        'letter-spacing' => '0',
        'text-align'     => '',
        'text-transform' => '',
        'subset'         => '',
        'type'           => 'google',
        'unit'           => 'px',
      ),
    ),

  )
) );