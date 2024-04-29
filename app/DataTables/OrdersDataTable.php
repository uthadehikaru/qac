<?php

namespace App\DataTables;

use App\Models\Order;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OrdersDataTable extends DataTable
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
            ->filterColumn('member_id', function ($query, $keyword) {
                $query->whereHas('member', function ($query) use ($keyword) {
                    $query->where('full_name', 'like', '%'.$keyword.'%');
                });
            })
            ->filterColumn('status', function ($query, $keyword) {
                if ($keyword == 'aktif') {
                    $query->where('start_date', '<=', date('Y-m-d'));
                    $query->where('end_date', '>=', date('Y-m-d'));
                }
            })
            ->editColumn('status', function ($row) {
                $active = Carbon::now()->betweenIncluded($row->start_date, $row->end_date);
                if ($active) {
                    return "<span class='text-sm p-2 border rounded bg-blue-500 text-white'>Aktif</span>";
                }

                return "<span class='text-sm p-2 border rounded bg-red-500 text-white'>Inaktif</span>";
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d M Y H:i');
            })
            ->editColumn('verified_at', function ($row) {
                return $row->verified_at?->format('d M Y H:i');
            })
            ->editColumn('member_id', function ($row) {
                return $row->member->full_name;
            })
            ->editColumn('start_date', function ($row) {
                return $row->start_date?->format('d M Y').' - '.$row->end_date?->format('d M Y');
            })
            ->editColumn('price', function ($row) {
                return number_format($row->price, 0, ',', '.');
            })
            ->editColumn('total', function ($row) {
                return number_format($row->total, 0, ',', '.');
            })
            ->addColumn('action', function ($row) {
                $btn = '';
                if (! $row->verified_at) {
                    $btn .= '<a href="'.route('admin.orders.verify', $row->id).'" class="ml-3 text-blue-500">Konfirmasi</a>';
                }
                $btn .= '<a href="#" id="delete-'.$row->id.'" class="delete ml-3 text-red-500" data-id="'.$row->id.'">Delete</a>';

                return $btn;
            })
            ->rawColumns(['action', 'status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
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
            ->setTableId('order-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0, 'asc')
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
            Column::make('created_at'),
            Column::make('member_id')->title('Member'),
            Column::make('price'),
            Column::make('months')->title('Jumlah Bulan'),
            Column::make('total'),
            Column::make('start_date')->title('Tgl Aktif'),
            Column::make('status')->title('Status')->orderable(false),
            Column::make('verified_at'),
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
        return 'Order_'.date('YmdHis');
    }
}
