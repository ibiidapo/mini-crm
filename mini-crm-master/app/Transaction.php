<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * Make fields fillable for mass creation
     *
     * @var array
     */
    protected $fillable = [
            'client_id',
            'transaction_date',
            'amount',
    ];
    
    /**
     * Cast fields to appropriate type
     *
     * @var array
     */
    protected $casts = [
            'transaction_date' => 'datetime:Y-m-d',
            'amount'           => 'decimal:2',
    ];
    
    /**
     * A transaction belong to one client
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
