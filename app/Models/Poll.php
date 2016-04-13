<?php

namespace App\Models;

use App\Exceptions\InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $table = 'polls';

    protected $guarded = ['id'];

    const STATUS_ACTIVE = 'active';
    const STATUS_ARCHIVED = 'archived';

    const VISIBILITY_PUBLIC = 'public';
    const VISIBILITY_PRIVATE = 'private';

    static $VALID_STATUS = [
        'Active' => self::STATUS_ACTIVE,
        'Archived' => self::STATUS_ARCHIVED
    ];
    static $VALID_VISIBILITY = [
        'Public' => self::VISIBILITY_PUBLIC,
        'Private' => self::VISIBILITY_PRIVATE
    ];

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param mixed $visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getLock()
    {
        return $this->lock;
    }

    /**
     * @param mixed $lock
     */
    public function setLock($lock)
    {
        $this->lock = $lock;
    }

    public function questions()
    {
        return $this->belongsToMany('App\Molde\Question');
    }

    public static function make($title, $visibility, $status)
    {
        if(!in_array($visibility, self::$VALID_VISIBILITY)){
            throw new InvalidArgumentException("Invalid $visibility value. Possible options are: " . implode(', ', self::$VALID_VISIBILITY));
        }

        if(!in_array($status, self::$VALID_STATUS)){
            throw new InvalidArgumentException("Invalid $status value. Possible options are: " . implode(', ', self::$VALID_STATUS));
        }

        return new static([
            'title'      => $title,
            'visibility' => $visibility,
            'status'     => $status
        ]);
    }
}
