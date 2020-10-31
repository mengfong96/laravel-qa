<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * Below will get 5 record per page,
         * and sort by descending manner
         * (latest)
         */
        $questions = Question::latest()->paginate(5);

        /**
         * compact() function
         * --> it will pass the data to the view()
         * --> we just need to put double quote ("") with the variable name
         * --> laravel will get variable defined in this index() function, the make new array to be able to passed to view
         *
         * example:
         *    In Code:
         *
         *      $pagetitle = 'First Page';
         *      $username = 'JigarTala';
         *      $fullname = 'John Tala';
         *      $variables = compact("pagetitle","username","fullname");
         *      echo "<pre>".print_r($variables)."<pre>";
         *
         *    Output:
         *
         *      Array
         *       (
         *          [pagetitle] => First Page
         *          [username] => JigarTala
         *          [fullname] => John Tala
         *       )
         */
        return view('questions.index', compact("questions"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }
}
