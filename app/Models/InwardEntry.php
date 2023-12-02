<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InwardEntry extends Model
{
    use HasFactory;

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
