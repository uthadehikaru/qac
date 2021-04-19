<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMapping;
use Yajra\DataTables\Exports\DataTablesCollectionExport;

class MembersExport extends DataTablesCollectionExport implements WithMapping
{
    public function headings(): array
    {
        return [
            'Tanggal daftar',
            'Email',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Alamat',
            'Telp',
        ];
    }

    public function map($row): array
    {
        return [
            $row['created_at'],
            $row['email'],
            $row['full_name'],
            $row['gender'],
            $row['address'],
            $row['phone'],
        ];
    }
}