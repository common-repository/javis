<?php

namespace b5c\Javis\Model;
use b5c\Javis\JAVIS_ModelBase;
use SimpleXMLElement;

/**
 * Class JAVIS_Appointment
 * @package b5c\Javis\Model
 */
class JAVIS_Appointment extends JAVIS_ModelBase
{

    /**
     * @var \DateTime
     */
    protected $start;

    /**
     * @var \DateTime
     */
    protected $end;

    /**
     * @param SimpleXMLElement $element
     */
    public function import(SimpleXMLElement $element) {
        $this->setStart(new \DateTime($element->start));
        $this->setEnd(new \DateTime($element->end));
    }

    /**
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param \DateTime $start
     * @return Appointment
     */
    public function setStart($start)
    {
        $this->start = $start;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param \DateTime $end
     * @return Appointment
     */
    public function setEnd($end)
    {
        $this->end = $end;
        return $this;
    }

}