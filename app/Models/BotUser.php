<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BotUser extends Model
{
    use HasFactory;

    protected $table = 'bot_users';

    protected $fillable = [
        'telegram_id',
        'username',
        'first_name',
        'last_name',
        'requests',
        'count_requests',
        'last_request_at',
        'premium',
        'premium_start',
        'premium_end',
        'free_requests_reset_at',
        'lang',
        'referral_code',
        'referral_count',
        'referred_by',
        'blocked',
    ];

    protected $casts = [
        'telegram_id' => 'integer',
        'requests' => 'integer',
        'count_requests' => 'integer',
        'last_request_at' => 'datetime',
        'premium' => 'boolean',
        'premium_start' => 'datetime',
        'premium_end' => 'datetime',
        'free_requests_reset_at' => 'datetime',
        'referral_count' => 'integer',
        'referred_by' => 'integer',
        'blocked' => 'boolean',
    ];

    /**
     * Генерация уникального реферального кода при создании пользователя
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->referral_code)) {
                $user->referral_code = self::generateReferralCode();
            }
        });
    }

    /**
     * Генерация случайного уникального реферального кода
     */
    public static function generateReferralCode($length = 8)
    {
        do {
            $code = Str::upper(Str::random($length));
        } while (self::where('referral_code', $code)->exists());

        return $code;
    }

    /**
     * Проверка, активен ли премиум
     */
    public function isPremium(): bool
    {
        return $this->premium && $this->premium_end && $this->premium_end->isFuture();
    }

    /**
     * Пользователь, который пригласил этого пользователя
     */
    public function referrer()
    {
        return $this->belongsTo(BotUser::class, 'referred_by');
    }

    /**
     * Пользователи, которых пригласил этот пользователь
     */
    public function referrals()
    {
        return $this->hasMany(BotUser::class, 'referred_by');
    }

    /**
     * Получение бессплатных запросов
     */
    public function activateFreeRequests(): self
    {
        $now = Carbon::now();
        $nextActivation = $this->free_requests_reset_at
            ? $this->free_requests_reset_at->copy()->addDay()
            : null;

        if (!$this->free_requests_reset_at || $now->greaterThanOrEqualTo($nextActivation)) {
            $this->requests += 5;
            $this->free_requests_reset_at = $now;
            $this->save();
        }

        return $this;
    }

    /**
    * Привязать пользователя к рефереру по коду
    */
    public function applyReferralCode(string $referralCode): bool
    {
        if ($this->referral_code === $referralCode) {
            return false;
        }

        if ($this->referred_by) {
            return false;
        }

        $referrer = self::where('referral_code', $referralCode)->first();

        if (!$referrer) {
            return false;
        }

        $this->referred_by = $referrer->id;
        $this->save();

        $referrer->increment('referral_count');

        return true;
    }

    public function hasRequests(int $amount = 1): bool
    {
        if ($this->blocked) {
            return false;
        }

        return $this->requests >= $amount;
    }

    public function consumeRequest(int $amount = 1): bool
    {
        if ($this->blocked) {
            return false;
        }

        $updated = self::where('telegram_id', $this->id)
            ->where('requests', '>=', $amount)
            ->update([
                'requests' => DB::raw("requests - $amount"),
                'count_requests' => DB::raw("count_requests + $amount"),
                'last_request_at' => now(),
            ]);

        return $updated > 0;
    }
}
