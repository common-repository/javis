<?php

namespace b5c\Javis\Model;
use b5c\Javis\JAVIS_ModelBase;
use SimpleXMLElement;

/**
 * Class JAVIS_Docent
 * @package b5c\Javis\Model
 */
class JAVIS_Docent extends JAVIS_ModelBase
{

    /**
     * @var string
     */
    protected $academicDegree;

    /**
     * @var string
     */
    protected $gender;

    /**
     * @var string
     */
    protected $firstname;

    /**
     * @var string
     */
    protected $lastname;

    /**
     * @param SimpleXMLElement $element
     */
    public function import(SimpleXMLElement $element) {
        $this->setAcademicDegree($element->academicDegree);
        $this->setGender($element->gender);
        $this->setFirstname($element->firstname);
        $this->setLastname($element->lastname);
    }

    /**
     * @return string
     */
    public function getAcademicDegree()
    {
        return $this->academicDegree;
    }

    /**
     * @param string $value
     * @return Docent
     */
    public function setAcademicDegree($value)
    {
        $this->academicDegree = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $value
     * @return Docent
     */
    public function setGender($value)
    {
        $this->gender = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return Docent
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return Docent
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function __toString()
    {
        return implode(" ", array_filter([$this->getAcademicDegree(), $this->getFirstname(), $this->getLastname()])) ;

    }

}