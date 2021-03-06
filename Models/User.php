<?php
namespace Models;

# Base model for ORM objects
use Core\Entity;

# Specifies table name
use Core\Attributes\Table;

# Specifies primary key
use Core\Attributes\PrimaryKey;

use function Extend\setCookie;
use function Extend\generateToken;


#[Table("Users")]
#[PrimaryKey("id")]
class User extends Entity
{
    const COOKIE_NAME = "comp202204";

    public int $id;
    public string $name;
    protected string $pwd;

    protected ?string $token;

    /* When creating data. */
    public function __construct($name, $pwd)
    {
        $this->name = $name;
        $algorithm = PASSWORD_BCRYPT;
        $pwd = hash("sha256", $pwd);
        $this->pwd = password_hash($pwd, $algorithm);
        parent::__construct();
    }

    public function changePassword($old, $new) : bool
    {
        $pwd = hash("sha256", $old);
        if(!password_verify($pwd, $this->pwd))
            return false;

        $pwd = hash("sha256", $new);
        $algorithm = PASSWORD_BCRYPT;
        $this->pwd = password_hash($pwd, $algorithm);

        $this->save();
        return true;
    }

    public static function exists($name) : bool
    {
        return self::findByName($name) !== null;
    }

    public static function findByName($name) : ?User
    {
        return self::find(["name" => $name])[0] ?? null;
    }

    public static function login($name, $pwd) : ?User
    {
        $user = self::findByName($name);
        
        if(!isset($user))
            return null;

        $pwd = hash("sha256", $pwd);
        if(!password_verify($pwd, $user->pwd))
            return null;
        
        return $user;
    }

    public function toSession()
    {
        $token;
        do {
            $token = generateToken(42);
        } while(self::fromToken($token) !== null);

        $this->token = $token;
        setCookie(self::COOKIE_NAME, $token);
        $this->save();
    }

    public static function fromSession() : ?User
    {
        $token = $_COOKIE[self::COOKIE_NAME] ?? null;
        if(!isset($token) || trim($token) == "")
            return null;

        $user = self::fromToken($token);
        if(!isset($user))
            return null;
        
        return $user;
    }

    public static function clearSession() : void
    {
        $user = self::fromSession();
        setCookie(self::COOKIE_NAME, null);
        if(isset($user))
        {
            $user->token = null;
            $user->save();
        }
    }

    private static function fromToken($token) : ?User
    {
        return self::find(["token" => $token])[0] ?? null;
    }
}

