<?php
namespace App\Traits;

use App\Constants\Status;

trait UserNotify
{
    public static function notifyToUser($userType){
        if ($userType == 'user') {
            return [
                'allUsers'               => 'All Users',
                'selectedUsers'          => 'Selected Users',
                'kycUnverified'          => 'Kyc Unverified Users',
                'kycVerified'            => 'Kyc Verified Users',
                'kycPending'             => 'Kyc Pending Users',
                'withBalance'            => 'With Balance Users',
                'emptyBalanceUsers'      => 'Empty Balance Users',
                'twoFaDisableUsers'      => '2FA Disable User',
                'twoFaEnableUsers'       => '2FA Enable User',
                'pendingTicketUser'      => 'Pending Ticket Users',
                'answerTicketUser'       => 'Answer Ticket Users',
                'closedTicketUser'       => 'Closed Ticket Users',
                'notLoginUsers'          => 'Last Few Days Not Login Users',
            ];
        }else{
            return [
                'allUsers'               => 'All Agents',
                'selectedUsers'          => 'Selected Agents',
                'kycUnverified'          => 'Kyc Unverified Agents',
                'kycVerified'            => 'Kyc Verified Agents',
                'kycPending'             => 'Kyc Pending Agents',
                'withBalance'            => 'With Balance Agents',
                'emptyBalanceUsers'      => 'Empty Balance Agents',
                'twoFaDisableUsers'      => '2FA Disable User',
                'twoFaEnableUsers'       => '2FA Enable User',
                'hasDepositedUsers'      => 'Deposited Agents',
                'notDepositedUsers'      => 'Not Deposited Agents',
                'pendingDepositedUsers'  => 'Pending Deposited Agents',
                'rejectedDepositedUsers' => 'Rejected Deposited Agents',
                'topDepositedUsers'      => 'Top Deposited Agents',
                'hasWithdrawUsers'       => 'Withdraw Agents',
                'pendingWithdrawUsers'   => 'Pending Withdraw Agents',
                'rejectedWithdrawUsers'  => 'Rejected Withdraw Agents',
                'pendingTicketUser'      => 'Pending Ticket Agents',
                'answerTicketUser'       => 'Answer Ticket Agents',
                'closedTicketUser'       => 'Closed Ticket Agents',
                'notLoginUsers'          => 'Last Few Days Not Login Agents',
            ];
        }
    }

    public function scopeSelectedUsers($query)
    {
        return $query->whereIn('id', request()->user ?? []);
    }

    public function scopeAllUsers($query)
    {
        return $query;
    }

    public function scopeEmptyBalanceUsers($query)
    {
        return $query->where('balance', '<=', 0);
    }

    public function scopeTwoFaDisableUsers($query)
    {
        return $query->where('ts', Status::DISABLE);
    }

    public function scopeTwoFaEnableUsers($query)
    {
        return $query->where('ts', Status::ENABLE);
    }

    public function scopeHasDepositedUsers($query)
    {
        return $query->whereHas('deposits', function ($deposit) {
            $deposit->successful();
        });
    }

    public function scopeNotDepositedUsers($query)
    {
        return $query->whereDoesntHave('deposits', function ($q) {
            $q->successful();
        });
    }

    public function scopePendingDepositedUsers($query)
    {
        return $query->whereHas('deposits', function ($deposit) {
            $deposit->pending();
        });
    }

    public function scopeRejectedDepositedUsers($query)
    {
        return $query->whereHas('deposits', function ($deposit) {
            $deposit->rejected();
        });
    }

    public function scopeTopDepositedUsers($query)
    {
        return $query->whereHas('deposits', function ($deposit) {
            $deposit->successful();
        })->withSum(['deposits'=>function($q){
            $q->successful();
        }], 'amount')->orderBy('deposits_sum_amount', 'desc')->take(request()->number_of_top_deposited_user ?? 10);
    }

    public function scopeHasWithdrawUsers($query)
    {
        return $query->whereHas('withdrawals', function ($q) {
            $q->approved();
        });
    }

    public function scopePendingWithdrawUsers($query)
    {
        return $query->whereHas('withdrawals', function ($q) {
            $q->pending();
        });
    }

    public function scopeRejectedWithdrawUsers($query)
    {
        return $query->whereHas('withdrawals', function ($q) {
            $q->rejected();
        });
    }

    public function scopePendingTicketUser($query)
    {
        return $query->whereHas('tickets', function ($q) {
            $q->whereIn('status', [Status::TICKET_OPEN, Status::TICKET_REPLY]);
        });
    }

    public function scopeClosedTicketUser($query)
    {
        return $query->whereHas('tickets', function ($q) {
            $q->where('status', Status::TICKET_CLOSE);
        });
    }

    public function scopeAnswerTicketUser($query)
    {
        return $query->whereHas('tickets', function ($q) {

            $q->where('status', Status::TICKET_ANSWER);
        });
    }

    public function scopeNotLoginUsers($query)
    {
        return $query->whereDoesntHave('loginLogs', function ($q) {
            $q->whereDate('created_at', '>=', now()->subDays(request()->number_of_days ?? 10));
        });
    }

    public function scopeKycVerified($query)
    {
        return $query->where('kv', Status::KYC_VERIFIED);
    }

}
