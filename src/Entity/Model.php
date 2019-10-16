<?php
/**
 * @author Redjan Ymeraj <ymerajredjan@gmail.com>
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="model")
 */
class Model
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="_name", type="string")
     */
    protected $name;

    /**
     * @ORM\Column(name="visible_in_sidebar", type="boolean")
     */
    protected $visibleInSidebar;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getVisibleInSidebar(): ?bool
    {
        return $this->visibleInSidebar;
    }

    public function setVisibleInSidebar(bool $visibleInSidebar): self
    {
        $this->visibleInSidebar = $visibleInSidebar;

        return $this;
    }
}