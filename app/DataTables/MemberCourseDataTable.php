<?php

namespace App\DataTables;

use App\Models\Batch;
use App\Models\MemberBatch;
use App\Exports\MemberBatchExport;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MemberCourseDataTable extends DataTable
{
    protected $exportClass = MemberBatchExport::class;

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
            ->filterColumn('email', function($query, $keyword) {
                $sql = "users.email like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('status', function($query, $keyword) {
                $keyword = strtolower($keyword);
                $statuses = ['batal','terdaftar','assesment selesai','pembayaran lunas','modul dikirim','persyaratan lengkap','lulus'];
                $key = array_search($keyword, $statuses);
                if($key){
                    $sql = "member_batch.status=".$key;
                    $query->whereRaw($sql);
                }
            })
            ->editColumn('status',function($row){
                $value = __('batch.status_'.$row->status);
                return $value;
            })
            ->rawColumns(['status']);
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
        $query->select('member_batch.*', 'members.full_name', 'members.phone', 'members.gender', 'members.address', 'users.email');
        $query->join('members','member_batch.member_id','=','members.id');
        $query->join('users','members.user_id','=','users.id');
        $query->whereRaw("EXISTS(SELECT 1 from batches b WHERE b.id=member_batch.batch_id AND b.course_id=".$this->course_id.")");
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
                    ->orderBy(1)
                    ->buttons(
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
            Column::make('session')->title('Sesi'),
            Column::make('status'),
            Column::make('note')->title('Catatan'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        $course = Course::find($this->course_id);
        return 'Data Peserta Kelas ' . $course->name . ' per ' . date('d M Y');
    }
}
