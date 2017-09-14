<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Balkonde $balkonde
 * @property Balkonde $balkonde
 * @property PackageBalkonde[] $packageBalkondes
 * @property int $id_balkondes_distance
 * @property int $id_balkondes_from
 * @property int $id_balkondes_to
 * @property string $created_at
 * @property string $updated_at
 */
class BalkondesDistance extends Model
{
    protected $connection = 'mysql'; 
    
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'BalkondesDistances';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_balkondes_distance';

    /**
     * @var array
     */
    protected $fillable = ['id_balkondes_from', 'id_balkondes_to', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function balkondes()
    {
        return $this->belongsTo('App\Http\Models\Balkondes', 'id_balkondes_from', 'id_balkondes');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function balkondes2()
    {
        return $this->belongsTo('App\Http\Models\Balkondes', 'id_balkondes_to', 'id_balkondes');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function packageBalkondes()
    {
        return $this->hasMany('App\Http\Models\PackageBalkonde', 'id_balkondes_distance', 'id_balkondes_distance');
    }
}
