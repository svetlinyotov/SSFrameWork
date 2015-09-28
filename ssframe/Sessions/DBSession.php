<?php

namespace SSFrame\Sessions;

use SSFrame\DB\SimpleDB;

class DBSession extends SimpleDB implements ISession{
    
    private $sessionName;
    private $tableName;
    private $lifetime;
    private $path;
    private $domain;
    private $secure;
    private $sessionId=null;
    private $sessionData = array();
    
    public function __construct($dbConnection, $name, $tableName = 'session', $lifetime = 3600, $path = null, $domain = null, $secure = false) {
        parent::__construct($dbConnection);
        $this->tableName = $tableName;
        $this->sessionName = $name;
        $this->lifetime = $lifetime;
        $this->path = $path;
        $this->domain = $domain;
        $this->secure = $secure;
        $this->sessionId = $_COOKIE[$name];
        if (rand(0, 50) == 1) {
            $this->_gc();
        }
        if (strlen($this->sessionId) < 32) {
            $this->_startNewSession();
        } else if (!$this->_validateSession()) {
            $this->_startNewSession();
        }
    }

    private function _startNewSession() {
        $this->sessionId = md5(uniqid('SSFrame', TRUE));
        $this->sql('INSERT INTO ' . $this->tableName . ' (sessid,valid_until) VALUES(?,?)', [$this->sessionId, (time() + $this->lifetime)]);
        setcookie($this->sessionName, $this->sessionId, (time() + $this->lifetime), $this->path, $this->domain, $this->secure, true);
    }
    
    private function _validateSession() {
        if ($this->sessionId) {
            $d = $this->sql('SELECT * FROM ' . $this->tableName . ' WHERE sessid=? AND valid_until<=?', [$this->sessionId, (time() + $this->lifetime)])->fetchAllAssoc();

            if (is_array($d) && count($d) == 1 && $d[0]) {
                $this->sessionData = unserialize($d[0]['sess_data']);
                return true;
            }
        }
        return false;
    }
    
    public function __get($name) {
        return $this->sessionData[$name];
    }

    public function __set($name, $value) {
        $this->sessionData[$name] = $value;        
    }

    public function unsetKey($name)
    {
        unset($this->sessionData[$name]);
        $this->saveSession();
    }

    public function destroySession() {
        if ($this->sessionId) {
            $this->sql('DELETE FROM ' . $this->tableName . ' WHERE sessid=?', array($this->sessionId));
        }
    }

    public function getSessionId() {
        return $this->sessionId;
    }

    public function saveSession() {        
         if ($this->sessionId) {
            $this->sql('UPDATE ' . $this->tableName . ' SET sess_data=?,valid_until=? WHERE sessid=?',[serialize($this->sessionData), (time() + $this->lifetime), $this->sessionId]);
            setcookie($this->sessionName, $this->sessionId, (time() + $this->lifetime), $this->path, $this->domain, $this->secure, true);
        }
    }
    
    private function _gc() {
        $this->sql('DELETE FROM ' . $this->tableName . ' WHERE valid_until<?', array(time()));
    }
}


