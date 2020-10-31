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


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
