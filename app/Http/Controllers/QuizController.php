<?php

namespace App\Http\Controllers;

use App\Mail\ApplyQuiz;
use App\Models\Participant;
use App\Models\ParticipantAnswer;
use App\Models\Quiz;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mail;
use Str;

class QuizController extends Controller
{
    public function index()
    {
        $data['latestQuizzes'] = Quiz::latest()->simplePaginate(5);

        return view('quiz-list', $data);
    }

    public function detail(Request $request, Quiz $quiz)
    {
        if (! $quiz->is_active) {
            return back()->with('error', 'Mohon maaf, quiz ini belum dimulai/sudah selesai');
        }

        if ($quiz->course_id) {
            if (! Auth::check()) {
                session(['url.intended' => url()->current()]);

                return redirect()->route('login')->withError('Silahkan login terlebih dahulu');
            } elseif ($quiz->course && ! $quiz->isAllowed(Auth::user())) {
                return redirect()->route('quiz.list')->with('error', 'Anda tidak memiliki akses ke quiz '.$quiz->name);
            }
        }

        $email = '';
        $user_id = 0;
        if (Auth::check()) {
            $email = Auth::user()->email;
            $user_id = Auth::id();
        }

        $data['quiz'] = $quiz;
        $data['i'] = 1;
        $data['options'] = ['a', 'b', 'c', 'd'];

        if ($request->session()->has('session')) {
            $data['end_at'] = $request->session()->get('end_at');
        } else {
            $participant = Participant::where(['email' => $email, 'user_id' => $user_id])->first();

            if ($participant->finish) {
                return redirect()->route('quiz.list')->with('error', 'Anda sudah mengerjakan, kesempatan anda hanya sekali');
            }

            $participant = Participant::create([
                'session' => \Str::uuid(),
                'email' => $email,
                'user_id' => $user_id,
                'start_at' => date('Y-m-d H:i:s'),
                'quiz_id' => $quiz->id,
            ]);
            $request->session()->put('session', $participant->session);
            $end_at = date('Y-m-d H:i:s', strtotime('+'.$quiz->duration.' minutes'));
            $request->session()->put('end_at', $end_at);
            $data['end_at'] = $end_at;
        }

        return view('quiz-detail', $data);
    }

    public function finish(Request $request, Quiz $quiz)
    {
        if ($request->session()->has('session')) {
            $participant = Participant::where('session', $request->session()->get('session'))->first();

            $data = $request->all();
            $total = 0;
            foreach ($quiz->questions as $question) {
                $is_correct = $request->has('question_'.$question->id) && $question->answer == $data['question_'.$question->id];

                $answer = ParticipantAnswer::create([
                    'participant_id' => $participant->id,
                    'question_id' => $question->id,
                    'question' => $question->content,
                    'answer' => $request->has('question_'.$question->id) ? $question->getOriginal('option_'.$data['question_'.$question->id]) : '',
                    'is_correct' => $is_correct,
                ]);

                if ($is_correct) {
                    $total++;
                }
            }

            $interval = $participant->start_at->diffInSeconds($participant->end_at);
            $participant->end_at = date('Y-m-d H:i:s');
            $participant->duration = $interval;
            $participant->point = $total;
            $participant->save();

            $request->session()->forget('session');

            return redirect()->route('quiz.list')->with('message', 'Anda telah menyelesaikan quiz '.$quiz->name);
        }

        return redirect()->route('quiz.list')->with('error', 'Anda tidak memiliki sesi untuk quiz '.$quiz->name);
    }

    public function apply(Request $request, Quiz $quiz)
    {
        $data = $request->validate([
            'email' => 'required|email',
        ]);

        $participant = Participant::where(['email' => $request->email, 'quiz_id' => $quiz->id])->first();
        if ($participant) {
            if ($participant->finish) {
                return redirect()->route('quiz.list')->with('error', 'Anda sudah mengerjakan, kesempatan anda hanya sekali');
            } else {
                return redirect()->route('quiz.list')->with('error', 'Anda sudah mengajukan diri, cek email anda untuk mendapatkan akses ke quiz '.$quiz->name);
            }
        }

        $participant = Participant::create([
            'quiz_id' => $quiz->id,
            'email' => $request->email,
            'user_id' => 0,
            'session' => Str::uuid(),
        ]);
        Mail::to($request->email)->send(new ApplyQuiz($participant));

        return redirect()->route('quiz.list')->with('message', 'Cek email anda untuk memulai Quiz '.$quiz->name);
    }

    public function verify(Request $request, $session)
    {
        $participant = Participant::where('session', $session)->first();
        if (! $participant) {
            return redirect()->route('quiz.list')->with('message', 'Kode verifikasi tidak sesuai, mohon pastikan kembali');
        }

        if ($participant->start_at && $participant->end_at) {
            return redirect()->route('quiz.list')->with('message', 'Sesi anda telah selesai');
        }

        $durationInSeconds = $participant->quiz->duration * 60;
        if ($participant->start_at && $participant->start_at->diffInSeconds(Carbon::now()) > $durationInSeconds) {
            $participant->end_at = $participant->start_at;
            $participant->save();

            return redirect()->route('quiz.list')->with('message', 'Sesi anda telah selesai');
        }

        if (! $request->session()->has('session')) {
            $user = User::where('email', $participant->email)->first();
            if ($user) {
                $participant->user_id = $user->id;
            }

            if (! $participant->start_at) {
                $participant->start_at = date('Y-m-d H:i:s');
                $participant->save();
            }
            $end_at = $participant->start_at->addSeconds($durationInSeconds);

            $request->session()->put('session', $session);
            $request->session()->put('end_at', $end_at);
            $data['end_at'] = $end_at;
        }

        return redirect()->route('quiz.detail', $participant->quiz->slug);
    }
}
