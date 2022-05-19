<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMapping;
use Yajra\DataTables\Exports\DataTablesCollectionExport;
use App\Models\Course;
use App\Models\Member;

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
            'Propinsi/Kota',
            'Telp',
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
        $member = Member::find($row['id']);

        $rows = [
            $row['created_at'],
            $row['email'],
            $row['full_name'],
            $row['name'],
            $row['gender'],
            $member->address_detail,
            $member->province,
            $row['phone'],
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