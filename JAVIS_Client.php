<?php

namespace b5c\Javis;

use b5c\Javis\Model\JAVIS_Seminar;
use SimpleXMLElement;

/**
 * Class JAVIS_Client
 * @package b5c\Javis
 */
class JAVIS_Client
{

    /**
     * Javis Client version.
     */
    const VERSION_CLIENT = 1;

    /**
     * @var APIAccessor
     */
    protected $APIAccessor;

    /**
     * JavisAPIClient constructor.
     * @param string $endPointName
     */
    public function __construct($endPointName)
    {
        $this->APIAccessor = new JAVIS_APIAccessor($endPointName);
    }

    /**
     * @param callable|null $filter function to filter seminars
     * @param callable|null $sort function to sort seminars
     * @return Seminar[]
     */
    public function getSeminars($filter = null, $sort = null)
    {
        $result = array();

        try {
            $xml = $this->APIAccessor->request('seminar');
        } catch (\Exception $e) {
            return $result;
        }

        $seminars = $xml->xpath('seminars/seminar');

        if ($seminars instanceof SimpleXMLElement) {
            $result[] = new JAVIS_Seminar($seminars);
        } else {
            foreach ($seminars as $seminar) {
                $result[] = new JAVIS_Seminar($seminar);
            }
        }

        if ($filter !== null) {
            $result = array_filter($result, $filter);
        }

        if ($sort !== null) {
            usort($result, $sort);
        }

        return $result;
    }

    /**
     * @deprecated Please use getSeminars and write your own filter function.
     * @param string $tag
     * @return Seminar[]
     */
    public function getSeminarsByTag($tag)
    {
        return $this->getSeminars(function(JAVIS_Seminar $seminar) use ($tag) {
            $tags = $seminar->getTags();
            return $tags !== null && in_array($tag, $tags);
        });
    }

    /**
     * @param $path
     * @param array $parameters
     * @param int $method
     * @return SimpleXMLElement
     * @throws APIException
     */
    public function getRawData($path, $parameters = array(), $method = JAVIS_APIAccessor::HTTP_GET)
    {
        return $this->APIAccessor->request($path, $parameters, $method);
    }

}
