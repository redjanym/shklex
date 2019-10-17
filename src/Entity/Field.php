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
     * @ORM\Column(name="required", type="boolean")
     */
    protected $required;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getListTitle(): ?string
    {
        return $this->listTitle;
    }

    public function setListTitle(?string $listTitle): self
    {
        $this->listTitle = $listTitle;

        return $this;
    }

    public function getShowTitle(): ?string
    {
        return $this->showTitle;
    }

    public function setShowTitle(?string $showTitle): self
    {
        $this->showTitle = $showTitle;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAvailableInList(): ?bool
    {
        return $this->availableInList;
    }

    public function setAvailableInList(bool $availableInList): self
    {
        $this->availableInList = $availableInList;

        return $this;
    }

    public function getAvailableInShow(): ?bool
    {
        return $this->availableInShow;
    }

    public function setAvailableInShow(bool $availableInShow): self
    {
        $this->availableInShow = $availableInShow;

        return $this;
    }

    public function getAvailableInCreate(): ?bool
    {
        return $this->availableInCreate;
    }

    public function setAvailableInCreate(bool $availableInCreate): self
    {
        $this->availableInCreate = $availableInCreate;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getRequired(): ?bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): self
    {
        $this->required = $required;

        return $this;
    }
}