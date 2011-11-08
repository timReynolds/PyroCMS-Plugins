  <?php defined('BASEPATH') OR exit('No direct script access allowed');
  /**
   * image plugin for PyroCMS
   *
   * @package		    PyroCMS-plugins-video
   * @author		    Tim Reynolds
   * @copyright (c) 2011 Tim Reynolds
   *
   */
  class Plugin_Image extends Plugin
  {
    /**
     * flickr - Emeded image
     *
     * Usage:
     * {pyro:image:flickr image_id="abcxyz" maxwidth="300" maxheight="400"}
     *
     * Example
     * {pyro:image:flickr image_id="luxagraf/137254255/"}
     *
     * @return  string
     */
    function flickr() {
      
      return $this->oembedLoader($this->attributes(), 
        'http://www.flickr.com/services/oembed/',
        'http://flickr.com/photos/',
        'xml'
        );
    }
    
        /**
     * smugmug - Emeded image
     *
     * Usage:
     * {pyro:image:smugmug image_id="abcxyz" maxwidth="300" maxheight="400"}
     *
     * Example
     * {pyro:image:smugmug image_id="popular/all%23125787395_hQSj9"}
     *
     * @return  string
     */
    function smugmug() {
      
      return $this->oembedLoader($this->attributes(), 
        'http://api.smugmug.com/services/oembed/',
        'http://smugmug.com/',
        'json'
        );
    }
    
    /**
     * deviantART - Emeded image
     *
     * Usage:
     * {pyro:image:deviantART image_id="abcxyz" maxwidth="300" maxheight="400"}
     *
     * Example
     * {pyro:image:deviantart image_id="d4fg9lw"}
     *
     * @return  string
     */
    function deviantart() {
      
      return $this->oembedLoader($this->attributes(), 
        'http://backend.deviantart.com/oembed',
        'http://deviantart.com/art/',
        'json'
        );
    }
    
    /**
     * skitch - Emeded image
     *
     * Usage:
     * {pyro:image:skitch image_id="abcxyz" maxwidth="300" maxheight="400"}
     *
     * Example
     * {pyro:image:skitch image_id="talonlzr/6yqb/robert-is-an-fbi-special-agent"}
     *
     * @return  string
     */
    function skitch() {
      
      return $this->oembedLoader($this->attributes(), 
        'http://skitch.com/oembed/',
        'http://skitch.com/',
        'json'
        );
    }
    
    /**
     * yfrog - Emeded image
     *
     * Usage:
     * {pyro:image:yfrog image_id="abcxyz" maxwidth="300" maxheight="400"}
     *
     * Example
     * {pyro:image:yfrog image_id="2pswonj"}
     *
     * @return  string
     */
    function yfrog() {
      
      return $this->oembedLoader($this->attributes(), 
        'http://www.yfrog.com/api/oembed',
        'http://yfrog.com/',
        'json'
        );
    }
    
    private function oembedLoader($attributes, $endpoint, $url, $format) {
      
      $image_id = $attributes["image_id"];
      unset($attributes["image_id"]);

      if ($image_id) {

        $oembed = new SimpleOEmbed_Image($endpoint,
                    $url . $image_id,
                    $format,
                    $attributes
                  );
        
        $data = $oembed->getOEmbedObject();

        return "<img src=" . $data->url . " alt=" . $data->title . " />";
      }

    }


  }

   /**
   * SimpleOEmbed - OEmbed php wrapper
   *
   * @package       SimpleOEmbed
   * @author        Tim Reynolds
   * @copyright (c) 2011 Tim Reynolds
   *
   */

class SimpleOEmbed_Image
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

echo $url;
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

  /* End of file image.php */