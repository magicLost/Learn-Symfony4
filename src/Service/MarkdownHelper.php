<?php

namespace App\Service;


use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class MarkdownHelper
{

    /**
     * @var AdapterInterface
     */
    private $cache;
    /**
     * @var MarkdownInterface
     */
    private $markdown;
    /**
     * @var LoggerInterface
     */
    private $markdownLogger;
    /**
     * @var bool
     */
    private $isDebug;

    public function __construct(
        AdapterInterface $cache,
        MarkdownInterface $markdown,
        LoggerInterface $markdownLogger,
        bool $isDebug)
    {

        $this->cache = $cache;
        $this->markdown = $markdown;
        $this->markdownLogger = $markdownLogger;
        $this->isDebug = $isDebug;
    }

    public function parse(string $source):string
    {
        if(stripos($source, 'rbc') !== false){
            $this->markdownLogger->info("They are talking about rbc again");
        }

        //if debug true we do not cache
        if($this->isDebug){
            return $this->markdown->transform($source);
        }

        $item = $this->cache->getItem('markdown_'.md5($source));
        if(!$item->isHit()){
            $item->set($this->markdown->transform($source));
            $this->cache->save($item);
        }

        return $item->get();
    }
}