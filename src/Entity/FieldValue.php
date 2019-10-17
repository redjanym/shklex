<?php
/**
 * @author Redjan Ymeraj <ymerajredjan@gmail.com>
 */

namespace App\Entity;

use App\Model\FieldInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="field_value")
 */
class FieldValue implements FieldInterface
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Field")
     * @ORM\JoinColumn(name="field_id", referencedColumnName="id")
     */
    protected $field;

    /**
     * @ORM\Column(name="value", type="string", nullable=false)
     */
    protected $value;

    /**
     * @ORM\ManyToOne(targetEntity="FieldTransaction")
     * @ORM\JoinColumn(name="transaction_id", referencedColumnName="id")
     */
    protected $transaction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getField(): ?Field
    {
        return $this->field;
    }

    public function setField(?Field $field): self
    {
        $this->field = $field;

        return $this;
    }

    public function getTransaction(): ?FieldTransaction
    {
        return $this->transaction;
    }

    public function setTransaction(?FieldTransaction $transactionId): self
    {
        $this->transaction = $transactionId;

        return $this;
    }
}