<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\File;
use App\Notifications\CertificateCreated;
use App\Models\Member;
use App\Models\MemberBatch;
use App\Models\System;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class MemberService
{
    public function isAlumni($member_id)
    {
        return Cache::remember('member_is_alumni_'.$member_id, 3600, function () use ($member_id) {
            $member = Member::with(['batches', 'courses'])->find($member_id);
            return $member->batches->contains(function ($memberBatch, $key) {
                return $memberBatch->pivot->status >= MemberBatch::STATUS_PAID 
                    && $memberBatch->course->level >= 1;
            });
        });
    }

    

    /**
     * Check if user is registered on an active batch for the given course
     */
    public function checkMemberActiveBatch($memberId, $courseId, $isLite = false)
    {
        $memberBatch = MemberBatch::where('member_id', $memberId)
            ->whereHas('batch', function ($query) use ($courseId, $isLite) {
                $query->where('course_id', $courseId)
                ->when(!$isLite, function ($query) {
                    $query->where('start_at', '<=', now())
                        ->where('end_at', '>=', now());
                });
            })
            ->where('status', '>=', MemberBatch::STATUS_PAID)
            ->first();
        if($isLite && $memberBatch){
            $approved_at = $memberBatch->approved_at;
            $duration = System::value('ecourse_access_months', 1);
            if($memberBatch->session == 'bundling'){
                $duration = $duration * 2;
            }
            $end_course = Carbon::parse($approved_at)->addMonths($duration);
            if($end_course->isPast()){
                return null;
            }
        }
        return $memberBatch;
    }

    

    public function generateCertificate(Certificate $template, MemberBatch $memberBatch, $preview = false)
    {
        $name = 'certificate '.$memberBatch->batch->full_name.'-'.$memberBatch->member->full_name.'-'.$memberBatch->member->id;
        $config = json_decode($template->config, true);

        $certificate = Image::make(storage_path('app/public/'.$template->template))
            ->resize($config['sertifikat']['width'], $config['sertifikat']['height']);

        if (isset($config['nama_anggota'])) {
            $certificate->text(Str::title($memberBatch->member->full_name), $config['nama_anggota']['position_x'], $config['nama_anggota']['position_y'], function ($font) use ($config) {
                $font->file(public_path('Roboto-Regular.ttf'));
                $font->size($config['nama_anggota']['font_size']);
                $font->color('#000000');
                $font->align('center');
                $font->valign('top');
            });
        }

        if (! $memberBatch->member_batch_uu) {
            $memberBatch->member_batch_uu = Str::random(10);
            $memberBatch->save();
        }

        if (isset($config['qrcode'])) {
            $qr = QrCode::create(route('certificate', $memberBatch->member_batch_uu))->setSize(150);
            $writer = new PngWriter();
            $result = $writer->write($qr);
            $certificate->insert($result->getString(), $config['qrcode']['position'], $config['qrcode']['position_x'], $config['qrcode']['position_y']);
        }

        if (isset($config['unique_code'])) {
            $certificate->text($memberBatch->member_batch_uu, $config['unique_code']['position_x'], $config['unique_code']['position_y'], function ($font) use ($config) {
                $font->file(public_path('Roboto-Regular.ttf'));
                $font->size($config['unique_code']['font_size']);
                $font->color('#000000');
                $font->align('center');
                $font->valign('top');
            });
        }

        if (isset($config['footer'])) {
            $certificate->text('*scan barcode untuk verifikasi keaslian sertifikat', $config['footer']['position_x'], $config['footer']['position_y'], function ($font) use ($config) {
                $font->file(public_path('Roboto-Regular.ttf'));
                $font->size($config['footer']['font_size']);
                $font->color('#000000');
                $font->align('left');
                $font->valign('bottom');
            });
        }

        $filepath = 'files/'.$name.'.jpg';
        $certificate->save(storage_path('app/public/'.$filepath), 90, 'jpg');

        $file = File::where(['tablename' => 'member_batch', 'record_id' => $memberBatch->id])->first();

        if (! $file) {
            $file = File::create([
                'created_at' => Carbon::now(),
                'name' => $name,
                'filename' => $filepath,
                'tablename' => 'member_batch',
                'record_id' => $memberBatch->id,
                'type' => 'jpg',
                'size' => 0,
            ]);
        }

        $file->name = $name;
        $file->filename = $filepath;
        $file->updated_at = Carbon::now();
        $file->save();

        $memberBatch->member->user->notify(new CertificateCreated($memberBatch));

        if ($preview) {
            return $certificate->response('png');
        }

    }

}