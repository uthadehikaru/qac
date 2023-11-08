<?php

namespace App\DataTables;

use App\Models\Batch;
use App\Models\MemberBatch;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TestimonialDataTable extends DataTable
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
            ->filterColumn('member_name', function($query, $keyword) {
                $sql = "members.full_name like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->addColumn('action', function($row){
                return '<a href="'.route('admin.testimonials.delete', $row->id).'" class="ml-3 text-red-500">Delete</a>';
            })
            ->rawColumns(['action']);
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
        $query->select('member_batch.id', 'batches.course_id', 'member_batch.batch_id', 'members.full_name as member_name', 'batches.name as batch_name', 'courses.name as course_name', 'member_batch.testimonial');
        $query->join('members','member_batch.member_id','=','members.id');
        $query->join('batches','member_batch.batch_id','=','batches.id');
        $query->join('courses','batches.course_id','=','courses.id');
        $query->where('member_batch.status',6);
        $query->whereNotNull('member_batch.testimonial');
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
                    ->setTableId('testimonial-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(0)
                    ->pageLength(100)
                    ->scrollX(true)
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
            Column::make('id')->title('#'),
            Column::make('course_name')->title('Kelas'),
            Column::make('batch_name')->title('Batch'),
            Column::make('member_name')->title('Nama'),
            Column::make('testimonial')->title('Testimoni'),
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
    protected function filename(): string
    {
        return 'Data Testimoni per ' . date('d M Y');
    }
}
