<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use CanResetPassword;

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    const TYPE_USER = 'user';
    const TYPE_ADMIN = 'admin';

    const STATUS_ACTIVE = 'active';
    const STATUS_BANNED = 'banned';

    /**
     * @var array
     */
    static $VALID_TYPES = [
        'Admin' => self::TYPE_ADMIN,
        'User'  => self::TYPE_USER
    ];

    /**
     * @var array
     */
    static $VALID_STATUS = [
        'Active' => self::STATUS_ACTIVE,
        'Banned' => self::STATUS_BANNED
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     */
    public function setToken($token = null)
    {
        $token       = $token ?: str_random(10);
        $this->token = $token;
    }

    public function clearToken()
    {
        $this->token = null;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return integer
     */
    public function getVerified()
    {
        return $this->verified;
    }

    /**
     * @param integer $verified
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;
    }

    /**
     * @param $email
     * @param $password
     *
     * @return static
     */
    public static function make($email, $password)
    {
        return new static([
            'email'    => $email,
            'password' => $password,
        ]);
    }

    /**
     * @return boolean
     */
    public function isAdmin()
    {
        return ($this->getType() === self::TYPE_ADMIN);
    }
}
