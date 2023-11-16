<?php

namespace App\DataTables;

use App\Models\Ecourse;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EcoursesDataTable extends DataTable
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
            ->editColumn('published_at', function($row){
                return $row->published_at?'Yes':'No';
            })
            ->editColumn('price', function($row){
                return $row->price_format;
            })
            ->editColumn('lessons_count', function($row){
                return '<a class="text-blue-500" href="'.route('admin.ecourses.show', $row->id).'">'.$row->lessons_count.' lessons</a>';
            })
            ->editColumn('subscribers_count', function($row){
                return '<a class="text-blue-500" href="'.route('admin.ecourses.subscriptions.index', $row->id).'">'.$row->subscribers_count.' members</a>';
            })
            ->addColumn('action', function($row){
                $btn = "";
                $btn .= '<a href="'.route('admin.ecourses.publish', $row->id).'" class="ml-3 '.($row->published_at?'text-green-500':'text-blue-500').'">'.($row->published_at?'Unpublish':'Publish').'</a>';
                $btn .= '<a href="'.route('admin.ecourses.edit', $row->id).'" class="ml-3 text-yellow-500">Edit</a>';
                $btn .= '<a href="#" id="delete-'.$row->id.'" class="delete ml-3 text-red-500" data-id="'.$row->id.'">Delete</a>';
                return $btn;
            })
            ->rawColumns(['template','action','subscribers_count','lessons_count']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Ecourse $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Ecourse $model)
    {
        return $model->newQuery()
        ->withCount(['lessons','subscribers']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('ecourse-table')
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
            Column::make('title'),
            Column::make('lessons_count')->title('Lessons'),
            Column::make('subscribers_count')->title('Subscribers'),
            Column::make('price'),
            Column::make('published_at')->title('Is Published'),
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
    protected function filename(): String
    {
        return 'Ecourse_' . date('YmdHis');
    }
}
