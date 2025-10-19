<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class MoneyMovement
 *
 * @property int $id
 * @property int|null $user_id
 * @property Carbon $movement_date
 * @property string $description
 * @property float $amount
 * @property string $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class MoneyMovement extends Model
{
    use HasFactory, SoftDeletes;

    public const TYPE_INCOME = 'income';
    public const TYPE_EXPENSE = 'expense';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'user_id',
        'movement_date',
        'description',
        'amount',
        'type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'movement_date' => 'date',
        'amount' => 'decimal:2',
        'type' => 'string',
    ];

    /**
     * Relation: MoneyMovement belongs to a User (optional)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /* -------------------- Scopes -------------------- */

    /**
     * Scope a query to only include a given type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for incomes.
     */
    public function scopeIncome($query)
    {
        return $query->ofType(self::TYPE_INCOME);
    }

    /**
     * Scope for expenses.
     */
    public function scopeExpense($query)
    {
        return $query->ofType(self::TYPE_EXPENSE);
    }

    /**
     * Scope between two dates (inclusive). Accepts string or Date instances.
     */
    public function scopeBetweenDates($query, $from = null, $to = null)
    {
        if ($from) {
            $query->whereDate('movement_date', '>=', $from);
        }

        if ($to) {
            $query->whereDate('movement_date', '<=', $to);
        }

        return $query;
    }

    /**
     * Scope results for a given user id or User model.
     */
    public function scopeForUser($query, $user)
    {
        $userId = $user instanceof User ? $user->getKey() : $user;
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a simple search against description and amount.
     */
    public function scopeSearch($query, ?string $term)
    {
        if (empty($term)) {
            return $query;
        }

        $term = trim($term);

        return $query->where(function ($q) use ($term) {
            $q->where('description', 'like', "%{$term}%")
                ->orWhere('amount', 'like', "%{$term}%");
        });
    }

    /**
     * Scope amount greater than (or equal if $orEqual true)
     */
    public function scopeAmountGreaterThan($query, $value, $orEqual = false)
    {
        $operator = $orEqual ? '>=' : '>';
        return $query->where('amount', $operator, $value);
    }
}
