<?php
namespace App\Models;

use App\Enums\ProductStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPossession extends Model
{
    use SoftDeletes;
    //
    protected $table    = 'product_posessions';
    protected $fillable = [
        'product_id',
        'original_owner',
        'current_owner',
        'status',
        'release_date',
        'transferred_date',
        'returned_date',
        'notes',
    ];

    protected $casts = [
        'status'           => ProductStatusEnum::class,
        'release_date'     => 'date',
        'transferred_date' => 'date',
        'returned_date'    => 'date',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function originalOwner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'original_owner');
    }

    public function currentOwner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'current_owner');
    }
}
