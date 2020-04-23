<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/amitrahav
 * @since      1.0.0
 *
 * @package    feed_by_user
 * @subpackage feed_by_user/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    feed_by_user
 * @subpackage feed_by_user/admin
 * @author     Amit Rahav <amit.r.89@gmail.com>
 */
class Feed_By_User_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Feed_By_User_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Feed_By_User_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/feed_by_user-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Feed_By_User_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Feed_By_User_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/feed_by_user-admin.js', array( 'jquery' ), $this->version, false );

	}

    /**
	 * Register the ACF option page.
	 *
	 * @since    1.0.0
	 */
    public function acf_option_page(){
        $option_page = acf_add_options_page(array(
            'page_title'    => __('Twitter Settings'),
            'menu_title'    => __('Twitter Settings'),
            'menu_slug'     => 'twitter_settings',
            'capability'    => 'edit_posts',
            'redirect'      => false
        ));

        acf_add_local_field_group(array(
            'key' => 'group_5e9c788bb363c',
            'title' => 'General Feed Options',
            'fields' => array(
                array(
                    'key' => 'twitter_api_key',
                    'label' => 'Twitter Api Key',
                    'name' => 'twitter_api_key',
                    'type' => 'password',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '50%',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'twitter_api_key_secret',
                    'label' => 'Twitter Api Secret',
                    'name' => 'twitter_api_key_secret',
                    'type' => 'password',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5e9c78c5e1db4',
                    'label' => 'YouTube Api Key',
                    'name' => 'youtube_api_key',
                    'type' => 'password',
                    'instructions' => 'Get a key @ https://console.developers.google.com/apis/api/youtube.googleapis.com',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'youtube_video_settings',
                    'label' => 'YouTube Settings',
                    'name' => 'youtube_video_settings',
                    'type' => 'repeater',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'collapsed' => 'youtube_account',
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'table',
                    'button_label' => 'Add Account',
                    'sub_fields' => array(
                        array(
                            'key' => 'youtube_account',
                            'label' => 'YouTube Channel ID',
                            'name' => 'youtube_account',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '70',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'number_of_videos',
                            'label' => 'Number Of Videos',
                            'name' => 'number_of_videos',
                            'type' => 'number',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => 15,
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'min' => 1,
                            'max' => 100,
                            'step' => '',
                        ),
                    ),
                ),
                array(
                    'key' => 'field_5e985426d0976',
                    'label' => 'Twitter Settings',
                    'name' => 'twitter_settings',
                    'type' => 'repeater',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'collapsed' => 'field_5e985493d0977',
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'table',
                    'button_label' => 'Add Acount',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_5e985493d0977',
                            'label' => 'Twitter Account ID',
                            'name' => 'twitter_account',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '70',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5e9854ecd0978',
                            'label' => 'Number Of tweets',
                            'name' => 'number_of_tweets',
                            'type' => 'number',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => 15,
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'min' => 1,
                            'max' => 100,
                            'step' => '',
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'twitter_settings',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));

    }


    public function shortcode_twitter_as_json($atts) {

        $args = shortcode_atts( array(
            'user_id' => 1082167187006242817,
            'num_of_posts' => 15,
            'last_id'  => 0
        ), $atts );

        $twitter_wrapper = new Feed_By_User_tweets();        
        $html = $twitter_wrapper->initialize_shortcode($args);

        echo $html;
    }


    public function shortcode_tube_videos_as_json($atts) {
        
        $args = shortcode_atts( array(
            'channel_id' => 'UCwf8d-hDrt3OXBoSMQuc4kQ',
            'num_of_videos' => 15
        ), $atts );

        $tube_wrapper = new Feed_By_User_Tube();
        $videos = $tube_wrapper->get_videos($args['channel_id'], $args['num_of_videos'])->items;
        $title = isset($videos[0]->snippets)? $videos[0]->snippets->channelTitle: '';

        $html = '';

        $html .= "<div class='tube-wrapper' data-channel_title='$title'>";
        foreach ($videos as $key => $video) {
            $thumbnail = $video->snippet->thumbnails->high->url;
            $html .= '<div class="item open-video wow fadeInUp" data-id="'.$video->id->videoId.'">';
                $html .= '<div class="image-wrapper">';
                    $html .= '<div class="image bg" style="background: url('. $thumbnail.')"></div>';
                    $html .= '<i class="fas fa-play" aria-hidden="true"></i>';
                $html .= '</div>';
                $html .= '<div class="text">';
                    $html .= '<h3>'. $video->snippet->title.'</h3>';
                $html .= '</div>';
            $html .= '</div>';
        }
        $html .= "</div>";

        echo $html;
    }


}
