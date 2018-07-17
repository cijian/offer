<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';

    /**
     * 在数组中隐藏的属性
     *
     * @var array
     */
    protected $hidden = ['is_del'];




}
