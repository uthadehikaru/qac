<?php

namespace App\DataTables;

use App\Models\Member;
use App\Exports\MembersExport;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MemberDataTable extends DataTable
{
    protected $exportClass = MembersExport::class;

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
            ->filterColumn('email', function($query, $keyword) {
                $sql = "users.email like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->editColumn('created_at', function($row){
                return $row->created_at->format('d-m-y');
            })
            ->editColumn('login_at', function($row){
                if($row->login_at){
                    return $row->login_at->format('d-m-y H:i');
                }
                
                return "-";
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
        $model = $model->newQuery();
        $model->select('members.*','users.email','users.name','users.login_at');
        $model->join('users','members.user_id','=','users.id');
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
                    ->setTableId('member-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(0)
                    ->pageLength(100)
                    ->scrollX(true)
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
            Column::make('created_at')->title('tgl daftar'),
            Column::make('full_name')->title('Nama'),
            Column::make('email'),
            Column::make('gender')->title('jenis kelamin'),
            Column::make('address')->title('alamat'),
            Column::make('city')->title('kota'),
            Column::make('phone')->title('telp'),
            Column::make('login_at')->title('terakhir login'),
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
        return 'Data Anggota per ' . date('j M Y');
    }
}
