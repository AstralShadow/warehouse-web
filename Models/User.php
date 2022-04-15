<?php
namespace Models;

# Base model for ORM objects
use Core\Entity;

# Specifies table name
use Core\Attributes\Table;

# Specifies primary key
use Core\Attributes\PrimaryKey;

# Part of lazy loading
use Core\Attributes\TraceLazyLoad;

# Collections from foreign key
use Core\Attributes\Traceable;


use function Extend\setCookie;
use function Extend\generateToken;



#[Table("Users")]
#[PrimaryKey("id")]
class User extends Entity
{
    public int $id;
    public string $name;
    protected string $pwd;

    protected string? $token;

    /* When creating data. */
    public function __construct($name, $pwd)
    {
        $this->name = $name;
        $algorithm = PASSWORD_BCRYPT;
        $this->pwd = password_hash($pwd, $algorithm);
        parent::__construct();
    }

    public static function exists($name) : bool
    {
        return count(self::find("name" => $name));
    }

    public static function find($name) : User?
    {
        return self::find("name" => $name)[0] ?? null;
    }

    public static function login($name, $pwd) : User?
    {
        $user = self::find($name);
        
        if(!isset($user))
            return null;

        if(!password_verify($pwd, $user->pwd))
            return null;
        
        return $user;
    }

    public function toSession()
    {
        $this->token = generateToken(42);

        $this->save();
        setCookie(self::COOKIE_NAME, $this->token);
    }

    public static function fromSession() : User?
    {
        $token = $_COOKIE[self::COOKIE_NAME] ?? null;
        if(!isset($token))
            return null;

        $user = self::find("token" => $token)[0] ?? null;
        if(!isset($user))
            return null;
        
        return $user;
    }
}

