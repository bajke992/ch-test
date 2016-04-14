<?php

namespace App\Models;

use App\Exceptions\InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $table = 'questions';

    protected $guarded = ['id'];

    const TYPE_SINGLE = 'single';
    const TYPE_MULTI = 'multi';

    static $VALID_TYPES = [
        'Single Answer Question' => self::TYPE_SINGLE,
        'Multi Answer Question'  => self::TYPE_MULTI
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
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param string $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
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
     *
     * @throws InvalidArgumentException
     */
    public function setType($type)
    {
        if (!in_array($type, self::$VALID_TYPES)) {
            throw new InvalidArgumentException("Invalid $type value. Possible options are: ".implode(', ', self::$VALID_TYPES));
        }
        $this->type = $type;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function polls()
    {
        return $this->belongsToMany('App\Models\Poll');
    }

    /**
     * @return HasMany
     */
    public function answers()
    {
        return $this->hasMany('App\Models\Answer');
    }

    /**
     * @return HasMany
     */
    public function userAnswers()
    {
        return $this->hasMany('App\Models\UserAnswer');
    }

    /**
     * @param string $type
     * @param string $question
     *
     * @return static
     * @throws InvalidArgumentException
     */
    public static function make($type, $question)
    {
        if (!in_array($type, self::$VALID_TYPES)) {
            throw new InvalidArgumentException("Invalid $type value. Possible options are: ".implode(', ', self::$VALID_TYPES));
        }

        return new static([
            'type'     => $type,
            'question' => $question
        ]);
    }

}
