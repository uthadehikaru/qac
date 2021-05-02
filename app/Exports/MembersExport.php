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
            'Nama Panggilan',
            'Jenis Kelamin',
            'Alamat',
            'Telp',
            'Kota',
            'Profesi',
            'Pendidikan',
            'Instagram',
        ];
    }

    public function map($row): array
    {
        return [
            $row['created_at'],
            $row['email'],
            $row['full_name'],
            $row['name'],
            $row['gender'],
            $row['address'],
            $row['phone'],
            $row['city'],
            $row['profesi'],
            $row['pendidikan'],
            $row['instagram'],
        ];
    }
}