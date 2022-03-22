<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\Quiz;
use App\DataTables\ParticipantDataTable;

class ParticipantController extends Controller
{
    public function index(ParticipantDataTable $dataTable, Quiz $quiz)
    {
        $data['title'] = "Data Peserta Quiz ".$quiz->name;
        $dataTable->setQuiz($quiz->id);
        return $dataTable->render('admin.datatable', $data);
    }

    public function destroy(Quiz $quiz, Participant $participant)
    {
        $participant->delete();
        return back()->with('message','Data dihapus');
    }
}
