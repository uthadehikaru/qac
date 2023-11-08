<?php

namespace App\DataTables;

use App\Models\Queue;
use App\Models\Batch;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class QueueDataTable extends DataTable
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
        $openBatch = Batch::open()->where('course_id',$this->course_id)->first();
        return datatables()
            ->eloquent($query)
            ->filterColumn('full_name', function($query, $keyword) {
                $sql = "members.full_name like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('gender', function($query, $keyword) {
                $sql = "members.gender like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('address', function($query, $keyword) {
                $sql = "members.address like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('phone', function($query, $keyword) {
                $sql = "members.phone like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('email', function($query, $keyword) {
                $sql = "users.email like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->editColumn('created_at', function($row){
                return $row->created_at->format('d-M-Y H:i:s');
            })
            ->addColumn('action', function($row) use($openBatch){
                $btn = "";
                if($openBatch)
                    $btn .= ' <a href="'.route('admin.courses.queues.register', [$row->course_id, $row->id]).'" class="ml-3 text-blue-500">Register</a>';
                $btn .= ' <a href="#" id="delete-'.$row->id.'" class="delete ml-3 text-red-500" data-id="'.$row->id.'">Delete</a>';
                return $btn;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Queue $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Queue $model)
    {
        $query = $model->newQuery();
        $query->select('queues.*', 'members.full_name', 'members.phone', 'members.gender', 'members.address', 'users.email');
        $query->join('members','queues.member_id','=','members.id');
        $query->join('users','members.user_id','=','users.id');
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
                    ->setTableId('queue-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(0,'desc')
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
            Column::make('created_at'),
            Column::make('full_name'),
            Column::make('gender'),
            Column::make('email'),
            Column::make('phone'),
            Column::make('address'),
            Column::make('action')
                ->exportable(false)
                ->searchable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Waitinglist per ' . date('d M Y');
    }
}
