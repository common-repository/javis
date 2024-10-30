<?php

namespace b5c\Javis\Model;

use b5c\Javis\JAVIS_ModelBase;
use SimpleXMLElement;

/**
 * Class JAVIS_Price
 * @package b5c\Javis\Model
 */
class JAVIS_Price extends JAVIS_ModelBase
{

    /**
     * Euro
     */
    const CURRENCY_EURO = 'EUR';

    /**
     * @var float
     */
    protected $net;

    /**
     * @var float
     */
    protected $gross;

    /**
     * @var float
     */
    protected $vat;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var string
     */
    protected $show;

    /**
     * @return string
     */
    public function __toString()
    {
        return number_format($this->gross, 2, ",", ".") . ' ' . $this->getCurrencySymbol();
    }


    /**
     * @return string
     */
    public function getCurrencySymbol()
    {
        if ($this->currency == self::CURRENCY_EURO) {
            return '€';
        }
        return $this->currency;
    }

    /**
     * @param SimpleXMLElement $element
     */
    public function import(SimpleXMLElement $element)
    {
        $this->net = (float)$element->net;
        $this->gross = (float)$element->gross;
        $this->vat = (float)$element->vat;
        $this->currency = (string)$element->currency;
        $this->show = (string)$element->show;
    }

    /**
     * @return float
     */
    public function getNet()
    {
        return $this->net;
    }

    /**
     * @param float $net
     * @return Price
     */
    public function setNet($net)
    {
        $this->net = $net;
        return $this;
    }

    /**
     * @return float
     */
    public function getGross()
    {
        return $this->gross;
    }

    /**
     * @param float $gross
     * @return Price
     */
    public function setGross($gross)
    {
        $this->gross = $gross;
        return $this;
    }

    /**
     * @return float
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * @param float $vat
     * @return Price
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return Price
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return string
     */
    public function getShow()
    {
        return $this->show;
    }

    /**
     * @param string $show
     * @return Price
     */
    public function setShow($show)
    {
        $this->show = $show;
        return $this;
    }

}