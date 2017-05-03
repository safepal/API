<?php

namespace SafePal;

final class AuthMiddleware
{
    /**
     * Example AuthMiddleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */

    private $tokenMissingError = array("status" => "failure", "msg" => "'token' missing in your request");
    private $userMissingError = array("status" => "failure", "msg" => "'userid' not found");
    private $invalidTokenError = array("tokenstatus" => "invalid token");
    private $validTokenMSG = array("tokenstatus" => "token is valid");

    public function __invoke($request, $response, $next)
    {
        $auth = new SafePalAuth;
        $userid = $request->getHeaderLine('userid');
        $token = $request->getParsedBody()['token'];
        $route = $request->getUri();

        if (!(strpos($route, 'newtoken') !== FALSE)) {
        	
        	if (empty($token)) {
        		$response = $response->withJson($this->tokenMissingError);
        	}

        	elseif (empty($userid)) {
        		$response = $response->withJson($this->userMissingError);
        	}
        	 else{
        	 	if (!$auth->CheckToken($token, $userid)) {
        	 		$response = $response->withJson($this->invalidTokenError);
        	 	}

        	 	else{

        	 		if ((strpos($route, 'checktoken') !== FALSE) && $auth->CheckToken($token, $userid)) {
        	 			$response = $response->withJson($this->validTokenMSG);
        	 		}

        	 		$response = $next($request, $response);
        	 	}
        	 }

        	 return $response;
        }

        else{

        	if (strpos($route, 'newtoken') !== FALSE) {
        		$response = $next($request, $response);
        	}
        	return $response;
        }
        
    }
}