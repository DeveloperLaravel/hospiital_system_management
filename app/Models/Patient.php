<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'national_id',
        'age',
        'gender',
        'phone',
        'blood_type',
        'address',
        'balance',
        'total_paid',
        'credit_limit',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'total_paid' => 'decimal:2',
        'credit_limit' => 'decimal:2',
        'age' => 'integer',
    ];

    // ==================== Accessors ====================

    /**
     * الحصول على الجنس باللغة العربية
     */
    public function getGenderArabicAttribute(): string
    {
        return match ($this->gender) {
            'male' => 'ذكر',
            'female' => 'أنثى',
            default => 'غير محدد',
        };
    }

    /**
     * الحصول على فصيلة الدم باللغة العربية
     */
    public function getBloodTypeArabicAttribute(): string
    {
        return match ($this->blood_type) {
            'A+' => 'A+ (موجب)',
            'A-' => 'A- (سالب)',
            'B+' => 'B+ (موجب)',
            'B-' => 'B- (سالب)',
            'AB+' => 'AB+ (موجب)',
            'AB-' => 'AB- (سالب)',
            'O+' => 'O+ (موجب)',
            'O-' => 'O- (سالب)',
            default => 'غير محددة',
        };
    }

    /**
     * تنسيق الرصيد المستحق
     */
    public function getFormattedBalanceAttribute(): string
    {
        return number_format($this->balance ?? 0, 2).' ₽';
    }

    /**
     * تنسيق إجمالي المدفوعات
     */
    public function getFormattedTotalPaidAttribute(): string
    {
        return number_format($this->total_paid ?? 0, 2).' ₽';
    }

    /**
     * تنسيق الحد الائتماني
     */
    public function getFormattedCreditLimitAttribute(): string
    {
        return number_format($this->credit_limit ?? 0, 2).' ₽';
    }

    /**
     * حالة الرصيد
     */
    public function getBalanceStatusAttribute(): string
    {
        if ($this->balance <= 0) {
            return 'مدفوع';
        } elseif ($this->isOverCreditLimit()) {
            return 'متأخر';
        } elseif ($this->balance > ($this->credit_limit ?? 0) * 0.8) {
            return 'تحذير';
        }

        return 'معلق';
    }

    /**
     * لون حالة الرصيد
     */
    public function getBalanceStatusColorAttribute(): string
    {
        return match ($this->balance_status) {
            'مدفوع' => 'green',
            'متأخر' => 'red',
            'تحذير' => 'yellow',
            default => 'gray',
        };
    }

    // ==================== Mutators ====================

    /**
     * تحويل الجنس لحروف صغيرة
     */
    public function setGenderAttribute($value): void
    {
        $this->attributes['gender'] = $value ? strtolower($value) : null;
    }

    /**
     * تحويل فصيلة الدم لحروف كبيرة
     */
    public function setBloodTypeAttribute($value): void
    {
        $this->attributes['blood_type'] = $value ? strtoupper($value) : null;
    }

    // ==================== Relationships ====================

    /**
     * علاقة المرضى بالمواعيد
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * علاقة المرضى بالسجلات الطبية
     */
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    /**
     * علاقة المرضى بالفواتير
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * علاقة المرضى بالوصفات الطبية
     */
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    /**
     * علاقة المرضى بالغرف
     */
    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'patient_rooms', 'patient_id', 'room_id')
            ->using(RoomPatient::class)
            ->withPivot(['admitted_at', 'discharged_at'])
            ->withTimestamps();
    }

    // ==================== Scopes ====================

    /**
     * البحث بالاسم أو رقم الهوية أو الهاتف
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('national_id', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    /**
     * تصفية حسب الجنس
     */
    public function scopeGender(Builder $query, ?string $gender): Builder
    {
        if ($gender && in_array($gender, ['male', 'female'])) {
            return $query->where('gender', $gender);
        }

        return $query;
    }

    /**
     * تصفية حسب فصيلة الدم
     */
    public function scopeBloodType(Builder $query, ?string $bloodType): Builder
    {
        if ($bloodType) {
            return $query->where('blood_type', strtoupper($bloodType));
        }

        return $query;
    }

    /**
     * تصفية المرضى الذين لديهم رصيد مستحق
     */
    public function scopeWithBalance(Builder $query): Builder
    {
        return $query->where('balance', '>', 0);
    }

    /**
     * تصفية المرضى المتأخرين في الدفع
     */
    public function scopeOverdue(Builder $query): Builder
    {
        return $query->whereColumn('balance', '>', 'credit_limit')
            ->where('credit_limit', '>', 0);
    }

    /**
     * تصفية المرضى بدون حد ائتماني
     */
    public function scopeNoCreditLimit(Builder $query): Builder
    {
        return $query->where('credit_limit', '<=', 0);
    }

    // ==================== Helper Methods ====================

    /**
     * الغرفة الحالية للمريض (إذا كان موجود)
     */
    public function currentRoom()
    {
        return $this->rooms()->wherePivotNull('discharged_at')->first();
    }

    /**
     * إضافة دفعة للمريض
     */
    public function addPayment(float $amount): void
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('مبلغ الدفعة يجب أن يكون أكبر من صفر');
        }

        // لا يمكن دفع أكثر من الرصيد المستحق
        $actualAmount = min($amount, $this->balance);

        // تقليل الرصيد المستحق
        $this->decrement('balance', $actualAmount);

        // زيادة إجمالي المدفوعات
        $this->increment('total_paid', $actualAmount);
    }

    /**
     * إضافة مبلغ للرصيد المستحق
     */
    public function addCharge(float $amount): void
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('مبلغ الرسوم يجب أن يكون أكبر من صفر');
        }

        $this->increment('balance', $amount);
    }

    /**
     * التحقق من تجاوز الحد الائتماني
     */
    public function isOverCreditLimit(): bool
    {
        return $this->balance > $this->credit_limit && $this->credit_limit > 0;
    }

    /**
     * الحصول على عدد المواعيد
     */
    public function getAppointmentsCountAttribute(): int
    {
        return $this->appointments()->count();
    }

    /**
     * الحصول على عدد السجلات الطبية
     */
    public function getMedicalRecordsCountAttribute(): int
    {
        return $this->medicalRecords()->count();
    }

    /**
     * الحصول على عدد الفواتير
     */
    public function getInvoicesCountAttribute(): int
    {
        return $this->invoices()->count();
    }

    /**
     * إجمالي الفواتير غير المدفوعة
     */
    public function getUnpaidInvoicesTotalAttribute(): float
    {
        return $this->invoices()
            ->where('status', 'pending')
            ->sum('total_amount');
    }

    /**
     * قائمة فصائل الدم المتاحة
     */
    public static function getBloodTypes(): array
    {
        return ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
    }
}
