<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property TransactionPackage[] $transactionPackages
 * @property int $id_transaction
 * @property int $grand_total
 * @property string $status
 * @property int $touris_count
 * @property string $barcode
 * @property string $created_at
 * @property string $updated_at
 */
class Transaction extends Model
{
    protected $connection = 'mysql'; 
    
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'transactions';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_transaction';

    /**
     * @var array
     */
    protected $fillable = ['receipt_number','grand_total', 'status', 'tourist_count', 'assigned', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactionPackages()
    {
        return $this->hasMany('App\Http\Models\TransactionPackage', 'id_transaction', 'id_transaction');
    }
}
