<?php

namespace App\DataTables;

use App\Models\CompletedLesson;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SubscriptionsDataTable extends DataTable
{

    private $ecourse_id = 0;
    private $lesson_id = 0;

    public function setEcourse($ecourse_id)
    {
        $this->ecourse_id = $ecourse_id;
    }

    public function setLesson($lesson_id)
    {
        $this->lesson_id = $lesson_id;
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
            ->filterColumn('member_id', function($query, $keyword) {
                $query->whereHas('member', function($query) use($keyword){
                    $query->where('full_name','like','%'.$keyword.'%');
                });
            })
            ->editColumn('member_id', function($row){
                return $row->member->full_name;
            })
            ->editColumn('status', function($row){
                $active = Carbon::now()->betweenIncluded($row->start_date,$row->end_date);
                if($active)
                    return "<span class='text-sm p-2 border rounded bg-blue-500 text-white'>Aktif</span>";
                
                return "<span class='text-sm p-2 border rounded bg-red-500 text-white'>Inaktif</span>";
            })
            ->addColumn('completed_lessons', function($row){
                $completes = CompletedLesson::whereRelation('lesson','ecourse_id',$row->ecourse_id)
                ->where('member_id',$row->member_id)
                ->with('lesson');
                if($this->lesson_id>0)
                    $completes = $completes->where('lesson_id', $this->lesson_id);

                $data = [];
                foreach($completes->get() as $complete){
                    $data[] = $complete->lesson->subject;
                }
                return collect($data)->join(',');
            })
            ->addColumn('action', function($row){
                $btn = "";
                $btn .= '<a href="'.route('admin.ecourses.subscriptions.edit', [$row->ecourse_id, $row->id]).'" class="ml-3 text-yellow-500">Edit</a>';
                $btn .= '<a href="#" id="delete-'.$row->id.'" class="delete ml-3 text-red-500" data-id="'.$row->id.'">Delete</a>';
                return $btn;
            })
            ->rawColumns(['template','action','status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Subscription $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Subscription $model)
    {
        $model = $model->newQuery()
        ->with('member')
        ->where('ecourse_id',$this->ecourse_id);

        if($this->lesson_id){
            $model = $model->whereRaw(DB::raw("exists(select 1 from completed_lessons cl
            join lessons l on cl.lesson_id= l.id where l.ecourse_id=subscriptions.ecourse_id and subscriptions.member_id = cl.member_id and cl.lesson_id=".$this->lesson_id.")"));
        }

        return $model;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('subscription-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(0)
                    ->buttons(
                        Button::make('create'),
                        Button::make('reload'),
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
            Column::make('member_id')->title('Member'),
            Column::make('completed_lessons'),
            Column::make('start_date'),
            Column::make('end_date'),
            Column::make('status')->searchable(false)
            ->orderable(false),
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
        return 'Subscription_' . date('YmdHis');
    }
 
    public function batch()
    {
        //...your code here.
    }
}
