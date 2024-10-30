<?php

namespace b5c\Javis\Model;
use b5c\Javis\JAVIS_ModelBase;
use SimpleXMLElement;

/**
 * Class JAVIS_Seminar
 * @package b5c\Javis\Model
 */
class JAVIS_Seminar extends JAVIS_ModelBase
{

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $subtitle;

    /**
     * @var string
     */
    protected $number;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $location;

    /**
     * @var SeminarPlaces
     */
    protected $places;

    /**
     * @var array
     */
    protected $appointments;

    /**
     * @var Price
     */
    protected $price;

    /**
     * @var array
     */
    protected $resources;

    /**
     * @var array
     */
    protected $tags;

    /**
     * @var array
     */
    protected $docents;

    /**
     * @param SimpleXMLElement $element
     */
    public function import(SimpleXMLElement $element) {

        /*
         * Strings
         */
        $this->setTitle((string) $element->title);

        $this->setSubtitle((string) $element->subtitle);
        $this->setNumber((string) $element->number);
        $this->setDescription((string) $element->description);
        $this->setLocation((string) $element->location);

        /*
         * Objects
         */
        $this->setPlaces(new JAVIS_SeminarPlaces($element->places));
        $this->setPrice(new JAVIS_Price($element->price));

        /*
         * Appointments
         */
        $appointments = $element->xpath('appointments/appointment');
        foreach($appointments as $appointment) {
            $this->appointments[] = new JAVIS_Appointment($appointment);
        }

        /*
         * Tags
         */
        $tags = $element->xpath('tags/tag');
        foreach ($tags as $tag) {
            $this->tags[] = (string) $tag;
        }

        /*
         * Resources
         */
	    $resources = $element->xpath('resources');
        $this->setResources((array) $resources[0]);

        /*
         * Docents
         */
        $docents = $element->xpath('docents/docent');
        foreach($docents as $docent) {
            $this->docents[] = new JAVIS_Docent($docent);
        }

    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Seminar
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * @param string $subtitle
     * @return Seminar
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return Seminar
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Seminar
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return Seminar
     */
    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return SeminarPlaces
     */
    public function getPlaces()
    {
        return $this->places;
    }

    /**
     * @param SeminarPlaces $places
     * @return Seminar
     */
    public function setPlaces($places)
    {
        $this->places = $places;
        return $this;
    }

    /**
     * @return Appointment[]
     */
    public function getAppointments()
    {
        return $this->appointments;
    }

    /**
     * @param array $appointments
     * @return Seminar
     */
    public function setAppointments($appointments)
    {
        $this->appointments = $appointments;
        return $this;
    }

    /**
     * @return Price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param Price $price
     * @return Seminar
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return array
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * @param array $resources
     * @return Seminar
     */
    public function setResources($resources)
    {
        $this->resources = $resources;
        return $this;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     * @return Seminar
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return array
     */
    public function getDocents()
    {
        return $this->docents;
    }

    /**
     * @param array $docents
     * @return Seminar
     */
    public function setDocents($docents)
    {
        $this->docents = $docents;
        return $this;
    }



}
