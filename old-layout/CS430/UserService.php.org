<?php
class UserService
{
    protected $_username;    // using protected so they can be accessed
    protected $_password;	 // and overidden if necessary
    protected $_email;
    protected $_position;
    protected $_permission;

    protected $_db;       // stores the database handler
    protected $_user;     // stores the user data

    public function __construct(PDO $db, $username, $password) 
    {
       $this->_db = $db;
       $this->_username = $username;
       $this->_password = $password;
    }

    public function login()
    {
        $user = $this->_checkCredentials();
        if ($user) {
            $this->_user = $user; // store it so it can be accessed later
            $_SESSION['user_id'] = $user['id'];

            $this->_email = $this->user['email'];
            $this->_position = $this->user['position'];
            $this->_permission = $this->user['permission'];
          
            return $user['id'];            
        }
        return false;
    }

    protected function _checkCredentials()
    {
        $stmt = $this->_db->prepare('SELECT * FROM contact_information WHERE username=?');
        $stmt->execute(array($this->username));
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $submitted_pass = sha1($user['salt'] . $this->_password);
            if ($submitted_pass == $user['password']) {
                return $user;
            }
        }
        return false;
    }

    public function getUser()
    {
        return $this->_user;
    }
}
?>