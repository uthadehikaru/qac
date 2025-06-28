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
            ->editColumn('is_only_active_batch', function ($row) {
                if ($row->is_only_active_batch) {
                    $batch = $row->course->batches()->running()->first();
                    if ($batch) {
                        return 'batch '.$batch->name;
                    }

                    return 'no active batch';
                } else {
                    $activeOrders = Order::active()->count();

                    return 'langganan ('.$activeOrders.' aktif)';
                }
            })
            ->editColumn('published_at', function ($row) {
                return $row->published_at ? '<span class="p-1 text-white bg-green-500">Yes</span>' : '<span class="p-1 text-white bg-red-500">No</span>';
            })
            ->editColumn('course_id', function ($row) {
                return $row->course?->name ?? 'All Level';
            })
            ->editColumn('price', function ($row) {
                return $row->price_format;
            })
            ->editColumn('title', function ($row) {
                return '<a class="text-blue-500" href="'.route('member.ecourses.show', $row->slug).'">'.$row->title.'</a>';
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
            ->rawColumns(['title', 'action', 'lessons_count', 'published_at']);
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
            ->scrollX(true)
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
            Column::make('category_id')->title('Category'),
            Column::make('lessons_count')->title('Lessons')
                ->searchable(false)
                ->orderable(false),
            Column::make('course_id')->title('Kelas'),
            Column::make('is_only_active_batch')->title('Type'),
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
