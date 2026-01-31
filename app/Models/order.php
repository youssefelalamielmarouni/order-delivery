<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\OrderItem;


class Order extends Model
{
    protected $fillable = ['user_id','delivery_id','status'];

    public function client() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function delivery() {
        return $this->belongsTo(User::class,'delivery_id');
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }
}
