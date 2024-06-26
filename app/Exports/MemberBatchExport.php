<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMapping;
use Yajra\DataTables\Exports\DataTablesCollectionExport;

class MemberBatchExport extends DataTablesCollectionExport implements WithMapping
{
    public function headings(): array
    {
        return [
            'Email',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Alamat',
            'Propinsi',
            'Telp',
            'Sesi',
            'New Book',
            'Re Seat',
            'Status',
            'Catatan',
            'Testimoni',
        ];
    }

    public function map($row): array
    {
        return [
            $row['email'],
            $row['full_name'],
            $row['gender'],
            $row['address'],
            $row['province'],
            $row['phone'],
            $row['session'],
            $row['new_book'],
            $row['reseat'],
            $row['status'],
            $row['note'],
            $row['testimonial'],
        ];
    }
}
