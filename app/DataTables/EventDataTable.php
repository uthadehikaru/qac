<?php

namespace App\DataTables;

use App\Models\Event;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EventDataTable extends DataTable
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
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '';
                if ($row->trashed()) {
                    $btn .= '<a href="#" class="ml-3 text-red-500">Deleted</a>';
                } else {
                    $btn .= '<a href="'.route('event.detail', $row->slug).'" target="_BLANK" class="ml-3 text-blue-500">View</a>';
                    $btn .= '<a href="'.route('admin.events.share', $row->id).'" class="ml-3 text-green-500">Share</a>';
                    $btn .= '<a href="'.route('admin.events.edit', $row->id).'" class="ml-3 text-yellow-500">Edit</a>';
                    $btn .= '<a href="#" id="delete-'.$row->id.'" class="delete ml-3 text-red-500" data-id="'.$row->id.'">Delete</a>';
                }

                return $btn;
            })
            ->editColumn('event_at', function ($row) {
                return $row->event_at->format('d M Y H:i');
            })
            ->editColumn('thumbnail', function ($row) {
                if ($row->thumbnail) {
                    return "<a href='".$row->imageUrl('thumbnail')."' target='_blank'><img src='".$row->imageUrl('thumbnail')."' width='300' /></a>";
                }

                return 'no image';
            })
            ->editColumn('attachment', function ($row) {
                if ($row->attachment) {
                    return "<a href='".$row->fileUrl('attachment')."' target='_blank' class='text-blue-500 pointer'>attachment</a>";
                }

                return 'no attachment';
            })
            ->editColumn('course_id', function ($row) {
                return $row->course ? $row->course->name : 'Umum';
            })
            ->rawColumns(['action', 'thumbnail', 'attachment']);
    }

    private $withTrashed = false;

    public function deleted()
    {
        $this->withTrashed = true;
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Event $model)
    {
        $query = $model->newQuery();
        $query->selectRaw("events.*, case when course_id>0 then (select coalesce(count(1),0) from member_batch where member_batch.status='6' AND EXISTS(SELECT 1 from batches b WHERE b.id=member_batch.batch_id AND b.course_id=events.course_id)) else (select count(1) from users where role='member') end as recipients");
        if ($this->withTrashed) {
            $query->withTrashed();
        }

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
            ->setTableId('event-table')
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
            Column::make('event_at'),
            Column::make('thumbnail'),
            Column::make('title'),
            Column::make('course_id')
                ->title('Umum/Alumni'),
            Column::make('views')
                ->searchable(false)
                ->title('dilihat'),
            Column::make('attachment'),
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
        return 'Event_'.date('YmdHis');
    }
}
