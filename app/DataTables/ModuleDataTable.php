<?php

namespace App\DataTables;

use App\Models\Module;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ModuleDataTable extends DataTable
{
    private $course_id = 0;

    public function setCourse($course_id)
    {
        $this->course_id = $course_id;
    }

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
            ->editColumn('member_status', function($row){
                return __('batch.status_'.$row->member_status);
            })
            ->addColumn('file', function($row){
                if($row->file)
                    return '<a target="_blank" href="'.$row->file->fileUrl('filename').'" class="ml-3 text-yellow-500">'.$row->file->filename.'</a>';
                return "tidak ada berkas";
            })
            ->addColumn('action', function($row){
                $btn = '<a href="'.route('admin.courses.modules.edit', [$row->course_id, $row->id]).'" class="ml-3 text-yellow-500">Edit</a>';
                $btn .= '<a href="#" id="delete-'.$row->id.'" class="delete ml-3 text-red-500" data-id="'.$row->id.'">Delete</a>';
                return $btn;
            })
            ->rawColumns(['file','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Module $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Module $model)
    {
        $query = $model->newQuery();
        $query->where('course_id',$this->course_id);
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
                    ->setTableId('module-table')
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
            Column::make('module_no'),
            Column::make('name'),
            Column::make('member_status'),
            Column::make('file'),
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
        return 'Module_' . date('YmdHis');
    }
}
