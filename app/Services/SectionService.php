<?php

namespace App\Services;

use App\Models\Section;

class SectionService
{
    public function updateOrCreate($data): Section
    {
        if ($data['id']) {
            $section = Section::find($data['id']);
            $section->update($data);

            return $section;
        }

        return Section::create($data);
    }

    public function find($id): Section
    {
        return Section::find($id);
    }

    public function findBySlug($slug): Section
    {
        return Section::where('slug', $slug)->first();
    }
}
