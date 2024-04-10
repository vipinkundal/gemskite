<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InwardEntryItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'inward_entry_items';

    /***
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Inward entry relations
     */
    public function inwardEntry()
    {
        return $this->belongsTo(InwardEntry::class);
    }
}
