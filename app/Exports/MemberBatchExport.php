<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMapping;
use Yajra\DataTables\Exports\DataTablesCollectionExport;

class MemberBatchExport extends DataTablesCollectionExport implements WithMapping
{
    public function headings(): array
    {
        return [
            '#',
            'Email',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Alamat',
            'Telp',
            'Sesi',
            'Status',
            'Catatan',
        ];
    }

    public function map($row): array
    {
        return [
            $row['id'],
            $row['email'],
            $row['full_name'],
            $row['gender'],
            $row['address'],
            $row['phone'],
            $row['session'],
            $row['status'],
            $row['note'],
        ];
    }
}