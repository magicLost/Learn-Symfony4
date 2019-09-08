<?php

namespace App\Service;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class WorkWithTargetPath
{
    use TargetPathTrait;

    private $router;

    private $bad_uri = [
        'fos_user_security_login',
        'fos_user_registration_register'
    ];
    private $bad_referer = [
        'fos_user_security_login',
        'fos_user_registration_register'
    ];

    private const OUR_TARGET_PATH_KEY = "OurTargetPath";

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }



    public function saveReferer(string $referer, Request $request) : void
    {
        //$referer = ($_SERVER['HTTP_REFERER']) ?? '';
        //if($referer != '' && $referer != $this->router->generate('security_login', [], UrlGeneratorInterface::ABSOLUTE_URL))
        if($this->isGoodReferer($referer))
        {
            $request->getSession()->set(
                self::OUR_TARGET_PATH_KEY, $referer
            );

        }
    }

    private function isGoodReferer(string $referer) : bool
    {

        return $this->isGood($referer, true);

    }

    public function isGoodUri(string $uri) : bool
    {

        return $this->isGood($uri, false);

    }

    private function isGood(string $val, bool $isReferer)
    {
        if($val == ''){

            return false;

        }

        if($isReferer){
            foreach($this->bad_referer as $value)
            {
                if($val === $this->router->generate($value, [], UrlGeneratorInterface::ABSOLUTE_URL))
                {
                    return false;
                }
            }
        }
        else{
            foreach($this->bad_uri as $value)
            {
                if($val === $this->router->generate($value))
                {
                    return false;
                }
            }
        }

        return true;
    }

    public function getRedirectUri(Request $request) : string
    {
        //dump("Referer == ".$this->referer);

        //dump("Login path == ".$this->router->generate('security_login', [], UrlGeneratorInterface::ABSOLUTE_URL));

        $url = $this->getTargetPath($request->getSession(), 'main');

        if($url)
            return $url;


        $referer = $request->getSession()->get(self::OUR_TARGET_PATH_KEY);

        if(!$referer){

            $referer = $this->router->generate('home');

        }

        return $referer;
    }

}