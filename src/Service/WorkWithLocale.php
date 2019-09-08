<?php

namespace App\Service;


use Symfony\Component\HttpFoundation\Request;

class WorkWithLocaleException extends \Exception{}

class WorkWithLocale
{
    //check if locale exists in session
    //set locale
    //get locale from http header

    public function changeLocale(Request $request) : void
    {
        $locale = $this->getLocale($request);

        if($locale == 'en')
        {

            $this->setLocaleToSession($request, 'ru');

        }else if($locale == 'ru')
        {

            $this->setLocaleToSession($request, 'en');

        }else {
            throw new WorkWithLocaleException("Wrong locale");
        }
    }

    public function getLocale(Request $request) : string
    {
        $locale = $this->getLocaleFromSession($request);

        if($locale == '')
        {
            $locale = $this->getLocaleFromHeader($request);

            if($locale == '')
            {
                $locale = 'en';
            }

            $this->setLocaleToSession($request, $locale);
        }

        return $locale;
    }

    public function setLocaleToRequest(Request $request, string $locale) : void
    {
        $request->setLocale($locale);
    }

    private function getLocaleFromHeader(Request $request) : string
    {
        $locale_header = $request->headers->get("accept-language");

        $locale = strtolower(substr($locale_header, 0, 2));

        switch($locale)
        {
            case 'en': return 'en';
            case 'us': return 'en';
            case 'ru': return 'ru';

            default: return '';
        }
    }

    private function getLocaleFromSession(Request $request) : string
    {
        return ($request->getSession()->get('_locale')) ?? '';
    }

    private function setLocaleToSession(Request $request, string $locale) : void
    {
        $request->getSession()->set('_locale', $locale);
    }
}
