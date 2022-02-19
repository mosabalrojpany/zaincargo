<?php

namespace App\Models;

use App\Traits\Models\FetchActive;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use FetchActive;

    public $timestamps = false;

    protected $dates = ['created_at'];

    protected $hidden = ['pivot'];
    //
    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'post_tags', 'post_id', 'tag_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImage()
    {
        return url('storage/images/posts', $this->img);
    }

    public function getImageAvatar()
    {
        return url('storage/images/posts/avatar', $this->img);
    }

    public function getShortTitle()
    {
        if (mb_strlen($this->title) > 40) {
            return mb_substr($this->title, 0, 40) . '...';
        }

        return $this->title;
    }

    public function created_at()
    {
        return $this->created_at->format('Y-m-d g:ia');
    }

    public function getDate()
    {
        if (strtotime($this->created_at) > strtotime('-2 day')) {
            return $this->created_at->diffForHumans();
        }
        return $this->created_at->format('Y-m-d');
    }

}
