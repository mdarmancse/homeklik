<?php
//
//
//namespace App\Libraries\OAuth2;
//
//use CodeIgniter\HTTP\RequestInterface;
//use CodeIgniter\HTTP\ResponseInterface;
//use League\OAuth2\Client\Provider\Google as GoogleProvider;
//
//class GoogleOAuth2
//{
//    protected $request;
//    protected $response;
//    protected $client;
//
//    public function __construct(RequestInterface $request, ResponseInterface $response)
//    {
//        $this->request = $request;
//        $this->response = $response;
//
//        $this->client = new GoogleProvider([
//            'clientId' => '1079344059155-jacioss316ob1ejjp4evh262oldcurbk.apps.googleusercontent.com',
//            'clientSecret' => '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',
//            'redirectUri' => 'http://localhost/HomeKlik/public/index.php/email/oauth2callback',
//        ]);
//    }
//
//    public function getAuthorizationUrl()
//    {
//        $authorizationUrl = $this->client->getAuthorizationUrl();
//        return $authorizationUrl;
//    }
//
//    public function getAccessToken($code)
//    {
//        $token = $this->client->getAccessToken('authorization_code', ['code' => $code]);
//        return $token;
//    }
//}
