<?php

require __DIR__.'/vendor/autoload.php';

use Behat\Mink\Driver\GoutteDriver;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Session;

$driver = new Selenium2Driver('chrome');

$session = new Session($driver);
$session->start();

$session->visit('https://youtube.com');

//var_dump($session->getCurrentUrl());

$page = $session->getPage();

$input_search = $page->find('css', 'input#search');

$input_search->setValue('drake');

$input_search->submit();

$page = $session->getPage();

$link = $page->findLink('Nice For What');

$button = $page->findButton('button_name');
$field = $page->findField('label_text');


$link->click();

$session->stop();

//$driver = new GoutteDriver();
/*$driver = new Selenium2Driver('chrome');
$session = new Session($driver);
$session->start();

$session->visit('http://jurassicpark.wikia.com');

//var_dump($session->getStatusCode(), $session->getCurrentUrl());
var_dump($session->getCurrentUrl());

//DOM
$page = $session->getPage();

var_dump(substr($page->getText(), 0, 75));

//NodeElement
$nav = $page->find('css', 'nav.wds-community-header__local-navigation');
//$link = $nav->find('css', 'li a');

$link = $nav->findLink('Books');

$button = $nav->findButton('button_name');
$field = $nav->findField('label_text');

$link->click();

var_dump($session->getCurrentUrl());*/

