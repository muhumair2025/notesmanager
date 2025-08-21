<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_PRINTING = 'printing';
    const STATUS_PACKAGING = 'packaging';
    const STATUS_DISPATCHED = 'dispatched';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'secondary_phone_number',
        'full_address',
        'city',
        'country',
        'semesters',
        'remarks',
        'fees_paid',
        'is_completed',
        'status',
        'tracking_id'
    ];

    protected $casts = [
        'semesters' => 'array',
        'is_completed' => 'boolean',
        'fees_paid' => 'boolean'
    ];

    public function getSemestersListAttribute()
    {
        return implode(', ', $this->semesters);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'badge-warning',
            'printing' => 'badge-info',
            'packaging' => 'badge-primary',
            'dispatched' => 'badge-secondary',
            'completed' => 'badge-success',
            'cancelled' => 'badge-danger'
        ];

        return $badges[$this->status] ?? 'badge-secondary';
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Pending',
            'printing' => 'Printing',
            'packaging' => 'Packaging',
            'dispatched' => 'Dispatched',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled'
        ];

        return $labels[$this->status] ?? 'Unknown';
    }

    public static function getStatusOptions()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PRINTING => 'Printing',
            self::STATUS_PACKAGING => 'Packaging',
            self::STATUS_DISPATCHED => 'Dispatched',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled'
        ];
    }

    public function getFeesPaidBadgeAttribute()
    {
        return $this->fees_paid ? 'badge-success' : 'badge-danger';
    }

    public function getFeesPaidLabelAttribute()
    {
        return $this->fees_paid ? 'Paid' : 'Pending';
    }
}
