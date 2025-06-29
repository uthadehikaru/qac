<?php

namespace App\DataTables;

use App\Exports\MemberBatchExport;
use App\Models\Batch;
use App\Models\MemberBatch;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MemberBatchDataTable extends DataTable
{
    protected string $exportClass = MemberBatchExport::class;

    private $batch_id = 0;

    public function setBatch($batch_id)
    {
        $this->batch_id = $batch_id;
    }

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
            ->filterColumn('full_name', function ($query, $keyword) {
                $sql = 'members.full_name like ?';
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('gender', function ($query, $keyword) {
                $sql = 'members.gender like ?';
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('address', function ($query, $keyword) {
                $sql = 'members.address like ?';
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('phone', function ($query, $keyword) {
                $sql = 'members.phone like ?';
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('province', function ($query, $keyword) {
                $sql = 'provinces.name like ?';
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('email', function ($query, $keyword) {
                $sql = 'users.email like ?';
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('status', function ($query, $keyword) {
                $keyword = strtolower($keyword);
                $statuses = ['batal', 'terdaftar', 'assesment selesai', 'pembayaran lunas', 'modul dikirim', 'persyaratan lengkap', 'lulus'];
                $key = array_search($keyword, $statuses);
                if ($key) {
                    $sql = 'member_batch.status='.$key;
                    $query->whereRaw($sql);
                }
            })
            ->editColumn('status', function ($row) {
                $value = __('batch.status_'.$row->status);
                if ($row->status != 0 && $row->status < 6) {
                    $nextStatus = $row->status == 1 ? $row->status + 2 : $row->status + 1;
                    $value .= ' <a href="'.route('admin.courses.batches.members.status', ['course' => $row->batch->course_id, 'batch' => $row->batch_id, 'id' => $row->id, 'status' => $nextStatus]).'" class="text-blue-500 pointer">('.__('batch.status_'.$nextStatus).')</a>';
                }

                return $value;
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="'.route('admin.members.show', $row->member_id).'" class="text-blue-500">Detail</a>';
                $btn .= '<a href="'.route('admin.courses.batches.members.edit', ['course' => $row->batch->course_id, 'batch' => $row->batch_id, 'id' => $row->id]).'" class="ml-3 text-green-500">Edit</a>';
                $btn .= '<a href="#" id="delete-'.$row->id.'" data-id="'.$row->id.'" class="delete ml-3 text-red-500">Delete</a>';
                if ($row->file) {
                    $btn .= '<a target="_blank" href="'.$row->file->fileUrl('filename').'" class="ml-3 text-green-500">Sertifikat</a>';
                }

                return $btn;
            })
            ->editColumn('id', function ($row) {
                return "<input type='checkbox' id='row-".$row->id."' value='".$row->id."' name='ids' onClick='check(this)'  />";
            })
            ->editColumn('reseat', function ($row) {
                return $row->reseat ? 'Ya' : 'Tidak';
            })
            ->rawColumns(['action', 'phone', 'status', 'id']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MemberBatch $model)
    {
        $query = $model->newQuery();
        $query->select('member_batch.*', 'members.full_name', 'members.phone', 'members.gender', 'members.address', 'users.email', 'provinces.name as province');
        $query->join('members', 'member_batch.member_id', '=', 'members.id');
        $query->join('users', 'members.user_id', '=', 'users.id');
        $query->leftJoin('villages', 'members.village_id', '=', 'villages.id');
        $query->leftJoin('districts', 'villages.district_id', '=', 'districts.id');
        $query->leftJoin('regencies', 'districts.regency_id', '=', 'regencies.id');
        $query->leftJoin('provinces', 'regencies.province_id', '=', 'provinces.id');

        $query->where('batch_id', $this->batch_id);

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
            ->setTableId('memberbatch-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0)
            ->pageLength(100)
            ->scrollX(true)
            ->autoWidth(false)
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
            Column::make('id')->title('#')
                ->searchable(false)
                ->orderable(false),
            Column::make('full_name')->title('Nama'),
            Column::make('gender')->title('Jenis Kelamin'),
            Column::make('email')->title('Email'),
            Column::make('address')->title('alamat'),
            Column::make('province')->title('Propinsi'),
            Column::make('phone')->title('Telp'),
            Column::make('session')->title('Sesi'),
            Column::make('reseat')->title('Reseat'),
            Column::make('status'),
            Column::make('note')->title('Catatan'),
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
        $batch = Batch::find($this->batch_id);

        return 'Data Peserta Kelas '.$batch->full_name.' per '.date('d M Y');
    }
}
