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
class Twittesbyusers_Tube {

     /**
     * The Twitter Endpoint
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $endpoint
     */
    protected $endpoint;

    protected $api_key;


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

        $this->api_key = get_field('youtube_api_key','option');
        $this->endpoint = "https://www.googleapis.com/youtube/v3/search";
    }


    public function get_videos($channel_id, $num_of_videos){
        $data = array(
            "channelId"     => $channel_id,
            "maxResults"    => $num_of_videos,
            "part"          => "snippet,id",
            "key"           =>  $this->api_key,
            "order"         => "date"
        );

        return $this->curl_helper('GET', $this->endpoint, $data);
        
    }

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
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

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

}
