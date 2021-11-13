<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMapping;
use Yajra\DataTables\Exports\DataTablesCollectionExport;
use App\Models\Course;

class MembersExport extends DataTablesCollectionExport implements WithMapping
{
    public function headings(): array
    {
        $headings = [
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

        foreach(Course::all() as $course){
            $headings[] = $course->name;
        }

        return $headings;
    }

    public function map($row): array
    {
        $rows = [
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
        
        foreach(Course::all() as $course){
            $rows[] = $row['course_'.$course->id];
        }

        return $rows;
    }
}