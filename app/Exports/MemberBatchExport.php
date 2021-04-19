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
            'Telp',
            'Session',
            'Status',
        ];
    }

    public function map($row): array
    {
        return [
            $row['email'],
            $row['name'],
            $row['gender'],
            $row['address'],
            $row['phone'],
            $row['session'],
            $row['status'],
        ];
    }
}