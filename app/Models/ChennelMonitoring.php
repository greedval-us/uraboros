<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChennelMonitoring extends Model
{
    use HasFactory;

    protected $table = 'chennels_monitoring';

    protected $fillable = [
        'chennel',
        'telegram_id',
        'last_request',
    ];

    protected $casts = [
        'last_request' => 'datetime',
    ];

    public function updateLastRequest(): bool
    {
        return $this->update([
            'last_request' => Carbon::now(),
        ]);
    }
}
