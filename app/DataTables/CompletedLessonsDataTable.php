<?php

namespace App\DataTables;

use App\Models\CompletedLesson;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CompletedLessonsDataTable extends DataTable
{
    private $ecourse_id = 0;

    private $lesson_id = 0;

    public function setEcourse($ecourse_id)
    {
        $this->ecourse_id = $ecourse_id;
    }

    public function setLesson($lesson_id)
    {
        $this->lesson_id = $lesson_id;
    }

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
            ->filterColumn('member_id', function ($query, $keyword) {
                $query->whereHas('member', function ($query) use ($keyword) {
                    $query->where('full_name', 'like', '%'.$keyword.'%');
                });
            })
            ->filterColumn('lesson_id', function ($query, $keyword) {
                $query->whereHas('lesson', function ($query) use ($keyword) {
                    $query->where('subject', 'like', '%'.$keyword.'%');
                });
            })
            ->editColumn('lesson_id', function ($row) {
                return $row->lesson->subject;
            })
            ->editColumn('member_id', function ($row) {
                return $row->member->full_name;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CompletedLesson $model)
    {
        $model = $model->newQuery()
            ->with('member')
            ->whereRelation('lesson', 'ecourse_id', $this->ecourse_id);

        if ($this->lesson_id) {
            $model = $model->where('lesson_id', $this->lesson_id);
        }

        return $model;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('subscription-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0)
            ->buttons(
                Button::make('create'),
                Button::make('reload'),
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
            Column::make('member_id')->title('Member'),
            Column::make('lesson_id')->title('Lesson'),
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'CompletedLesson_'.date('YmdHis');
    }

    public function batch()
    {
        //...your code here.
    }
}
