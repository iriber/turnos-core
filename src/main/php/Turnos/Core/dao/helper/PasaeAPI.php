<?php

namespace Turnos\Core\dao\helper;

use Cose\Utils\Logger;

/*
 * 
 *  Class to integrate with Twitter's API.
 *    Authenticated calls are done using OAuth and require access tokens for a user.
 *    API calls which do not require authentication do not require tokens (i.e. search/trends)
 * 
 *  Full documentation available on github
 *    http://wiki.github.com/jmathai/twitter-async
 * 
 *  @author Jaisen Mathai <jaisen@jmathai.com>
 */
class PasaeAPI 
{
  const PASAE_SIGNATURE_METHOD = 'HMAC-SHA1';
  const PASAE_AUTH_OAUTH = 'oauth';
  const PASAE_AUTH_BASIC = 'basic';
  protected $apiUrl         = 'http://localhost:8080/cdtCuentasCore/rest';
  protected $apiVersion     = '';
  protected $isAsynchronous = false;
  protected $userAgent = 'PHP para PASAE';
  
  protected $callback;
  protected $followLocation = false;
  protected $headers = array();
  protected $connectionTimeout = 5;
  protected $requestTimeout = 30;
  protected $signatureMethod;
  protected $debug = false;
  protected $useSSL = false;
    
  protected $curl = false;

  public function __construct(){
  	$this->curl = Curl::getInstance();
  }
  
   /* OAuth methods */
  public function delete($endpoint, $params = null)
  {
    return $this->request('DELETE', $endpoint, $params);
  }

  public function get($endpoint, $params = null)
  {
  	
  	Logger::log("PasaeAPI get " . $endpoint, __CLASS__ );
  	
  	$myParams = array();
  	$myParams["request"] = $params ;
    return $this->request('GET', $endpoint, $myParams);
  }

  public function post($endpoint, $params = null)
  {
  	$myParams = array();
  	$myParams["request"] = $params ;
    return $this->request('POST', $endpoint, $myParams);
  }

  /* Basic auth methods */
  public function delete_basic($endpoint, $params = null, $username = null, $password = null)
  {
    return $this->request_basic('DELETE', $endpoint, $params, $username, $password);
  }

  public function get_basic($endpoint, $params = null, $username = null, $password = null)
  {
    return $this->request_basic('GET', $endpoint, $params, $username, $password);
  }

  public function post_basic($endpoint, $params = null, $username = null, $password = null)
  {
    return $this->request_basic('POST', $endpoint, $params, $username, $password);
  }

  public function useApiVersion($version = null)
  {
    $this->apiVersion = $version;
  }

  public function useAsynchronous($async = true)
  {
    $this->isAsynchronous = (bool)$async;
  }

//  public function __construct($consumerKey = null, $consumerSecret = null, $oauthToken = null, $oauthTokenSecret = null)
//  {
//    parent::__construct($consumerKey, $consumerSecret, self::PASAE_SIGNATURE_METHOD);
//    $this->setToken($oauthToken, $oauthTokenSecret);
//  }
  
  public function __call($name, $params = null/*, $username, $password*/)
  {
    $parts  = explode('_', $name);
    $method = strtoupper(array_shift($parts));
    $parts  = implode('_', $parts);
    $endpoint   = '/' . preg_replace('/[A-Z]|[0-9]+/e', "'/'.strtolower('\\0')", $parts) . '.json';
    /* HACK: this is required for list support that starts with a user id */
    $endpoint = str_replace('//','/',$endpoint);
    $args = !empty($params) ? array_shift($params) : null;

    // calls which do not have a consumerKey are assumed to not require authentication
    $username = null;
    $password = null;

    return $this->request_basic($method, $endpoint, $args, $username, $password);
  }

  private function getApiUrl($endpoint)
  {
//    if(preg_match('@^/search[./]?(?=(json|daily|current|weekly))@', $endpoint))
//      return "{$this->searchUrl}{$endpoint}";
//    elseif(!empty($this->apiVersion))
//      return "{$this->apiVersionedUrl}/{$this->apiVersion}{$endpoint}";
//    else
//      return "{$this->apiUrl}{$endpoint}";
		return $this->apiUrl . "$endpoint";
  }

  private function request($method, $endpoint, $params = null)
  {
    //$url = $this->getUrl($this->getApiUrl($endpoint));
    $url = $this->getApiUrl($endpoint);
    
    
    $response =  call_user_func(array($this, 'httpRequest'), $method, $url, $params, $this->isMultipart($params));
    
   // $response = $this->htt call_user_func(array($this, 'httpRequest'), $method, $url, $params, $this->isMultipart($params) );
    
    $resp= new TwitterJson( $response, $this->debug);
    if(!$this->isAsynchronous)
      $resp->response;

    return $resp;
  }

  public function request_basic($method, $endpoint, $params = null, $username = null, $password = null)
  {
    $url = $this->getApiUrl($endpoint);
    if($method === 'GET')
      $url .= is_null($params) ? '' : '?'.http_build_query($params, '', '&');
    $ch  = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, $this->requestTimeout);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    if($method === 'POST' && $params !== null)
    {
      if($this->isMultipart($params))
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
      else
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->buildHttpQueryRaw($params));
    }
    if(!empty($username) && !empty($password))
      curl_setopt($ch, CURLOPT_USERPWD, "{$username}:{$password}");

    $resp = new TwitterJson(Curl::getInstance()->addCurl($ch), $this->debug);
    if(!$this->isAsynchronous)
      $resp->response;

    return $resp;
  }
  
public function httpRequest($method = null, $url = null, $params = null, $isMultipart = false)
  {
    if(empty($method) || empty($url))
      return false;

    //if(empty($params['oauth_signature']))
   //   $params = $this->prepareParameters($method, $url, $params);
	Logger::log("PasaeAPI httpRequest " . $method . " " . $url, __CLASS__ );

    switch($method)
    {
      case 'GET':
        return $this->httpGet($url, $params);
        break;
      case 'POST':
        return $this->httpPost($url, $params, $isMultipart);
        break;
      case 'DELETE':
        return $this->httpDelete($url, $params);
        break;

    }
  }
  
	
  protected function isMultipart($params = null)
  {
    if($params)
    {
      foreach($params as $k => $v)
      {
        if(strncmp('@',$k,1) === 0)
          return true;
      }
    }
    return false;
  }
  
  protected function prepareParameters($method = null, $url = null, $params = null)
  {
    if(empty($method) || empty($url))
      return false;

    $oauth =array();
    
//    $oauth['oauth_consumer_key'] = $this->consumerKey;
//    $oauth['oauth_token'] = $this->token;
//    $oauth['oauth_nonce'] = $this->generateNonce();
//    $oauth['oauth_timestamp'] = !isset($this->timestamp) ? time() : $this->timestamp; // for unit test
//    $oauth['oauth_signature_method'] = $this->signatureMethod;
//    if(isset($params['oauth_verifier']))
//    {
//      $oauth['oauth_verifier'] = $params['oauth_verifier'];
//      unset($params['oauth_verifier']);
//    }
//    $oauth['oauth_version'] = $this->version;
//    // encode all oauth values
//    foreach($oauth as $k => $v)
//      $oauth[$k] = $this->encode_rfc3986($v);
    // encode all non '@' params
    // keep sigParams for signature generation (exclude '@' params)
    // rename '@key' to 'key'
    $sigParams = array();
    $hasFile = false;
    if(is_array($params))
    {
      foreach($params as $k => $v)
      {
        if(strncmp('@',$k,1) !== 0)
        {
          $sigParams[$k] = $this->encode_rfc3986($v);
          $params[$k] = $this->encode_rfc3986($v);
        }
        else
        {
          $params[substr($k, 1)] = $v;
          unset($params[$k]);
          $hasFile = true;
        }
      }
      
      if($hasFile === true)
        $sigParams = array();
    }

    $sigParams = array_merge($oauth, (array)$sigParams);

    // sorting
    ksort($sigParams);

    // signing
    $oauth['oauth_signature'] = $this->encode_rfc3986($this->generateSignature($method, $url, $sigParams));
    return array('request' => $params, 'oauth' => $oauth);
  }
  
  protected function httpDelete($url, $params) {
      $this->addDefaultHeaders($url, $params['oauth']);
      $ch = $this->curlInit($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
      curl_setopt($ch, CURLOPT_POSTFIELDS, $this->buildHttpQueryRaw($params['request']));
      $resp = $this->executeCurl($ch);
      $this->emptyHeaders();
      return $resp;
  }

  protected function httpGet($url, $params = null)
  {
    if(count($params['request']) > 0)
    {
      $url .= '?';
      foreach($params['request'] as $k => $v)
      {
        $url .= "{$k}={$v}&";
      }
      $url = substr($url, 0, -1);
    }
    $this->addDefaultHeaders($url);
    $ch = $this->curlInit($url);
    $resp = $this->executeCurl($ch);
    $this->emptyHeaders();

    return $resp;
  }

  protected function httpPost($url, $params = null, $isMultipart)
  {
    $this->addDefaultHeaders($url);
    $ch = $this->curlInit($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    // php's curl extension automatically sets the content type
    // based on whether the params are in string or array form
    if($isMultipart)
      curl_setopt($ch, CURLOPT_POSTFIELDS, $params['request']);
    else
      curl_setopt($ch, CURLOPT_POSTFIELDS, $this->buildHttpQueryRaw($params['request']));
    $resp = $this->executeCurl($ch);
    $this->emptyHeaders();

    return $resp;
  }
  
  protected function buildHttpQueryRaw($params)
  {
    $retval = '';
    foreach((array)$params as $key => $value)
      $retval .= "{$key}={$value}&";
    $retval = substr($retval, 0, -1);
    return $retval;
  }
  
  protected function addDefaultHeaders($url)
  {
    $_h = array('Expect:');
    $urlParts = parse_url($url);
    $scheme = isset($urlParts['scheme'])? strtolower($urlParts['scheme']):"http";
    $host   = isset($urlParts['host'] )?strtolower($urlParts['host']):"localhost";
    $port = isset($urlParts['port']) ? intval($urlParts['port']) : 8080;
    
    //$oauth = 'Authorization: OAuth realm="' . $scheme . '://' . $host . $urlParts['path'] . '",';
//    foreach($oauthHeaders as $name => $value)
//    {
//      $oauth .= "{$name}=\"{$value}\",";
//    }
//    $_h[] = substr($oauth, 0, -1);
    $_h[] = "User-Agent: {$this->userAgent}";
    
    $_h[] = "Accept: application/json";
    
    $credentials = base64_encode("iriber:123456");
    $_h[] = "Authorization: Basic $credentials";
    
    $this->addHeader($_h);
  }

  public function addHeader($header)
  {
    if(is_array($header) && !empty($header))
      $this->headers = array_merge($this->headers, $header);
    elseif(!empty($header))
      $this->headers[] = $header;
  }
  protected function curlInit($url)
  {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers); 
    curl_setopt($ch, CURLOPT_TIMEOUT, $this->requestTimeout);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connectionTimeout);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    if($this->followLocation)
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    if(isset($_SERVER ['SERVER_ADDR']) && !empty($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR'] != '127.0.0.1')
      curl_setopt($ch, CURLOPT_INTERFACE, $_SERVER ['SERVER_ADDR']);

    // if the certificate exists then use it, else bypass ssl checks
    if(file_exists($cert = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'ca-bundle.crt'))
    {
      curl_setopt($ch, CURLOPT_CAINFO, $cert);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    }
    else
    {
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }
    return $ch;
  }

  protected function emptyHeaders()
  {
    $this->headers = array();
  }

  protected function encode_rfc3986($string)
  {
    return str_replace('+', ' ', str_replace('%7E', '~', rawurlencode(($string))));
  }

  protected function executeCurl($ch)
  {
    if($this->isAsynchronous)
      return $this->curl->addCurl($ch);
    else
      return $this->curl->addEasyCurl($ch);
  }
  
}

class TwitterJson implements \ArrayAccess, \Countable, \IteratorAggregate
{
  private $debug;
  private $__resp;
  public function __construct($response, $debug = false)
  {
    $this->__resp = $response;
    $this->debug  = $debug;
    
  }

  // ensure that calls complete by blocking for results, NOOP if already returned
  public function __destruct()
  {
    $this->responseText;
  }

  // Implementation of the IteratorAggregate::getIterator() to support foreach ($this as $...)
  public function getIterator ()
  {
    if ($this->__obj) {
      return new ArrayIterator($this->__obj);
    } else {
      return new ArrayIterator($this->response);
    }
  }

  // Implementation of Countable::count() to support count($this)
  public function count ()
  {
    return count($this->response);
  }
  
  // Next four functions are to support ArrayAccess interface
  // 1
  public function offsetSet($offset, $value) 
  {
    $this->response[$offset] = $value;
  }

  // 2
  public function offsetExists($offset) 
  {
    return isset($this->response[$offset]);
  }
  
  // 3
  public function offsetUnset($offset) 
  {
    unset($this->response[$offset]);
  }

  // 4
  public function offsetGet($offset) 
  {
    return isset($this->response[$offset]) ? $this->response[$offset] : null;
  }

  public function __get($name)
  {
    $accessible = array('responseText'=>1,'headers'=>1,'code'=>1);
    $this->responseText = $this->__resp->data;
    $this->headers      = $this->__resp->headers;
    $this->code         = $this->__resp->code;
    if(isset($accessible[$name]) && $accessible[$name])
      return $this->$name;
    elseif(($this->code < 200 || $this->code >= 400) && !isset($accessible[$name]))
      TwitterException::raise($this->__resp, $this->debug);

    // Call appears ok so we can fill in the response
    $this->response     = json_decode($this->responseText, 1);
    $this->__obj        = json_decode($this->responseText);

    if(gettype($this->__obj) === 'object')
    {
      foreach($this->__obj as $k => $v)
      {
        $this->$k = $v;
      }
    }

    if (property_exists($this, $name)) {
      return $this->$name;
    }
    return null;
  }

  public function __isset($name)
  {
    $value = self::__get($name);
    return !empty($name);
  }
  
  
  
}

class TwitterException extends \Exception 
{
  public static function raise($response, $debug)
  {
    //$message = $response->data;
    $error = json_decode( $response->data );
    $message = "PASAE - " .  $error->error;
    switch($response->code)
    {
      case 400:
        throw new TwitterRateLimitException($message, $response->code);
      case 401:
        throw new TwitterNotAuthorizedException($message, $response->code);
      case 403:
        throw new TwitterForbiddenException($message, $response->code);
      case 404:
        throw new TwitterNotFoundException($message, $response->code);
      case 406:
        throw new TwitterNotAcceptableException($message, $response->code);
      case 420:
        throw new TwitterEnhanceYourCalmException($message, $response->code);
      case 500:
        throw new TwitterInternalServerException($message, $response->code);
      case 502:
        throw new TwitterBadGatewayException($message, $response->code);
      case 503:
        throw new TwitterServiceUnavailableException($message, $response->code);
      default:
        throw new TwitterException($message, $response->code);
    }
  }
}
class TwitterBadRequestException extends TwitterException{}
class TwitterNotAuthorizedException extends TwitterException{}
class TwitterForbiddenException extends TwitterException{}
class TwitterNotFoundException extends TwitterException{}
class TwitterNotAcceptableException extends TwitterException{}
class TwitterEnhanceYourCalmException extends TwitterException{}
class TwitterInternalServerException extends TwitterException{}
class TwitterBadGatewayException extends TwitterException{}
class TwitterServiceUnavailableException extends TwitterException{}
class TwitterRateLimitException extends TwitterException{}