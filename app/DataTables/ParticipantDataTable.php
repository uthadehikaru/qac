<?php

namespace App\DataTables;

use App\Models\Participant;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ParticipantDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('is_user', function($row){
                return $row->user_id?'member':'non member';
            })
            ->addColumn('action', function($row){
                return '<a href="#" id="delete-'.$row->id.'" class="delete ml-3 text-red-500" data-id="'.$row->id.'">Delete</a>';
            })
            ->rawColumns(['action','email']);
    }

    private $quiz_id = 0;

    public function setQuiz($quiz_id)
    {
        $this->quiz_id = $quiz_id;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Participant $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Participant $model)
    {
        $query = $model->newQuery();
        $query->where('quiz_id', $this->quiz_id);
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
                    ->setTableId('participant-table')
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
            Column::make('email')
                ->title('Email'),
            Column::make('is_user')
                ->title('Member'),
            Column::make('start_at')
                ->title('Start'),
            Column::make('end_at')
                ->title('End'),
            Column::make('duration')
                ->title('Durasi (Detik)'),
            Column::make('point')
                ->title('Nilai'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Participant_' . date('YmdHis');
    }
}
