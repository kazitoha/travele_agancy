<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customers extends Model
{
    use LogsActivity;

    protected $table = 'customers';

    protected $fillable = [
        'companies_id',
        'user_id',
        'passport_number',
        'name',
        'email',
        'phone',
        'date_of_birth',
        'address',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Companies::class, 'companies_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
