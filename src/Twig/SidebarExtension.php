<?php
/**
 * @author Redjan Ymeraj <ymerajredjan@gmail.com>
 */

namespace App\Twig;


use App\Entity\Model;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Router;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SidebarExtension extends AbstractExtension
{
    /**
     * @var EntityManager
     */
    protected $manager;

    /**
     * @var Router
     */
    protected $router;

    public function __construct(EntityManager $manager, Router $router)
    {
        $this->manager = $manager;
        $this->router = $router;
    }

    public function getFunctions()
    {
        return array(
            new TwigFunction("render_sidebar", array($this, "renderSidebar"), array(
                "is_safe" => array("html" => true)
            ))
        );
    }

    public function renderSidebar()
    {
        $modelsVisibleInSidebar = $this->manager->getRepository(Model::class)->findBy(array(
            "visibleInSidebar" => true
        ));

        $template = "";

        /**
         * @var Model $model
         */
        foreach ($modelsVisibleInSidebar as $model) {
            $template .= sprintf("<li><a href=\"%s\"><i class=\"fa fa-plus\"></i> <span>%s</span></a></li>", $this->router->generate("app_crud_index", array("modelId" => $model->getId())), $model->getName());
        }

        return $template;
    }
}