<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    public $timestamps = false;  //turn off timestamps in migration.

    //fields fillable with mass create method.
    protected $fillable = ['content'];

    //relationship OneToMany between Team and Player
    public function players() {
        return $this->hasMany(Player::class);
    }
}
