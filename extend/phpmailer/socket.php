<?php
class Socket{
    const DEFAULT_READ_SIZE = 8192;
    const CRTL = "\r\n";
    private $uri = null;
    private $timeout = null;
    private $sock = null;
    private $connected = false;
    public function __construct($uri, $timeout = null){
        $this->uri = $uri;
        $this->timeout = $this->formatTimeout($timeout);
    }

    public function connect($timeout = null, $retryTimes = null){
        if ($this->connected) {
            $this->close();
        }

        $connTimeout = $this->formatTimeout($timeout, $this->timeout);
        $retryTimes = intval($retryTimes);
        if ($retryTimes < 1) {
            $retryTimes = 1;
        }
        for ($i = 0; $i < $retryTimes; ++$i) {
            $this->sock = stream_socket_client(
                $this->uri, $errno, $error, $connTimeout);
            if ($this->sock) {
                break;
            }
        }
        if (!$this->sock) {

        }
        stream_set_timeout($this->sock, $this->timeout);
        $this->connected = true;
    }

    public function read($size){
        assert($this->connected);

        $buf = fread($this->sock, $size);
        if ($buf === false) {
            $this->handleReadError();
        }

        return $buf;
    }

    public function readLine(){
        assert($this->connected);
        $buf = '';
        while (true) {
            $s = fgets($this->sock, self::DEFAULT_READ_SIZE);
            if ($s === false) {
                $this->checkReadTimeout();
                break;
            }
            $n = strlen($s);
            if (!$n) {
                break;
            }
            $buf .= $s;
            if ($s[$n - 1] == "\n") {
                break;
            }
        }

        return $buf;
    }

    public function readAll(){
        assert($this->connected);
        $buf = '';
        while (true) {
            $s = fread($this->sock, self::DEFAULT_READ_SIZE);
            if ($s === false) {
                $this->handleReadError();
            }

            if (!isset($s[0])) {
                break;
            }

            $buf .= $s;
        }

        return $buf;
    }

    public function write($s){
        assert($this->connected);
        $n = strlen($s);
        $w = 0;
        while ($w < $n) {
            $buf = substr($s, $w, self::DEFAULT_READ_SIZE);
            $r = fwrite($this->sock, $buf);
            if (!$r) {
                $this->close();
            }
            $w += $r;
        }
    }
    public function writeLine($s){
        $this->write($s . self::CRTL);
    }
    public function close() {
        if ($this->connected) {
            fclose($this->sock);
            $this->connected = false;
        }
    }
    private function formatTimeout($timeout, $default = null){
        $t = intval($timeout);
        if ($t <= 0) {
            if (!$default) {
                $t = ini_get('default_socket_timeout');
            } else {
                $t = $default;
            }
        }
        return $t;
    }

    private function checkReadTimeout(){
        $meta = stream_get_meta_data($this->sock);
        if (isset($meta['timed_out'])) {
            $this->close();
        }
    }

    private function handleReadError(){
        $this->checkReadTimeout();
        $this->close();
    }
}