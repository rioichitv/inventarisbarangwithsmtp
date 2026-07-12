<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'username',
        'email',
        'ip_address',
        'activity_type',
        'status',
        'level',
        'user_agent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Tentukan level otomatis berdasarkan activity_type dan status
    public static function detectLevel(string $activityType, string $status): string
    {
        if ($status === 'Gagal') return 'Berisiko';
        if (in_array($activityType, ['logout', 'login'])) return 'Low';
        return 'Medium';
    }
}
