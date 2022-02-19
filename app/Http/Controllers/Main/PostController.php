<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Post;
use App\Models\Tags;
use Illuminate\Http\Request;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::with('tags:id,name')->active()->latest('id');

        /*  Start search    */
        $this->validate($request, [
            'search' => 'nullable|string|max:32',
            'tag' => 'nullable|string|max:32',
        ]);

        if (!is_null($request->search)) {
            $posts->where('title', 'LIKE', "%$request->search%")->orWhere('content', 'LIKE', "%$request->search%");
        }

        if ($request->tag) {

            $tag = Tags::select('id')->where('name', $request->tag)->firstOrFail();

            $posts->whereHas('tags', function ($q) use ($tag) {
                $q->where('tag_id', $tag->id);
            });

        }
        /*  End search    */

        $posts = $posts->paginate(6);

        $posts->appends($request->query());

        return view('main.posts.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        checkIfIdCorrect($id);
        $post = Post::findOrfail($id);

        if (authClient()->check()) {
            Notification::currentClient()->posts()->updateAsReadByMainId($post->id);
        }

        return view('main.posts.show', [
            'post' => $post,
        ]);
    }

}
