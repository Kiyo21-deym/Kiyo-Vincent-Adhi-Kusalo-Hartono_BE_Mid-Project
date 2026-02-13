<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_code',
        'name',
        'email',
        'phone',
        'address',
        'join_date'
    ];

    protected $casts = [
        'join_date' => 'date',
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public static function generateMemberCode()
    {
        $lastMember = self::latest('id')->first();
        $number = $lastMember ? $lastMember->id + 1 : 1;
        return 'MBR' . str_pad($number, 5, '0', STR_PAD_LEFT);
    }
}