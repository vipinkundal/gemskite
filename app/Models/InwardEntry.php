<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InwardEntry extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'inward_entries';

    /***
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Inward entry items relation
     */
    public function inwardEntryItem()
    {
        return $this->hasMany(InwardEntryItem::class, 'inward_entry_id', 'id');
    }
}
