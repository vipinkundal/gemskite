<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutwardEntry extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'outward_entries';

    /***
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Outward entry items relation
     */
    public function outwardEntryItem()
    {
        return $this->hasMany(OutwardEntryItem::class, 'outward_entry_id', 'id');
    }
}
