<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
   public function admin()
   {
   	return $this->belongsTo('App\Models\Admin');
   }

   public function getLogCreatedAttribute($value)
   {
   	$date = strtotime($value);

   	return date('m/d/Y h:iA', $date);
   }
}
