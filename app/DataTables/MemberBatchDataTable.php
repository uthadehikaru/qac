<?php

namespace App\DataTables;

use App\Models\MemberBatch;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MemberBatchDataTable extends DataTable
{
    private $batch_id = 0;

    public function setBatch($batch_id)
    {
        $this->batch_id = $batch_id;
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
            ->addColumn('name', function($row){
                return $row->member->full_name.' ('.$row->member->name.')';
            })
            ->editColumn('status',function($row){
                return __('batch.status_'.$row->status);
            })
            ->addColumn('action', function($row){
                $btn = '<a href="'.route('admin.members.show', $row->member_id).'" class="text-blue-500">Detail</a>';
                $btn .= '<a href="'.route('admin.courses.batches.members.edit', ['course'=>$row->batch->course_id,'batch'=>$row->batch_id,'id'=>$row->id]).'" class="ml-3 text-green-500">Edit</a>';
                $btn .= '<a href="#" id="delete-'.$row->id.'" data-id="'.$row->id.'" class="delete ml-3 text-red-500">Delete</a>';
                if($row->file)
                $btn .= '<a href="'.$row->file->fileUrl('filename').'" class="ml-3 text-green-500">Sertifikat</a>';
                return $btn;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\MemberBatch $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MemberBatch $model)
    {
        $query = $model->newQuery();
        $query->where('batch_id',$this->batch_id);
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
                    ->setTableId('memberbatch-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export')
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
            Column::make('session'),
            Column::make('status'),
            Column::make('note'),
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
        return 'MemberBatch_' . date('YmdHis');
    }
}