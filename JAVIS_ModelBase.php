<?php

namespace b5c\Javis;

use SimpleXMLElement;

/**
 * Class JAVIS_ModelBase
 * @package b5c\Javis
 */
abstract class JAVIS_ModelBase
{

    /**
     * @param SimpleXMLElement|null $element
     */
    public function __construct(SimpleXMLElement $element=null) {
        if($element !== null) {
            $this->import($element);
        }
    }

    /**
     * @param SimpleXMLElement $element
     */
    abstract  public function import(SimpleXMLElement $element);

}