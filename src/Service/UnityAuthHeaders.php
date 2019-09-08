<?php

namespace App\Service;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class UnityAuthHeaders
{

    //if we on the page with game, we set headers for auth
    private $page_with_game = 'test_index';
    private $router;
    private $headers_text = ['policy', 'statistic', 'ccc-break'];

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onResponse(Request $request, Response $response)
    {
        if(!$this->checkPageUrl($request)){
            return;
        }

        $this->setHeaders($response, $this->decode($request));
    }

    public function checkAuth(Request $request) : bool
    {
        $expected = [];
        $actual = [];

        $expected = $this->decode($request);
        $actual = $this->getHeaders($request);

        for($i = 0; $i < count($expected); $i++)
        {
            if($expected[$i] !== $actual[$i])
                return false;
        }

        return true;
    }

    private function checkPageUrl(Request $request) : bool
    {
        $locale = $request->getLocale();

        //dump($request->getUri());
        //dump($this->router->generate($this->page_with_game, ['_locale' => $locale], RouterInterface::ABSOLUTE_URL));

        if($request->getUri() === $this->router->generate($this->page_with_game, ['_locale' => $locale], RouterInterface::ABSOLUTE_URL))
            return true;

        return false;
    }

    private function decode(Request $request) : array
    {
        $id = $request->getSession()->getId();

        $hash = hash('sha256', $id);

        $hash2 = hash('sha1', $id);

        $result = $hash . substr($hash2, 6, 32);

        //dump($result);

        return [
            substr($result, 32, 32),
            substr($result, 0, 32),
            substr($result, 64, 32),
        ];
    }

    private function setHeaders(Response $response, array $text) : void
    {
        for($i = 0; $i < 3; $i++){

            $response->headers->set($this->headers_text[$i], $text[$i]);

        }
    }

    private function getHeaders(Request $request) : array
    {
        $result = [];

        for($i = 0; $i < 3; $i++){

            $result[$i] = $request->headers->get($this->headers_text[$i]);

        }

        return $result;
    }

}