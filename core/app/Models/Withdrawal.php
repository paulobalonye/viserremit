<?php

namespace App\Models;

use Carbon\Carbon;
use App\Constants\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Withdrawal extends Model
{
    protected $casts = [
        'withdraw_information' => 'object'
    ];

    protected $hidden = [
        'withdraw_information'
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function method()
    {
        return $this->belongsTo(WithdrawMethod::class, 'method_id');
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::PAYMENT_PENDING) {
                $html = '<span class="badge badge--warning">' . trans('Pending') . '</span>';
            } elseif ($this->status == Status::PAYMENT_SUCCESS) {
                $html = '<span><span class="badge badge--success">' . trans('Approved') . '</span><br>' . diffForHumans($this->updated_at) . '</span>';
            } elseif ($this->status == Status::PAYMENT_REJECT) {
                $html = '<span><span class="badge badge--danger">' . trans('Rejected') . '</span><br>' . diffForHumans($this->updated_at) . '</span>';
            }
            return $html;
        });
    }

    public function scopePending($query)
    {
        return $query->where('status', Status::PAYMENT_PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', Status::PAYMENT_SUCCESS);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', Status::PAYMENT_REJECT);
    }

    public function scopeFilterAgent($query)
    {
        return $query->where('agent_id', @auth()->guard('agent')->id());
    }

    public function scopeFilterByDay($query, $day = 7)
    {
        return $query->whereDate('created_at', '>=', Carbon::now()->subDays($day));
    }
}
