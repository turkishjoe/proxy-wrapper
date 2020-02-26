<?php

namespace ProxyWrapper;

class Proxy
{
    private $host;
    private $port;
    private $type;
    private $username;
    private $password;

    /**
     * TODO:
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * TODO:
     * @param mixed $host
     * @return $this
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    /**
     * TODO:
     * @return mixed
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * TODO:
     * @param mixed $port
     * @return $this
     */
    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    /**
     * TODO:
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * TODO:
     * @param mixed $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * TODO:
     *
     * @param mixed $username
     *
     * @return Proxy
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * TODO:
     *
     * @param mixed $password
     *
     * @return Proxy
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function isAuthProxy(){
        return !empty($this->username) || !empty($this->password);
    }

    public function toAuthString(){
        if(!$this->isAuthProxy()){
            return null;
        }

        $loginpassw = sprintf('%s:%s', $this->getUsername(),$this->getPassword());

        return $loginpassw;
    }

    //TODO: Возможно выпилить

    public function toUrl(){
        return $this->host.':'.$this->port;
    }

    public function toFullUrl(){
        return $this->type . '://' . $this->host.':'.$this->port;
    }

    public function toSpotifyUrl(){
        return $this->toUrl() . '@' . $this->getSpotifyType();
    }

    public function getCurlProxy(){
        switch ($this->type)
        {
            case 'socks4':
                return CURLPROXY_SOCKS4;
                break;
            case 'socks5':
                return CURLPROXY_SOCKS5;
                break;
            /*case 'https':
                return CURLPROXY_HTTPS;
                break;*/
            default:
                return CURLPROXY_HTTP;
                break;
        }
    }

    protected function getSpotifyType(){
        //TODO: В конснтанты
        if($this->type === 'https' || $this->type === 'http'){
            return 'http';
        }

        return $this->type;
    }



}
