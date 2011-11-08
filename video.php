  <?php defined('BASEPATH') OR exit('No direct script access allowed');
  /**
   * video plugin for PyroCMS
   *
   * @package		    PyroCMS-plugins-video
   * @author		    Tim Reynolds
   * @copyright (c) 2011 Tim Reynolds
   *
   */
  class Plugin_Video extends Plugin
  {
  	/**
  	 * youtube - Emeded player
  	 * http://code.google.com/apis/youtube/player_parameters.html
  	 *
  	 * Usage:
  	 * {pyro:video:youtube video_id="abcxyz" maxwidth="300" maxheight="400"}
  	 *
  	 * Example:
  	 * {pyro:video:youtube video_id="4uLSW_hrG9k" maxheight="300" maxwidth="400"}
  	 *
  	 * @return	string
  	 */
  	function youtube()
  	{

  		return $this->oembedLoader($this->attributes(), 
  			'http://www.youtube.com/oembed',
  			'http://youtube.com/watch?v=',
  			'json'
  			);
  	}
  	
    /**
  	 * vimeo - Emeded player
  	 * http://vimeo.com/api/docs/oembed
  	 *
  	 * Usage:
  	 * {pyro:video:vimeo video_id="abcxyz" maxwidth="300" maxheight="400"}
  	 *
  	 * Example
  	 * {pyro:video:vimeo video_id="31395235" maxheight="300" maxwidth="400"}
  	 *
  	 * @return	string
  	 */
  	function vimeo()
  	{

  		return $this->oembedLoader($this->attributes(), 
  			'http://vimeo.com/api/oembed.json',
  			'http://vimeo.com/',
  			'json'
  			);
  	}

  	/**
  	 * bambuser - Emeded player
  	 * http://bambuser.com/api/player_oembed
  	 *
  	 * Usage:
  	 * {pyro:video:bambuser video_id="abcxyz" maxwidth="300" maxheight="400"}
  	 *
  	 * @return	string
  	 */
  	function bambuser()
  	{

  		return $this->oembedLoader($this->attributes(), 
  			'http://api.bambuser.com/oembed.json',
  			'http://bambuser.com/v/',
  			'json'
  			);
  	}

  	/**
  	 * screenr - Emeded player
  	 * http://blog.screenr.com/post/2145539209/screenr-now-supports-oembed
  	 *
  	 * Usage:
  	 * {pyro:video:screenr video_id="abcxyz" maxwidth="300" maxheight="400"}
  	 *
  	 * Example
  	 * {pyro:video:screenr video_id="oXs" maxheight="300" maxwidth="400"}
  	 *
  	 * @return	string
  	 */
  	function screenr()
  	{

  		return $this->oembedLoader($this->attributes(), 
  			'http://www.screenr.com/api/oembed.json',
  			'http://www.screenr.com/',
  			'json'
  			);
  	}

  	/**
  	 * ustream - Emeded player
  	 *
  	 * Usage:
  	 * {pyro:video:ustream video_id="abcxyz" maxwidth="300" maxheight="400"}
  	 *
  	 * Example
  	 * {pyro:video:ustream video_id="insidepoolmag" maxheight="300" maxwidth="400"}
  	 *
  	 * @return	string
  	 */
  	function ustream()
  	{

  		return $this->oembedLoader($this->attributes(), 
  			'http://www.ustream.tv/oembed',
  			'http://www.ustream.tv/',
  			'json'
  			);
  	}

  	  	/**
  	 * qik - Emeded player
  	 *
  	 * Usage:
  	 * {pyro:video:qik video_id="abcxyz" maxwidth="300" maxheight="400"}
  	 *
  	 * Example
  	 * {pyro:video:qik video_id="49565" maxheight="300" maxwidth="400"}
  	 *
  	 * @return	string
  	 */
  	function qik()
  	{

  		return $this->oembedLoader($this->attributes(), 
  			'http://qik.com/api/oembed.json',
  			'http://qik.com/video/',
  			'json'
  			);
  	}

  	/**
  	 * revision3 - Emeded player
  	 *
  	 * Usage:
  	 * {pyro:video:revision3 video_id="abcxyz" maxwidth="300" maxheight="400"}
  	 *
  	 * Example
  	 * {pyro:video:revision3 video_id="trs/uncharted3" maxheight="300" maxwidth="400"}
  	 *
  	 * @return	string
  	 */
  	function revision3()
  	{

  		return $this->oembedLoader($this->attributes(), 
  			'http://revision3.com/api/oembed/',
  			'http://revision3.com/',
  			'json'
  			);
  	}

  	/**
  	 * hulu - Emeded player
  	 *
  	 * Usage:
  	 * {pyro:video:hulu video_id="abcxyz" maxwidth="300" maxheight="400"}
  	 *
  	 * Example
  	 * {pyro:video:hulu video_id="20807/late-night-with-conan-obrien-wed-may-21-2008" maxheight="300" maxwidth="400"}
  	 *
  	 * @return	string
  	 */
  	function hulu()
  	{

  		return $this->oembedLoader($this->attributes(), 
  			'http://www.hulu.com/api/oembed.json',
  			'http://www.hulu.com/watch/',
  			'json'
  			);
  	}

  	private function oembedLoader($attributes, $endpoint, $url, $format) {
  		
  		$video_id = $attributes["video_id"];
		unset($attributes["video_id"]);

		if ($video_id) {

  			$oembed = new SimpleOEmbed_Video($endpoint,
  									$url . $video_id,
  									$format,
  									$attributes
  								);
  			
  			$data = $oembed->getOEmbedObject();

  			return $data->html;
  		}

  	}

  }
  
   /**
   * SimpleOEmbed - OEmbed php wrapper
   *
   * @package		    SimpleOEmbed
   * @author		    Tim Reynolds
   * @copyright (c) 2011 Tim Reynolds
   *
   */

class SimpleOEmbed_Video
{
	
	/**
	 * URL of the oEmbed informaiton object
	 *
	 * @var string oEmbed object url
	 */
	 protected $url = null;

	/**
	 * Endpoint(provider) where the consumer may 
	 * request representations for the URL
	 *
	 * @var string provider endpoint
	 */
	 protected $endpoint = null;

	/**
	 * Provider response format
	 *
	 * @var string response format
	 */
	 protected $format = null;

	/**
	 * Option request params
	 *
	 * @var array
	 */
	 protected $params = array();

	/**
	 * Provider response format
	 *
	 * @param string oEmbed object url
	 * @param string provider endpoint
	 * @param string response format
	 *
	 * @throws Exception if the url or endpoint is not a valid url
	 */
	 public function __construct($endpoint = null, $url = null, $format = null, $params = array())
	 {

	 	if ($endpoint && $url && $format) {

	 		$this->setEndpoint($endpoint);
	 		$this->setUrl($url);
	 		$this->setFormat($format);
	 		$this->setParams($params);
	 	
	 	} else {
	 		
	 		throw new Exception('Required constructor data not provided');
	 	
	 	}

	 }

	/** 
	 * Validate and set the endpoint
	 *
	 * @param string
	 */
	 private function setEndpoint($endpoint)
	 {
	 	if(!$this->validUrl($endpoint)) {

	 	    throw new Exception('Invalid endpoint provided');

	 	}

	 	$this->endpoint = $endpoint;
	 }

	/** 
	 * Validate and set the url
	 * @param string
	 */
	 private function setUrl($url)
	 {
	 	if(!$this->validUrl($url)) {

	 	    throw new Exception('Invalid URL provided');

	 	}

	 	$this->url = $url;
	 }

	 private function setFormat($format)
	 {
	 	$this->format = $format;
	 }

	 private function setParams($params)
	 {
	 	if(!is_array($params)) {

	 	    throw new Exception('Invalid Params, array required');

	 	}

	 	$this->params = $params;
	 }

	/**
	 * Validate url string 
	 *
	 * @param string
	 */
	 private function validUrl($url)
	 {
	 	return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
	 }

	 /**
	  * Generate the request URL using 
	  */
	 private function getOEmbedUrl()
	 {
	 	return $this->endpoint . "?url=" . $this->url . "&format=" . $this->format . "&" . http_build_query($this->params);
	 }

	 private function sendOEmbedRequest($url)
	 {
	 	$curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array());
        curl_setopt($curl, CURLOPT_POSTFIELDS, null);

	 	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
	 	curl_setopt($curl, CURLOPT_URL, $url);

	 	$data = curl_exec($curl);

	 	if (!$data) {

            $errorMsg = curl_error($curl);
            $errorNo = curl_errno($curl);

            throw new Exception("Unable to retrive data, curl error" . $errorMsg);
        }

        $curlInfo = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (200 > $curlInfo || $curlInfo >= 300) {

            throw new Exception("Non-2xx HTTP code returned");
        	
   		}

        curl_close($curl);

	 	return $data;
	 }

	 public function getOEmbedObject()
	 {

	 	$url = $this->getOEmbedUrl();

	 	$data = $this->sendOEmbedRequest($url);

	 	switch ($this->format) {

	 		case 'json':
	 			
	 			$data = json_decode($data);
	 			
	 			if (!is_object($data)) {
                	throw new Exception("Unable to parse json response");
                }

	 		break;

	 		case 'xml':
	 			
	 			libxml_use_internal_errors(true);
                $data = simplexml_load_string($data);
                
                if (!$data instanceof SimpleXMLElement) {
                    
                    $errors = libxml_get_errors();
                    $error  = array_shift($errors);
                    
                    libxml_clear_errors();
                    libxml_use_internal_errors(false);
                    
                   	throw new Exception("Unable to parse xml response");;
                }

	 		break;
	 		
	 	}

	 	return $data;

	 }
}
/* End of file video.php */