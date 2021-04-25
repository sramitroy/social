<?php

namespace Soft;

/**
* Simple implementation of all the Google accounts
* @aameetroy@gmail.com
*/
class Google
{
    
    public $client_id; 
    public $redirect_uri; 
    public $client_secret; 
    public $response_type;
    public $access_type; 
    public $grant_type;
    public static $oauth2Url   = 'https://accounts.google.com/o/oauth2/v2/auth';
    public static $oauth2TokenUrl = 'https://www.googleapis.com/oauth2/v4/token';
    public static $userinfoUrl = 'https://www.googleapis.com/oauth2/v2/userinfo';
    public $scopes;
    /**
     * Create a new controller instance.
     *$client_id, $redirect_uri, $client_secret, $response_type="code",$access_type = "online"
     * @return void
     */
    public function __construct($credentials=array())
    {
          $this->client_id     = (isset($credentials['client_id']) && $credentials['client_id']!='')?$credentials['client_id'] : '';
          $this->redirect_uri  = (isset($credentials['redirect_uri'])&&$credentials['redirect_uri']!='')?$credentials['redirect_uri']:'';
          $this->client_secret = (isset($credentials['client_secret']) && $credentials['client_secret']!='')?$credentials['client_secret']:'';
          $this->response_type = (isset($credentials['response_type']) && $credentials['response_type']!='')?$credentials['response_type']:'code';
          $this->access_type   = (isset($credentials['access_type']) && $credentials['access_type']!='')?$credentials['access_type']:'online';
          $this->grant_type    = (isset($credentials['grant_type']) && $credentials['grant_type']!='')?$credentials['grant_type']:'authorization_code';
          $this->scopes        = (isset($credentials['scopes']) && $credentials['scopes']!='')?$credentials['scopes']:'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email';
    }//END METHOD 

    /**
     * @getGoogleLogInUr
     * @return string Returns the phrase passed in
     */
    public function LogInUr()
    {   
        $oauth2Url     = self::$oauth2Url;
        $response_type = $this->response_type;
        $access_type   = $this->access_type;
        $client_id     = $this->client_id;
        $scopes        = $this->scopes;
        $redirect_uri  = $this->redirect_uri;

        $loginUrl = $oauth2Url."?response_type=".$response_type."&access_type=".$access_type."&client_id=".$client_id."&scope=".$scopes."&redirect_uri=".$redirect_uri."";

        return $loginUrl;
    }//END METHOD


    /**
     * @getAccessToken
     * @return string Returns the phrase passed in
     */
    public function AccessToken($code='')
    {
        $oauth2TokenUrl= self::$oauth2TokenUrl;
        $client_secret = $this->client_secret;
        $client_id     = $this->client_id;
        $scopes        = $this->scopes;
        $redirect_uri  = $this->redirect_uri;          
        $grant_type    = $this->grant_type;          
        
        $curlPost = 'client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&client_secret=' . $client_secret . '&code='. $code . '&grant_type='.$grant_type;
        $ch = curl_init();      
        curl_setopt($ch, CURLOPT_URL, $oauth2TokenUrl);        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        
        curl_setopt($ch, CURLOPT_POST, 1);      
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);    
        $data = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);      
        if($http_code != 200) 
            die('Error : Failed to receieve access token');
            
        return $data;
    }//END METHOD


    /**
     * @getAccessToken
     * @return string Returns the phrase passed in
     */
    public function UserProfile($access_token='',$fields=array())
    {
             
        $userinfoUrl   = self::$userinfoUrl;          
        $fields        = implode(',', $fields);

        $url = $userinfoUrl.'?fields='.$fields;          
        
        $ch = curl_init();      
        curl_setopt($ch, CURLOPT_URL, $url);        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token));
        $data = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);     
        if($http_code != 200) 
            die('Error : Failed to get user information');
            
        return $data;
    }//END METHOD
}
