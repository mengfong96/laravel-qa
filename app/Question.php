<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    /**
     * In controller, let say we want to create question, and directly throw the
     * data into the database, for security reason, this has been block by laravel.
     *
     * We should add the field name into $fillable array, which means these filed are
     * allowed to be mass assigned
     *
     * This $fillable is not recommended
     *
     * You can go either $fillable or $guarded way to protect the field should be mass assigned or not.
     *
     *
     */
    protected $fillable = [
        'title',
        'body'
    ];

    /**
     * its the opposite of $fillable array
     *
     * Let say we put 'name' into $guarded array,
     * that means we don't want 'name' to be mass assgined.
     *
     * If array is empty,that means nothing is being guarded.
     *
     * You can go either $fillable or $guarded way to protect the field should be mass assigned or not.
     *
     * This $guarded is recommended to ensure data is validated/protected
     *
     */
    protected $guarded = [


    ];

    /**
     * This will link question to user
     *
     * so it will be like:
     * a user can have multiple questions
     * questions belongs to a user
     *
     * note that inside migrations file we have add foreign key
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * This solved the issue that "slug" field does not have default value
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * Inside index.blade.php file, there is a anchor tag with href="$question->url", actually will get the url attribute from here
     * This is the accessor, so the format: get[field]Attribute()
     * this will point to the route and pass the question id into the show method.
     */
    public function getUrlAttribute()
    {
        /**
         * Connected file:
         * RouteServiceProvider.php
         *
         * Function: to make the route address more readable instead of question id
         * for example: http://localhost:8000/question/et-omnis-qui-dolor-animi-ipsum-rerum-updated
         * instead of this: http://localhost:8000/question/1
         */

        return route("questions.show", $this->slug);
    }

    /**
     * When we call attribute in model, we use camel case
     * for example: CreatedDate
     *
     * When we call in view, we use semantic case:
     * for example: created_date
     */
    public function getCreatedDateAttribute()
    {
        /**
         * Formatted the date to human readable form
         *
         * Other format
         * $this->created_at->format('d/m/Y')
         */
        return $this->created_at->diffForHumans();
    }

    /**
     * Get data from database (original is a number)
     * There is a checking in index.blade.php, when displaying the status
     */
    public function getStatusAttribute()
    {
        if ($this->answers > 0) {
            if ($this->best_answer_id) {
                return "answered-accepted";
            }
            return "answered";
        }

        return "unanswered";
    }

    public function getBodyHTMLAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }
}
