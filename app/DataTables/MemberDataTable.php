<?php

namespace App\DataTables;

use App\Models\Member;
use App\Models\Course;
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
        $datatable = datatables()
            ->eloquent($query)
            ->filterColumn('email', function($query, $keyword) {
                $sql = "users.email like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('address', function($query, $keyword) {
                $sql = "members.address like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('province', function($query, $keyword) {
                $sql = "provinces.name like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->editColumn('created_at', function($row){
                return $row->created_at->format('d-m-y');
            })
            ->editColumn('email', function($row){
                $value = $row->email;

                if($row->email_verified_at)
                    $value .= "(verified)";
                
                return $value;
            })
            ->editColumn('address', function($row){
                $address = $row->address;
                if($row->village)
                    $address .= ", ".$row->village;
                if($row->district)
                    $address .= ", ".$row->district;
                if($row->regency)
                    $address .= ", ".$row->regency;
                if($row->province)
                    $address .= ", ".$row->province;
                if($row->zipcode)
                    $address .= ", ".$row->zipcode;
                return $address;
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
        
        foreach(Course::all() as $course){
            $datatable->editColumn('course_'.$course->id, function($row) use ($course){
                $value = 'course_'.$course->id;
                if($row->$value!=null)
                    return __('batch.status_'.$row->$value);
                
                return "NA";
            });
        }

        return $datatable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Member $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Member $model)
    {
        $select = "members.*,users.email,users.name,users.login_at,users.email_verified_at"
        .",villages.name as village,districts.name as district,regencies.name as regency,provinces.name as province";
        
        foreach(Course::all() as $course){
            $select .= ",(SELECT max(status) FROM member_batch mb JOIN batches b ON mb.batch_id=b.id"
                    ." WHERE mb.member_id=members.id AND b.course_id=".$course->id.") AS course_".$course->id;
        }
        $model = $model->with('user')->newQuery();
        $model->selectRaw($select);
        $model->join('users','members.user_id','=','users.id');
        $model->leftJoin('villages','members.village_id','=','villages.id');
        $model->leftJoin('districts','villages.district_id','=','districts.id');
        $model->leftJoin('regencies','districts.regency_id','=','regencies.id');
        $model->leftJoin('provinces','regencies.province_id','=','provinces.id');
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
        $columns = [
            Column::make('created_at')->title('tgl daftar'),
            Column::make('full_name')->title('Nama'),
            Column::make('email'),
            Column::make('gender')->title('jenis kelamin'),
            Column::make('address')->title('alamat'),
            Column::make('province')->title('Propinsi'),
            Column::make('phone')->title('telp')
        ];
        
        foreach(Course::all() as $course)
        $columns[] = Column::make('course_'.$course->id)->title($course->name)->searchable(false);

        $columns[] = Column::make('login_at')->searchable(false)->title('terakhir login');
        $columns[] = Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center');

        return $columns;
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
