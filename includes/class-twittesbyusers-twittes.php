<?php


/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to get some twittes.
 *
 * @since      1.0.0
 * @package    Twittesbyusers
 * @subpackage Twittesbyusers/includes
 * @author     Amit Rahav <amit.r.89@gmail.com>
 */
class Twittesbyusers_Twittes {

     /**
     * The Twitter Endpoint
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $endpoint
     */
    protected $endpoint;
    
    protected $user_id;
    protected $num_of_posts;


    protected $api_key;
    protected $api_secret;
    
    protected $token;
    
    
    protected $counter;


    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct(){

        $this->endpoint = "https://api.twitter.com/1.1/statuses/user_timeline.json";

        $api_key = get_field('twitter_api_key','option');
        $api_secret = get_field('twitter_api_key_secret','option');
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;

        $this->counter = 0;
        

        $this->authenticate_twitter();

    }

	/**
	 * Authenticate Twitter
	 *  
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function authenticate_twitter() {
        $data = array(
            "grant_type"    => "client_credentials",
        );
        $res = $this->curl_helper('POST', 'https://api.twitter.com/oauth2/token', $data);
        if(isset($res->access_token)){
            $this->token = $res->access_token;
        }else{
            error_log("error at twitter auth");
            error_log(print_r($res,true));
        }
	}

    /**
	 * Get twittes json
	 *  
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
    public function get_twittes($user_id, $num_of_posts, $pager = false){
        $data = array(
            "user_id"    => $user_id,
            "count"      => $num_of_posts,
            "exclude_replies" => true,
            "include_rts"       => true,
            "trim_user"         => true,
        );

        if($pager){
            $data['max_id'] = $pager;
        }

        return $this->curl_helper('GET', $this->endpoint, $data);
        
    }

    /**
	 * Curl for the help
	 *  
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
    public function curl_helper($method, $url, $data){
        $curl = curl_init(); 

        switch ($method){
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));			 					
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        
        // OPTIONS:
        if(!isset($this->token)){
            $bearer = 'Basic ' .base64_encode($this->api_key . ":" . $this->api_secret);
        }else{
            $bearer = 'Bearer ' . $this->token;
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: ". $bearer,
            'Content-Type: application/x-www-form-urlencoded;charset=UTF-8',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){
            error_log("curl connection failed");
            if(curl_error($curl)) {
                error_log(print_r($curl,true));
            }
            die("Connection Failure");
        }
        
        return json_decode($result);
    }

    /**
     * First call from shortcode
     *  
     * Long Description.
     *
     * @since    1.0.0
     */
    public function initialize_shortcode($args){
        
        $twittes = $this->get_twittes($args['user_id'] , $args['num_of_posts'], $args['last_id']);
        $html = $this->html_handle($twittes, $args);
        
        return $html;

    }

    /**
     * Handle html with pagers
     *  
     * Long Description.
     *
     * @since    1.0.0
     */
    public function html_handle($twittes, $args){
        $html = '';
        
        if(!$this->counter && !$args['last_id']){
            $html = $this->print_wrapper_start($twittes[0]);
        }

        if(isset($twittes->errors)){

            error_log(print_r($twittes->errors,true));
            $html .=  _("Plugin error", "feedByUser");

        }else{

            $content = $this->print_content($twittes, $args['user_id']);
            $html .= $content['html'];

            // pager
            if($this->counter < $args['num_of_posts']){
                $args['num_of_posts'] = $args['num_of_posts'] - $this->counter;
                $args['last_id'] = $content['last_id'];
                $html .=  $this->initialize_shortcode($args);
            }
            if($this->counter == $args['num_of_posts']){
                $html .= "</div>";
            }
        }

        return $html;
    }

    /**
     * Open html wrapper tag
     *  
     * Long Description.
     *
     * @since    1.0.0
     */
    public function print_wrapper_start($first_twit){
        $image = isset($first_twit->user->profile_image_url)? $first_twit->user->profile_image_url: '';
        
        $start = "<div class='twitter-wrapper' data-profile='$image'>";
        return $start;
    }


    /**
     * Loop each twit print content
     *  
     * Long Description.
     *
     * @since    1.0.0
     */
    public function print_content($twittes, $user_id){
        $html = '';
        $readmore = _("קראו עוד", "feedByUsers");
        foreach ($twittes as $key => $twit) {
            // Show only my twites
            $self = !$twit->is_quote_status;
            if($self){
                $url = isset($twit->entities->urls)?$twit->entities->urls: '';
                if($url != '' && count($url) > 0 && isset($url[0]->url)){
                    $url = $url[0]->url;
                    $html .= "<p class='item'> $twit->text <a href='$url'>$readmore</a></p>";
                }else{
                    $html .= "<p class='item'> $twit->text </p>";
                }
                $this->counter++;
            }
        }

        $values = array(
            'html' => $html, 
            'last_id'   => count($twittes) && isset($twittes[count($twittes) - 1])? $twittes[count($twittes) - 1]->id_str : false
        );
        return $values;
    }

}
