<?php
declare(strict_types=1);

namespace App;

use App\Contracts\Searchable;
use Illuminate\Database\Eloquent\Model;

class Client extends Model implements Searchable
{
    /**
     * Make fields fillable for mass creation
     *
     * @var array
     */
    protected $fillable = [
            'first_name',
            'last_name',
            'email',
            'avatar_path',
    ];
    
    /**
     * Cast fields to appropriate type
     *
     * @var array
     */
    protected $casts = [
            'first_name'  => 'string',
            'last_name'   => 'string',
            'email'       => 'string',
            'avatar_path' => 'string',
    
    ];
    
    protected $appends = ['info'];
    
    /**
     * Return full name
     *
     * @return string
     */
    public function getInfoAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    
    /**
     * Return a name for autocomplete
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->info;
    }
    
    /**
     * Return a description for autocomplete
     *
     * @return string
     */
    public function getDescription(): string
    {
        return 'Total Transactions:' . $this->transactions()
                                            ->count();
    }
    
    /**
     * A Client can have many transactions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
