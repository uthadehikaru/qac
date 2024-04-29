<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ParticipantDataTable;
use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\Quiz;

class ParticipantController extends Controller
{
    public function index(ParticipantDataTable $dataTable, Quiz $quiz)
    {
        $data['title'] = 'Data Peserta Quiz '.$quiz->name;
        $dataTable->setQuiz($quiz->id);

        return $dataTable->render('admin.datatable', $data);
    }

    public function destroy(Quiz $quiz, Participant $participant)
    {
        $participant->delete();

        return back()->with('message', 'Data dihapus');
    }
}
