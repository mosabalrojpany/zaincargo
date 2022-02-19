<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Jobs\Notifications\Posts\SendNewPostNotification;
use App\Models\Post;
use App\Models\Tags;
use App\Models\User;
use Auth;
use DB;
use File;
use Illuminate\Http\Request;
use Image;

class PostController extends Controller
{
    private $imgPath;
    private $imgAvatarPath;

    public function __construct()
    {
        $this->imgPath = public_path('/storage/images/posts/');
        $this->imgAvatarPath = $this->imgPath . 'avatar/';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::with('user:id,name', 'tags:id,name');

        /*  Start search    */
        if ($request->search) {

            $this->validate($request, [
                'tag' => 'nullable|integer|min:1',
                'user' => 'nullable|integer|min:1',
                'state' => 'nullable|boolean',
                'from' => 'nullable|date',
                'to' => 'nullable|date',
            ]);
            if ($request->tag) {
                $posts->whereHas('tags', function ($q) use ($request) {
                    $q->where('tag_id', $request->tag);
                });
            }
            if ($request->user) {
                $posts->where('user_id', $request->user);
            }
            if (!is_null($request->state)) {
                $posts->where('active', $request->state);
            }
            if ($request->from) {
                $posts->whereDate('created_at', '>=', $request->from);
            }
            if ($request->to) {
                $posts->whereDate('created_at', '<=', $request->to);
            }
        }
        /*  End search    */

        $posts->latest('id');

        $posts = $posts->paginate(10);
        $posts->appends($request->query());

        $tags = Tags::select('id', 'name')->orderBy('name')->get();
        $users = User::select('id', 'name')->orderBy('name')->get();

        return view('CP.posts.index', [
            'posts' => $posts,
            'tags' => $tags,
            'users' => $users,
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
        $post = Post::with('user', 'tags')->findOrfail($id);
        $last_posts = Post::latest('id')->take(5)->get();

        $related_posts = Post::latest('id')->take(5)->whereHas('tags', function ($q) use ($post) {
            $q->whereIn('tag_id', $post->tags->pluck('id'));
        })->get();

        return view('CP.posts.show', [
            'post' => $post,
            'last_posts' => $last_posts,
            'related_posts' => $related_posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tags::select('id', 'name')->orderBy('name')->get();

        return view('CP.posts.create', [
            'tags' => $tags,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateData();

        $p = new Post();
        $p->user_id = Auth::user()->id;

        $this->setData($p);
        SendNewPostNotification::dispatch($p);
        $this->returnResponse($p);
    }

    /**
     * Show edit post page in CMS (for emplyess inside dashboard)
     */
    public function edit($id)
    {
        checkIfIdCorrect($id);
        $post = Post::with('tags')->findOrFail($id);
        $tags = Tags::whereNotIn('id', $post->tags->pluck('id'))->get();

        return view('CP.posts.edit', [
            'post' => $post,
            'tags' => $tags,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|min:1',
        ]);

        $this->validateData(true);

        $p = Post::findOrfail($request->id);
        $this->setData($p, true);
        $this->returnResponse($p);
    }

    private function validateData($update = false)
    {
        request()->validate([
            'title' => 'required|string|min:10|max:150',
            'content' => 'required|min:32|string',
            'img' => ($update ? 'nullable' : 'required') . '|image|mimes:jpg,jpeg,png,gif|max:10240',
            'state' => 'required|boolean',
            'tags' => 'required|array|min:1',
            'tags.*' => 'required|integer|min:1',
        ]);
    }

    private function setData($post, $update = false)
    {
        $request = request();

        if ($request->hasFile('img')) {

            $image = $request->file('img');
            $img_name = generateFileName('', $image->getClientOriginalExtension());
            $image = Image::make($image);
            $image->save($this->imgPath . $img_name);
            $image->resize(360, 240);
            $image->save($this->imgAvatarPath . $img_name);

            if ($update) { // Delete old image
                File::delete($this->imgPath . $post->img);
                File::delete($this->imgAvatarPath . $post->img);
            }

            $post->img = $img_name;

        }

        $post->title = $request->title;
        $post->content = $request->content;
        $post->active = $request->state;

        DB::transaction(function () use ($post, $request, $update) {

            $post->save();

            if ($update) {

                $post->tags()->sync($request->tags);

            } else {

                $post->tags()->attach($request->tags);

            }

        });

    }

    private function returnResponse($post)
    {
        return response()->json([
            'redirectTo' => url("/cp/posts/$post->id"),
        ], 200)->send();
    }

}
