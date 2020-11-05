<?php

interface Account
{
    public function register($pdo);
    public function login($pdo);
    public function changepassword($pdo);
    public function logout($pdo);

}

class User implements Account
{
    protected $fullname;
    protected $username;
    protected $emailaddress;
    protected $ucity;
    protected $password;
    protected $newpassword;
    protected $userpic;

    //class constructor 
    function __construct($user, $pass)
    {
        $this->username = $user;
        $this->password = $pass;
    }

    
    public function setUsername($uname)
    {
        $this->username = $uname;
    }
    //full name getter
    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($upass)
    {
        $this->password = $upass;
    }
    //full name getter
    public function getPassword()
    {
        return $this->password;
    }

    //full name setter 
    public function setfullname($name)
    {
        $this->fullname = $name;
    }
    //full name getter
    public function getfullname()
    {
        return $this->fullname;
    }

    public function setEmail($email)
    {
        $this->emailaddress = $email;
    }
    public function getEmail()
    {
        return $this->emailaddress;
    }
    public function setNewpassword($newpass)
    {
        $this->newpassword = $newpass;
    }
    public function getNewpassword()
    {
        return $this->newpassword;
    }
    public function setCity($city)
    {
        $this->ucity = $city;
    }
    public function getCity()
    {
        return $this->ucity;
    }

    public function setProfilePhoto($photo)
    {
        $this->userpic = $photo;
    }

    public function getProfilePhoto()
    {
        return $this->userpic;
    }

    /**
     * Create a new user
     * @param Object PDO Database connection handle
     * @return String success or failure message
     */
    public function register($pdo)
    {
        $passwordHash = password_hash($this->password, PASSWORD_DEFAULT);
        try {
            $stmt = $pdo->prepare('INSERT INTO users (full_name,email,city,userpic,username,password) VALUES(?,?,?,?,?,?)');
            $stmt->execute([$this->getfullname(), $this->getEmail(), $this->getCity(), $this->getProfilePhoto(), $this->username, $passwordHash]);
            return "Registration was successful";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    /**
     * Check if a user entered a correct username and password
     * @param Object PDO Database connection handle
     * @return String success or failure message
     */
    public function login($pdo)
    {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
            $stmt->execute([$this->username]);

            $row = $stmt->fetch();

            if ($row == null) {
                return "This account does not exist";
            } else {
                if (password_verify($this->password, $row['password'])) {
                    header("Location: http://localhost/phplogin/home.php"); 
                    return "Correct password.Login successful";
                } else {
                    die("Your username or password is not correct");
                }
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function changepassword($pdo)
    {
        //Checking if the db has a user with that username
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
        $stmt->execute([$this->username]);
        $row = $stmt->fetch();
       
        if ($row == null) {
            return "This account does not exist";
        } else {
            //If the user exists 
            try {
                //Updating the db to the new password
                $hashed = password_hash($this->getNewpassword(), PASSWORD_DEFAULT);
                $info = [
                    'username' => $this->username,
                    'oldpass' => $this->password,
                    'newpass' => $hashed
                ];
                $stmt = $pdo->prepare("UPDATE users SET password=:newpass WHERE username=:username AND password=:oldpass");
                $stmt->execute($info);
                return "Your password has been changed";
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }

    public function logout($pdo){
        session_start();
        unset($_SESSION['username']);
        session_destroy();
        header("Location:http://localhost/phplogin/login.php");

    }
}