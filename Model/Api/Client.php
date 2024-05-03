<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Model_Api_Client
{
    private $headers = [];
    private $cookies = [];
    private $timeout = 300;
    private $port = 80;
    private $sslVersion;

    private $curlUserOptions;
    private $responseHeaders = [];
    private $responseBody = '';
    private $responseStatus = 0;

    private $headerCount = 0;

    private $curl;

    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    public function post($uri, $params)
    {
        $this->makeRequest('POST', $uri, $params);
    }

    /**
     * Get response status code
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->responseStatus;
    }

    private function makeRequest($method, $uri, $params = [])
    {
        $this->curl = curl_init();
        $this->curlOption(CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS | CURLPROTO_FTP | CURLPROTO_FTPS);
        $this->curlOption(CURLOPT_URL, $uri);
        if ($method == 'POST') {
            $this->curlOption(CURLOPT_POST, 1);
            $this->curlOption(CURLOPT_POSTFIELDS, is_array($params) ? http_build_query($params) : $params);
        } elseif ($method == "GET") {
            $this->curlOption(CURLOPT_HTTPGET, 1);
        } else {
            $this->curlOption(CURLOPT_CUSTOMREQUEST, $method);
        }

        if (count($this->headers)) {
            $heads = [];
            foreach ($this->headers as $k => $v) {
                $heads[] = $k . ': ' . $v;
            }
            $this->curlOption(CURLOPT_HTTPHEADER, $heads);
        }

        if (count($this->cookies)) {
            $cookies = [];
            foreach ($this->cookies as $k => $v) {
                $cookies[] = "{$k}={$v}";
            }
            $this->curlOption(CURLOPT_COOKIE, implode(";", $cookies));
        }

        if ($this->timeout) {
            $this->curlOption(CURLOPT_TIMEOUT, $this->timeout);
        }

        if ($this->port != 80) {
            $this->curlOption(CURLOPT_PORT, $this->port);
        }

        $this->curlOption(CURLOPT_RETURNTRANSFER, 1);
        $this->curlOption(CURLOPT_HEADERFUNCTION, [$this, 'parseHeaders']);
        if ($this->sslVersion !== null) {
            $this->curlOption(CURLOPT_SSLVERSION, $this->sslVersion);
        }

        if (count($this->curlUserOptions)) {
            foreach ($this->curlUserOptions as $k => $v) {
                $this->curlOption($k, $v);
            }
        }

        $this->headerCount = 0;
        $this->responseHeaders = [];
        $this->responseBody = curl_exec($this->curl);
        $err = curl_errno($this->curl);
        if ($err) {
            $this->doError(curl_error($this->curl));
        }
        curl_close($this->curl);
    }

    /**
     * Set curl option directly
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    private function curlOption($name, $value)
    {
        curl_setopt($this->curl, $name, $value);
    }

    /**
     * Parse headers - CURL callback function
     *
     * @param string $data
     * @return int
     * @throws \Exception
     */
    private function parseHeaders($data)
    {
        $data = $data !== null ? $data : '';
        if ($this->headerCount == 0) {
            $line = explode(" ", trim($data), 3);
            if (count($line) < 2) {
                $this->doError("Invalid response line returned from server: " . $data);
            }
            $this->responseStatus = (int)$line[1];
        } else {
            $name = $value = '';
            $out = explode(": ", trim($data), 2);
            if (count($out) == 2) {
                $name = $out[0];
                $value = $out[1];
            }

            if (strlen($name)) {
                if ('set-cookie' === strtolower($name)) {
                    $this->responseHeaders['Set-Cookie'][] = $value;
                } else {
                    $this->responseHeaders[$name] = $value;
                }
            }
        }
        $this->headerCount++;

        return strlen($data);
    }

    /**
     * Throw error exception
     *
     * @param string $string
     * @return void
     * @throws \Exception
     */
    public function doError($string)
    {
        //  phpcs:ignore Magento2.Exceptions.DirectThrow
        throw new \Exception($string); // TODO change to Mage::throwException() ?
    }

    /**
     * Get response body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->responseBody;
    }
}