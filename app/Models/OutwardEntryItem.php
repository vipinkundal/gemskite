<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutwardEntryItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'outward_entry_items';

    /***
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Outward entry relations
     */
    public function outwardEntry()
    {
        return $this->belongsTo(OutwardEntry::class);
    }
}
