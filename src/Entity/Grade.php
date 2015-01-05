<?php

namespace SDIS62\Core\User\Entity;

use SDIS62\Core\Common\Entity\IdentityTrait;
use SDIS62\Core\User\Exception\InvalidGradeException;

abstract class Grade
{
    use IdentityTrait;

    /**
     * Valeur du grade
     *
     * @var int
     */
    protected $value;

    /**
     * Nom du grade
     *
     * @var string
     */
    protected $label;

    /**
     * Constructeur
     *
     * @param string nom du grade
     * @param int valeur
     */
    public function __construct($label, $value)
    {
        $this->label = $label;
        $this->value = $value;
    }

    /**
     * Get the value of Grade
     *
     * @return string
     */
    final public function getType()
    {
        if (empty($this->type)) {
            throw new InvalidGradeException(get_class($this).' doit avoir un $type');
        }

        return $this->type;
    }

    /**
     * Compare deux grades. -1 = inférieur ; 0 égal ; 1 supérieur
     *
     * @param SDIS62\Core\User\Entity\Grade
     * @return int
     */
    public function compare(Grade $grade)
    {
        if ($grade->getValue() > $this->getValue()) {
            return 1;
        } elseif ($grade->getValue() < $this->getValue()) {
            return -1;
        }

        return 0;
    }

    /**
     * Get the value of Valeur du grade
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of Valeur du grade
     *
     * @param int value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of Nom du grade
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the value of Nom du grade
     *
     * @param string label
     *
     * @return self
     */
    public function setLabel($value)
    {
        $this->label = $value;

        return $this;
    }
}
