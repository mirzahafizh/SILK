<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Verifikasi extends Model
{
    use HasFactory;

    protected $table = 'verifikasi';

    protected $fillable = [
        'laporan_id',
        'verifikator_id',
        'status',
        'catatan',
        'tanggal_verifikasi',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_verifikasi' => 'datetime',
        ];
    }

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class);
    }

    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verifikator_id');
    }
}