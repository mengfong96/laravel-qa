<?php

namespace App\Http\Controllers;

use App\Http\Requests\AskQuestionRequest;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionsController extends Controller
{
    public function __construct() {
        $this->middleware('auth',['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * when we want to see the query log
         * this will be replace by laravel-debug-bar
         */
        // DB::enableQueryLog();
        // view('questions.index', compact("questions"))->render();
        // dd(DB::getQueryLog());

        /**
         * Below will get 5 record per page,
         * and sort by descending manner
         * (latest)
         *
         * with('user') will go to Question Controller 'user" method
         */
        $questions = Question::with('user')->latest()->paginate(5);

        /**.
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
        $question = new Question();

        return view('questions.create', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //we will using different request
    public function store(AskQuestionRequest $request)
    {
        # 1. get current user
        # 2. get question
        # 3. create and sent into db
        $request->user()->questions()->create($request->only('title','body'));

        //redirect to homepage (question listing)
        //with("success"...) --> means it will put into session as a session variable
        return redirect()->route('questions.index')->with('success',"Your question has been submitted");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        /**
         * Below line of code equivalent to:
         *
         * $question->views = $question->views+1;
         * $question->save();
         */
        $question->increment('views');

        return view('questions.show', compact('question'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        # from QuestionPolicy
        $this->authorize("update", $question);
        //auto fetch the id from request
        return view("questions.edit", compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        # from QuestionPolicy
        $this->authorize("update", $question);

        # 1. get current user
        # 2. get question
        # 3. create and sent into db
        $question->update($request->only('title','body'));

        //redirect to homepage (question listing)
        //with("success"...) --> means it will put into session as a session variable
        //so that alert box can get the message
        return redirect()->route('questions.index')->with('success',"Your question has been updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        # from QuestionPolicy
        $this->authorize("delete", $question);

        $question->delete();

        return redirect()->route('questions.index')->with('success', "Your question has been deleted.");
    }
}
