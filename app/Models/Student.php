<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable=['user_id','id_type','id_num','name_zh','name_fn','gender','dob','mobile','email','remark'];

    // public function klasses(){
    //     return $this->belongsToMany(Klass::class,'klass_students','student_id','klass_id');
    // }
    // public static function scores(){
    //     return $this->hasManyThrough(Score::class, KlassStudent::class);
    // }
}
