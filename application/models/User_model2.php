<?php
class User_Model extends CI_Model
{
    // IP functions

    public function checkIp($ip)
    {
        $results = $this->db->where('ip', $ip)->get('banned_ips')->result_array();
        if (count($results))
        {
            echo $results[0]['reason'];
            return false;
        }
        else
        {
            return true;
        }
    }

    // User functions

    public function userExists($username)
    {
        $result = $this->db->where('username',$username)->get('user')->result_array();
        return count($result) > 0;
    }

    public function userGet($username)
    {
        $result = $this->db->select('username, status')->where('username', $username)->get('user')->result_array();
        if (count($result) == 0) {return null;}
        return $result[0];
    }

    public function userCreate($username, $password)
    {
        if (!$this->userExists($username) && $password != "")
        {
            $this->db->insert('user', array(
                'username' => $username,
                'password_hash' => $this->passwordEncode($password),
                'status' => 'default'
            ));
            return true;
        }
        else
        {
            return false;
        }
    }

    public function userCheckLogin($username, $password)
    {
        $result = $this->db->where('username',$username)->get('user')->result_array();

        if (count($result) == 0) {return false;}

        return $this->passwordCheck($password, $result[0]['password_hash']);
    }

    public function userLogin($username, $password)
    {
        if (!$this->userCheckLogin($username, $password)) {return null;}

        $session = $this->generateSession();

        $this->db->where('username',$username)->update('user', array(
            'session_hash' => $this->sessionEncode($session),
            'session_time' => date('Y-m-d H:i:s')
        ));

        return $session;
    }

    public function userDeleteSession($username)
    {
        $this->db->where('username',$username)->update('user', array(
            'session_hash' => null,
            'session_time' => null
        ));
    }

    public function userCheckSession($username, $session)
    {
        if (!$this->userExists($username)) {return null;}

        $result = $this->db->where('username',$username)->get('user')->result_array();

        if ($session == null || $result[0]['session_hash'] == null) {return null;}

        if ($this->sessionAge($result[0]['session_time']))
        {
            if ($this->sessionCheck($session, $result[0]['session_hash']))
            {
                $session = $this->generateSession();

                $this->db->where('username',$username)->update('user', array(
                    'session_hash' => $this->sessionEncode($session),
                    'session_time' => date('Y-m-d H:i:s')
                ));

                return $session;
            }
        }
        else
        {
            $this->userDeleteSession($username);
        }
    }

    public function login($username, $password) // Wraps it and deals with sessions.
    {
        $session = $this->userLogin($username, $password);

        if ($session == null)
        {
            $this->session->sessionToken = null;
            $this->session->sessionUser = null;
            return false;
        }

        $this->session->sessionToken = $session;
        $this->session->sessionUser = $username;

        return true;
    }

    public function user() // Wraps session checking and sends back the current login info.
    {
        $session = $this->userCheckSession($this->session->sessionUser, $this->session->sessionToken);

        if ($session == null)
        {
            $this->session->sessionToken = null;
            $this->session->sessionUser = null;
            return false;
        }

        $this->session->sessionToken = $session;

        return $this->userGet($this->session->sessionUser);
    }

    public function logout()
    {
        $this->session->sessionToken = null;
        $this->userCheckSession($this->session->sessionUser, $this->session->sessionToken);
        $this->session->sessionUser = null;
    }


    // Calculations

    public function passwordEncode($password)
    {
        return $this->encryption->encrypt(base64_encode(password_hash($password, PASSWORD_DEFAULT)));
    }

    public function passwordCheck($password, $hash)
    {
        return password_verify($password, base64_decode($this->encryption->decrypt($hash)));
    }

    public function generateSession()
    {
        return bin2hex(openssl_random_pseudo_bytes(64));
    }

    public function sessionEncode($session)
    {
        return $this->encryption->encrypt(base64_encode(password_hash($session, PASSWORD_DEFAULT)));
    }

    public function sessionCheck($session, $hash)
    {
        return password_verify($session, base64_decode($this->encryption->decrypt($hash)));
    }

    public function sessionAge($date)
    {
        return strtotime(date('Y-m-d H:i:s')) - strtotime($date) <= 600; // Checks if it is less than 600 seconds old.
    }
}
?>
