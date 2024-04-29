<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\QuizDataTable;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Str;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, QuizDataTable $dataTable)
    {
        $data['title'] = 'Data Quiz';

        return $dataTable->render('admin.datatable', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['quiz'] = null;
        $data['courses'] = Course::active()->get();

        return view('admin.quiz-form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'description' => 'required',
            'duration' => 'required|min:1',
        ]);

        $is_public = $request->course_id == null;

        $slug = Str::slug($request->name.' '.Str::random(5));
        $data = [
            'name' => $request->name,
            'slug' => $slug,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'duration' => $request->duration,
        ];

        if (! $is_public) {
            $data['course_id'] = $request->course_id;
        }

        $quiz = Quiz::create($data);

        return redirect()->route('admin.quiz.questions', $quiz->id)->with('status', 'Quiz created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['quiz'] = Quiz::find($id);
        $data['courses'] = Course::active()->get();

        return view('admin.quiz-form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'description' => 'required',
            'duration' => 'required|min:1',
        ]);

        $is_public = $request->course_id == null;

        $quiz = Quiz::find($id);
        $data = [
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'duration' => $request->duration,
        ];

        if (! $is_public) {
            $data['course_id'] = $request->course_id;
        }

        $quiz->update($data);

        return redirect()->route('admin.quiz.index')->with('status', 'Quiz updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Quiz::find($id)->delete();

        return response()->json(['status' => 'Deleted successfully']);
    }

    public function questions($id)
    {
        $quiz = Quiz::find($id);
        $data['quiz'] = $quiz;
        $data['options'] = ['a', 'b', 'c', 'd'];
        $data['i'] = 1;

        return view('admin.quiz-questions', $data);
    }

    public function storeQuestions(Request $request, $id)
    {
        $quiz = Quiz::find($id);

        $data = $request->all();

        for ($i = 0; $i < count($data['question']); $i++) {
            if ($data['question'][$i] == '') {
                continue;
            }

            $questionData = [
                'quiz_id' => $quiz->id,
                'content' => $data['question'][$i],
                'option_a' => $data['option_a'][$i],
                'option_b' => $data['option_b'][$i],
                'option_c' => $data['option_c'][$i],
                'option_d' => $data['option_d'][$i],
                'answer' => $data['answer'][$i],
            ];
            $question_id = $data['question_id'][$i];

            if ($question_id > 0) {
                $question = Question::find($question_id);
                $question->update($questionData);
            } else {
                $question = Question::create($questionData);
            }
        }

        return redirect()->route('admin.quiz.questions', $quiz->id)->with('status', 'Quiz Questions Updated');
    }

    public function deleteQuestion(Quiz $quiz, Question $question)
    {
        $question->delete();

        return redirect()->route('admin.quiz.questions', $quiz->id)->with('status', 'Quiz Questions Deleted');
    }
}
