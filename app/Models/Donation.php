<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'amount',
        'name',
        'email',
        'phone',
        'message',
        'donation_type',
        'payment_method',
        'status',
        'mpesa_checkout_request_id',
        'mpesa_receipt_number',
        'payment_completed_at',
        'payment_data',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_completed_at' => 'datetime',
        'payment_data' => 'array',
    ];

    /**
     * Generate a unique transaction ID
     */
    public static function generateTransactionId(): string
    {
        do {
            $transactionId = 'DON-' . strtoupper(uniqid());
        } while (self::where('transaction_id', $transactionId)->exists());

        return $transactionId;
    }

    /**
     * Check if donation is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if donation is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Mark donation as completed
     */
    public function markAsCompleted(string $receiptNumber = null): void
    {
        $this->update([
            'status' => 'completed',
            'mpesa_receipt_number' => $receiptNumber,
            'payment_completed_at' => now(),
        ]);
    }

    /**
     * Mark donation as failed
     */
    public function markAsFailed(): void
    {
        $this->update(['status' => 'failed']);
    }

    /**
     * Format amount for display
     */
    protected function formattedAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => 'KSh ' . number_format($this->amount, 2)
        );
    }

    /**
     * Get phone number in M-Pesa format (254XXXXXXXXX)
     */
    protected function mpesaPhone(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->phone) return null;
                
                $phone = preg_replace('/[^0-9]/', '', $this->phone);
                
                if (str_starts_with($phone, '0')) {
                    $phone = '254' . substr($phone, 1);
                } elseif (str_starts_with($phone, '+254')) {
                    $phone = substr($phone, 1);
                } elseif (!str_starts_with($phone, '254')) {
                    $phone = '254' . $phone;
                }
                
                return $phone;
            }
        );
    }

    /**
     * Scope for completed donations
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for pending donations
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for this month
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }
}