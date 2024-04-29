<?php

namespace App\DataTables;

use App\Models\Quiz;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class QuizDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed  $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('schedule', function ($row) {
                return $row->duration_date;
            })
            ->addColumn('questions', function ($row) {
                return '<a href="'.route('admin.quiz.questions', $row->id).'" class="ml-3 text-blue-500">'.count($row->questions).' Questions</a>';
            })
            ->addColumn('participants', function ($row) {
                return '<a href="'.route('admin.quiz.participants.index', $row->id).'" class="ml-3 text-green-500">'.count($row->participants).' Participants</a>';
            })
            ->addColumn('action', function ($row) {
                $btn = '';
                $btn .= '<a href="'.route('admin.quiz.edit', $row->id).'" class="ml-3 text-yellow-500">Edit</a>';
                $btn .= '<a href="#" id="delete-'.$row->id.'" class="delete ml-3 text-red-500" data-id="'.$row->id.'">Delete</a>';

                return $btn;
            })
            ->editColumn('course_id', function ($row) {
                return $row->course ? $row->course->name : 'Umum';
            })
            ->rawColumns(['action', 'questions', 'participants']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Quiz $model)
    {
        $query = $model->newQuery();

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('quiz-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0)
            ->buttons(
                Button::make('create'),
                Button::make('reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('name')
                ->title('Nama'),
            Column::make('course_id')
                ->title('Umum/Alumni'),
            Column::make('schedule')
                ->title('Jadwal'),
            Column::make('duration')
                ->title('Durasi (menit)'),
            Column::make('questions')
                ->title('Questions')
                ->searchable(false)
                ->sortable(false),
            Column::make('participants')
                ->title('Peserta')
                ->searchable(false)
                ->sortable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'Quiz_'.date('YmdHis');
    }
}
