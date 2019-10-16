<?php
/**
 * @author Redjan Ymeraj <ymerajredjan@gmail.com>
 */

namespace App\Entity;

use App\Model\FieldInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="field")
 */
class Field implements FieldInterface
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Model")
     * @ORM\JoinColumn(name="model_id", referencedColumnName="id")
     */
    protected $model;

    /**
     * @ORM\Column(name="title", type="string")
     */
    protected $title;

    /**
     * @ORM\Column(name="list_title", type="string", nullable=true)
     */
    protected $listTitle;

    /**
     * @ORM\Column(name="show_title", type="string", nullable=true)
     */
    protected $showTitle;

    /**
     * @ORM\Column(name="_type", type="integer")
     */
    protected $type;

    /**
     * @ORM\Column(name="available_in_list", type="boolean")
     */
    protected $availableInList;

    /**
     * @ORM\Column(name="available_in_show", type="boolean")
     */
    protected $availableInShow;

    /**
     * @ORM\Column(name="available_in_create", type="boolean")
     */
    protected $availableInCreate;

    public function __construct()
    {
        $this->availableInList = true;
        $this->availableInShow = true;
        $this->availableInCreate = true;
    }
}