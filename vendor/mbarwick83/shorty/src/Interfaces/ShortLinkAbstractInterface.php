<?php

namespace Mbarwick83\Shorty\Interfaces;

use Mbarwick83\Shorty\Exceptions\InvalidApiResponseException;

abstract class ShortLinkAbstractInterface
{
    /**
     * Shortens the long given URL
     *
     * @param string $longUrl
     *
     * @throws \Sonrisa\Service\ShortLink\Exceptions\InvalidApiResponseException
     */
    abstract public function shorten($longUrl);

    /**
     * Expands the short given URL
     *
     * @param string $shortUrl
     *
     * @throws \Sonrisa\Service\ShortLink\Exceptions\InvalidApiResponseException
     */
    abstract public function expand($shortUrl);

    /**
     * Performs the Request to the API server.
     *
     * @param $url
     * @param $context
     * @return string
     */
    protected function request($url,$context)
    {
        if (function_exists('curl_version')) {
            $ch = curl_init();
            if (array_key_exists("http", $context)) {
                if (array_key_exists('method', $context["http"])) {
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $context["http"]["method"]);
                }
                if (array_key_exists("header", $context["http"])) {
                    $delimiter = strpos($context["http"]["header"], "\r\n") === false ? "\n" : "\r\n";
                    $headers = array_filter(explode($delimiter, $context["http"]["header"]), function($item) {
                        return !is_null($item);
                    });
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                }
                if (array_key_exists("content", $context["http"])) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $context["http"]["content"]);    
                }
            }
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL,$url);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
        }

        return file_get_contents($url,false,stream_context_create($context));
    }

}
