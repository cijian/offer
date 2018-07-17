<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'article';
    /**
     * 在数组中隐藏的属性
     *
     * @var array
     */
    protected $hidden = ['is_del'];


    public function getCommentListByArticle(){

        return $this->hasMany('App\Comment','aid','id');
    }

}
