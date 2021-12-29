<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'type',
        'image',
        'region',
        'description',
        'price',
        'creator_id',
        'owner_id',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}
