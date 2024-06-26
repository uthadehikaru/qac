<?php

namespace App\DataTables;

use App\Models\Ecourse;
use App\Models\Order;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EcoursesDataTable extends DataTable
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
            ->editColumn('course_id', function ($row) {
                if ($row->course) {
                    $batch = $row->course->batches()->running()->first();
                    $name = $batch->name ?? '';

                    return 'batch '.$name.' aktif';
                } else {
                    $activeOrders = Order::active()->count();

                    return $activeOrders.' langganan aktif';
                }
            })
            ->editColumn('published_at', function ($row) {
                return $row->published_at ? 'Yes' : 'No';
            })
            ->editColumn('price', function ($row) {
                return $row->price_format;
            })
            ->editColumn('lessons_count', function ($row) {
                return '<a class="text-blue-500" href="'.route('admin.ecourses.show', $row->id).'">'.$row->lessons_count.' lessons</a>';
            })
            ->addColumn('action', function ($row) {
                $btn = '';
                $btn .= '<a href="'.route('admin.ecourses.publish', $row->id).'" class="ml-3 '.($row->published_at ? 'text-green-500' : 'text-blue-500').'">'.($row->published_at ? 'Unpublish' : 'Publish').'</a>';
                $btn .= '<a href="'.route('admin.ecourses.edit', $row->id).'" class="ml-3 text-yellow-500">Edit</a>';
                $btn .= '<a href="#" id="delete-'.$row->id.'" class="delete ml-3 text-red-500" data-id="'.$row->id.'">Delete</a>';

                return $btn;
            })
            ->rawColumns(['template', 'action', 'subscribers_count', 'lessons_count']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Ecourse $model)
    {
        return $model->newQuery()
            ->withCount(['lessons', 'subscribers', 'subscribers as active_subscribers_count' => function ($query) {
                $query->where('start_date', '<=', date('Y-m-d'));
                $query->where('end_date', '>=', date('Y-m-d'));
            }]);
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
            Column::make('course_id')->title('Kelas'),
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
     */
    protected function filename(): string
    {
        return 'Ecourse_'.date('YmdHis');
    }
}
