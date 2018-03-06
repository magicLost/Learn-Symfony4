<?php

namespace App\Controller;


use App\Service\MarkdownHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(MarkdownHelper $markdownHelper)
    {

        $articleContent = <<<EOL

«Дело в том, что скорость **технологических изменений** нарастает **стремительно**, идет резко вверх. Тот, кто использует эту технологическую волну, вырвется далеко вперед. Тех, кто не сможет этого сделать, она, эта волна, просто захлестнет, утопит. Технологическое отставание, зависимость означают снижение безопасности и экономических возможностей страны. А в результате — потерю суверенитета. Именно так, а не иначе обстоит дело <...>.

Изменения в мире носят цивилизационный характер, и [масштаб](https://rbc.ru) этого вызова требует от нас такого же сильного ответа. Мы готовы дать такой ответ. Мы готовы к настоящему прорыву, и эта уверенность основана на значимых результатах, которых мы добились вместе, на сплоченности российского общества и, главное, на колоссальном потенциале России, нашего талантливого, творческого народа».

Подробнее на РБК:
https://www.rbc.ru/politics/01/03/2018/5a97c57d9a7947540e619ce4?from=center_2

EOL;

        $articleContent = $markdownHelper->parse($articleContent);

        return $this->render("home/home.html.twig", [
            'title' => "Welcome to home page.",
            'article' => $articleContent
        ]);
    }
}