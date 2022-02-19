<?php
namespace App\Http\ViewComposers;

use App\Models\Post;
use App\Models\Tags;
use Illuminate\View\View;

class MainPostSideBar
{

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $tags = Tags::select('id', 'name')->active()->get();

        $posts = Post::select('id', 'title', 'img', 'created_at')->active()->latest('id')->limit(3)->get();

        $view->with([
            'posts' => $posts,
            'tags' => $tags,
        ]);
    }

}
