<?php
/**
 * Created by PhpStorm.
 * User: Nikki
 * Date: 31.05.2018
 * Time: 19:31
 */

namespace App\EventListener\FosSecurity;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class LogoutSuccessHandler implements LogoutSuccessHandlerInterface
{

    public function onLogoutSuccess(Request $request)
    {
        $uri = ($_SERVER['HTTP_REFERER']) ?? '';

        $httpUtils = new HttpUtils();

        if($uri){
            return $httpUtils->createRedirectResponse($request, $uri);
        }

        return $httpUtils->createRedirectResponse($request, "/manager");
    }
}