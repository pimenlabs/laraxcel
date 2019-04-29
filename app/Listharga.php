<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listharga extends Model
{
  protected $fillable = [
      'kodeproduk','judul','kategori','harga','status','updated_at','created_at'
  ];

}
