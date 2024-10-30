<?php

namespace b5c\Javis;

/**
 * Main Class of the Javis API.
 * Class JavisAPI
 * @package b5c\Javis
 */
class JAVIS_APIAccessor
{

    /**
     * Javis API version.
     */
    const VERSION_API = 1;

    /**
     * Javis API version.
     */
    const HTTP_GET = 0;

    /**
     * Javis API version.
     */
    const HTTP_POST = 1;

    /**
     * Name of the Javis instance. With this url http://example.javis.de you only have to enter 'example'.
     * @var string
     */
    protected $endPointName;

    /**
     * cURL instance.
     * @var resource
     */
    protected $curl;

    /**
     * @param $endPointName string Name of the Javis instance
     */
    public function __construct($endPointName) {
        $this->endPointName = $endPointName;
    }

    /**
     * Returns API url with trailing slash.
     * @return string
     */
    protected function getAPIUrl() {
        return 'https://'.$this->endPointName.'.javis.de/api/v'.self::VERSION_API.'/';
    }

    protected function getUserAgent() {
        return 'Javis API Library v'.JAVIS_Client::VERSION_CLIENT;
    }

    /**
     * @param $path
     * @param array $parameters
     * @param int $method
     * @return \SimpleXMLElement
     * @throws \Exception
     */
    public function request($path, $parameters=array(), $method=self::HTTP_GET) {

        $url = $this->getAPIUrl().$path;

        $set_opt_args = array(
            'user-agent' => $this->getUserAgent(),
            'body' => $parameters,
        );
        $response = wp_remote_get($url, $set_opt_args);

        if ( !is_array( $response ) && is_wp_error( $response ) ) {
            throw new JAVIS_APIException('Error: "' . $response->get_error_message().'"');
        }

        $xml = simplexml_load_string($this->utf8_for_xml($response['body']));

        return $xml;
    }

    private function utf8_for_xml($string)
    {
        return preg_replace ('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string);
    }

    /**
     * Closes cURL instance.
     */
    function __destruct() {
    }

}