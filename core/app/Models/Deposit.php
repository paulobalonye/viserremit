<?php

namespace App\Models;

use Carbon\Carbon;
use App\Constants\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Deposit extends Model
{
    protected $casts = [
        'detail' => 'object'
    ];

    protected $hidden = ['detail'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function gateway()
    {
        return $this->belongsTo(Gateway::class, 'method_code', 'code');
    }

    public function sendMoney()
    {
        return $this->belongsTo(SendMoney::class);
    }

    public function methodName()
    {
        if ($this->method_code < 5000) {
            $methodName = @$this->gatewayCurrency()->name;
        } else {
            $methodName = 'Google Pay';
        }
        return $methodName;
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::PAYMENT_PENDING) {
                $html = '<span class="badge badge--warning">' . trans('Pending') . '</span>';
            } elseif ($this->status == Status::PAYMENT_SUCCESS && $this->method_code >= 1000 && $this->method_code <= 5000) {
                $html = '<span><span class="badge badge--success">' . trans('Approved') . '</span><br>' . diffForHumans($this->updated_at) . '</span>';
            } elseif ($this->status == Status::PAYMENT_SUCCESS && ($this->method_code < 1000 || $this->method_code >= 5000)) {
                $html = '<span class="badge badge--success">' . trans('Succeed') . '</span>';
            } elseif ($this->status == Status::PAYMENT_REJECT) {
                $html = '<span><span class="badge badge--danger">' . trans('Rejected') . '</span><br>' . diffForHumans($this->updated_at) . '</span>';
            } else {
                $html = '<span class="badge badge--dark">' . trans('Initiated') . '</span>';
            }
            return $html;
        });
    }

    // scope
    public function gatewayCurrency()
    {
        return GatewayCurrency::where('method_code', $this->method_code)->where('currency', $this->method_currency)->first();
    }

    public function baseCurrency()
    {
        return @$this->gateway->crypto == Status::ENABLE ? 'USD' : $this->method_currency;
    }

    public function scopePending($query)
    {
        return $query->where('method_code', '>=', 1000)->where('status', Status::PAYMENT_PENDING);
    }

    public function scopeRejected($query)
    {
        return $query->where('method_code', '>=', 1000)->where('status', Status::PAYMENT_REJECT);
    }

    public function scopeApproved($query)
    {
        return $query->where('method_code', '>=', 1000)->where('method_code', '<', 5000)->where('status', Status::PAYMENT_SUCCESS);
    }

    public function scopeSuccessful($query)
    {
        return $query->where('status', Status::PAYMENT_SUCCESS);
    }

    public function scopeInitiated($query)
    {
        return $query->where('status', Status::PAYMENT_INITIATE);
    }

    public function scopePayment($query)
    {
        return $query->where('user_id', '!=', 0);
    }

    public function scopeAgentDeposit($query)
    {
        return $query->where('agent_id', '!=', 0);
    }

    public function scopeFilterAgent($query)
    {
        return $query->where('agent_id', @auth()->guard('agent')->id());
    }

    public function scopeFilterUser($query)
    {
        return $query->where('user_id', @auth()->id());
    }

    public function scopeFilterByDay($query, $day = 7)
    {
        return $query->whereDate('created_at', '>=', Carbon::now()->subDays($day));
    }
}
