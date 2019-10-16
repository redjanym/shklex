<?php
/**
 * @author Redjan Ymeraj <ymerajredjan@gmail.com>
 */

namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TemplateUtilitiesExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return array(
            new TwigFunction("bool_view", array($this, "boolView"), array(
                "is_safe" => array("html" => true)
            ))
        );
    }

    public function boolView(bool $value)
    {
        return sprintf("<span class='label label-%s'>%s</span>", ($value ? "success" : "danger"), ($value ? "YES" : "NO"));
    }
}