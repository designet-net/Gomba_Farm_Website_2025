<?php
/**
 * Info Admin Menu
 */
if ( ! class_exists( 'Spike_Business_Theme_Info' ) ) {
    class Spike_Business_Theme_Info{

        private $config;
        private $theme_name;
        private $theme_slug;
        private $theme_version;
        private $page_title;

        /**
         * Constructor.
         */
        public function __construct( $config ) {
            $this->config = $config;
            $this->prepare_class();

            /* Admin menu */
            add_action( 'admin_menu', array( $this, 'spike_business_admin_menu' ) );

            /* Enqueue script and style for about page */
            add_action( 'admin_enqueue_scripts', array( $this, 'style_and_scripts' ) );
        }

        /**
         * Prepare and setup class properties.
         */
        public function prepare_class() {
            $theme = wp_get_theme();
            $this->theme_name    = esc_attr( $theme->get( 'Name' ) );
            $this->theme_slug    = $theme->get_template();
            $this->theme_version = $theme->get( 'Version' );
            $this->page_title    = $this->theme_name . esc_html__( ' Info', 'spike-business' );
        }
        
        /**
         * Adding Theme Info Menu under Appearance.
         */
        function spike_business_admin_menu() {
            if ( ! empty( $this->page_title ) ) {
                add_theme_page( $this->page_title, esc_html__( 'Spike Business Theme', 'spike-business' ), 'edit_theme_options', $this->theme_slug . '-info', array(
                    $this,
                    'spike_business_theme_info_screen',
                ) );
            }
        }

        /**
         * Render the info content screen.
         */
        public function spike_business_theme_info_screen() {

            $theme_name_config = esc_attr ( wp_get_theme()->get('Name') );
            $theme_name_config_url = strtolower( str_replace( ' ', '-', $theme_name_config ) );

            if ( ! empty( $this->config[ 'info_title' ] ) ) {
                $welcome_title = $this->config[ 'info_title' ];
            }
            if ( ! empty( $this->config[ 'info_content' ] ) ) {
                $welcome_content = $this->config[ 'info_content' ];
            }
            if ( ! empty( $this->config[ 'quick_links' ] ) ) {
                $quick_links = $this->config[ 'quick_links' ];
            }

            if (
                ! empty( $welcome_title ) ||
                ! empty( $welcome_content ) ||
                ! empty( $quick_links )
            ) {
                echo '<div class="wrap about-wrap info-wrap epsilon-wrap">';
                echo '<div class="header-wrap display-grid col-grid-2 align-center">';
                echo '<div class="theme-detail col">';

                if ( ! empty( $welcome_title ) ) {
                    echo '<h1>';
                    echo esc_html( $welcome_title );
                    if ( ! empty( $this->theme_version ) ) {
                        echo esc_html( $this->theme_version );
                    }
                    echo '</h1>';
                }
                if ( ! empty( $welcome_content ) ) {
                    echo '<div class="about-text">' . wp_kses_post( $welcome_content ) . '</div>';
                }

                /*quick links*/
                if( !empty( $quick_links ) && is_array( $quick_links ) ){
                    echo '<p class="quick-links">';
                    foreach ( $quick_links as $quick_key => $quick_link ) {
                        $button = 'button button-primary button-hero';
                        echo '<a href="'.esc_url( $quick_link['url'] ).'" class="button button-hero '.esc_attr( $button ).'" target="_blank">'.esc_html( $quick_link['text'] ).'</a>';
                    }
                    echo "</p>";
                }
                echo '</div>';
                echo '<div class="theme-img col">';
                echo '<a href="' . esc_url( 'https://kortezthemes.com/spike-business-pro/' ).'" target="_blank">';
                echo '<img src="' . esc_url( get_template_directory_uri() . "/screenshot.png" ) . '" alt="screenshot" />';
                echo '</a>';
                echo '</div>';
                echo '</div>';
                echo '</div><!--/.wrap.about-wrap-->';
            }
        }

        /**
         * Load css and scripts for the theme info page
         */
        public function style_and_scripts() {
            wp_enqueue_style( 'spike-business-theme-info-css', get_template_directory_uri() . '/inc/admin/info.css' );

        }
    }
}

$theme_name_config = esc_attr ( wp_get_theme()->get('Name') );
$theme_name_config_url = strtolower( str_replace( ' ', '-', $theme_name_config ) );

$config = array(

    // Main welcome title
    'info_title' => sprintf( esc_html__( 'Welcome to %s - ', 'spike-business' ), $theme_name_config ),

    // Main welcome content
    'info_content' => sprintf( esc_html__( 'Spike Business Pro offers more features and enhances your experience!', 'spike-business' ), '<b>'.$theme_name_config.'</b>' ),

    /**
     * Quick links
     */
    'quick_links' => array(
        'theme_url'  => array(
            'text' => __( 'Buy Pro', 'spike-business' ),
            'url' => 'https://kortezthemes.com/spike-business-pro/'
        )
    ),
);

return new Spike_Business_Theme_Info( $config );