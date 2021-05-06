<?php

namespace App\DataTables;

use App\Models\System;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SystemDataTable extends DataTable
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
            ->editColumn('updated_at', function($row){
                return $row->updated_at->format('d/M/Y H:i');
            })
            ->editColumn('value', function($row){
                if($row->is_array)
                    return json_encode($row->value);
                else
                    return $row->value;
            })
            ->addColumn('action', function($row){
                $btn = "";
                $btn .= '<a href="'.route('admin.systems.edit', $row->id).'" class="ml-3 text-yellow-500">Edit</a>';
                $btn .= '<a href="#" id="delete-'.$row->id.'" class="delete ml-3 text-red-500" data-id="'.$row->id.'">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\System $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(System $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('system-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
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
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('key'),
            Column::make('value'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'System_' . date('YmdHis');
    }
}
