<?php

namespace App\DataTables;

use App\Models\Member;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MemberDataTable extends DataTable
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
            ->editColumn('created_at', function($row){
                return $row->created_at->format('d-M-Y');
            })
            ->addColumn('name', function($row){
                return $row->full_name.' ('.$row->name.')';
            })
            ->addColumn('email', function($row){
                $value = "<a href='".route('admin.members.verify',$row->user_id)."' class='".($row->user->email_verified_at?'text-green-500':'text-red-500')."'>".$row->user->email."</a>";
                return $value;
            })
            ->addColumn('action', function($row){
                    $btn = '<a href="'.route('admin.members.show', $row->id).'" class="text-blue-500">Detail</a>';
                    $btn .= '<a href="'.route('admin.members.edit', $row->id).'" class="ml-3 text-yellow-500">Edit</a>';
                    $btn .= '<a href="#" id="delete-'.$row->id.'" class="delete ml-3 text-red-500" data-id="'.$row->id.'">Delete</a>';

                    return $btn;
            })
            ->rawColumns(['email','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Member $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Member $model)
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
                    ->setTableId('member-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('export'),
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
            Column::make('created_at'),
            Column::make('name'),
            Column::make('email'),
            Column::make('phone'),
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
        return 'Member_' . date('YmdHis');
    }
}
