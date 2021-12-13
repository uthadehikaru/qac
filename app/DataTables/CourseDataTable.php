<?php

namespace App\DataTables;

use App\Models\Course;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CourseDataTable extends DataTable
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
            ->addColumn('batch', function($row){
                $btn = '<a href="'.route('admin.courses.batches.index', $row->id).'" class="text-blue-500">'.$row->batches->count().' Batches</a>';
                return $btn;
            })
            ->addColumn('waitinglist', function($row){
                $btn = '<a href="'.route('admin.courses.queues.index', $row->id).'" class="text-blue-500">'.$row->members->count().' Waitinglist</a>';
                return $btn;
            })
            ->addColumn('modules', function($row){
                $btn = '<a href="'.route('admin.courses.modules.index', $row->id).'" class="text-blue-500">'.$row->modules->count().' Modul</a>';
                return $btn;
            })
            ->editColumn('participants', function($row){
                $btn = '<a href="'.route('admin.courses.members', $row->id).'" class="text-blue-500">'.$row->participants.' Peserta</a>';
                return $btn;
            })
            ->editColumn('is_active', function($row){
                return $row->is_active?'Yes':'No';
            })
            ->addColumn('action', function($row){
                $btn = '<a href="'.route('admin.courses.edit', $row->id).'" class="ml-3 text-yellow-500">Edit</a>';
                $btn .= '<a href="#" id="delete-'.$row->id.'" class="delete ml-3 text-red-500" data-id="'.$row->id.'">Delete</a>';
                return $btn;
            })
            ->rawColumns(['batch','waitinglist','modules','action','participants']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Course $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Course $model)
    {
        $query = $model->newQuery();
        $query->selectRaw("courses.*, 
        (select coalesce(count(1),0) FROM member_batch 
        WHERE EXISTS(SELECT 1 from batches b WHERE b.id=member_batch.batch_id AND b.course_id=courses.id)) 
        as participants");
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
                    ->setTableId('course-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(0)
                    ->buttons(
                        Button::make('create')
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
            Column::make('name'),
            Column::make('level'),
            Column::make('is_active'),
            Column::make('batch'),
            Column::make('participants')->title("Peserta"),
            Column::make('waitinglist'),
            Column::make('modules'),
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
        return 'Course_' . date('YmdHis');
    }
}
