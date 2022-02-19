<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $query = Message::latest('unread');

        /* for search options */
        if ($request->search) {

            $this->validate($request, [
                'unread' => 'nullable|boolean',
                'title' => 'nullable|string|max:32',
                'name' => 'nullable|string|max:32',
                'phone' => 'nullable|string|max:14',
                'email' => 'nullable|string|max:64',
                'from' => 'nullable|date',
                'to' => 'nullable|date',
            ]);

            if (!is_null($request->unread)) {
                $query->where('unread', $request->unread);
            }
            if ($request->from) {
                $query->whereDate('created_at', '>=', $request->from);
            }
            if ($request->to) {
                $query->whereDate('created_at', '<=', $request->to);
            }
            if ($request->title) {
                $query->where('title', 'like', "%$request->title%");
            }
            if ($request->name) {
                $query->where('name', 'like', "%$request->name%");
            }
            if ($request->phone) {
                $query->where('phone', 'like', "%$request->phone%");
            }
            if ($request->email) {
                $query->where('email', 'like', "%$request->email%");
            }
        }

        $messages = $query->paginate(20);

        $messages->appends([
            $request->query(),
        ]);

        return view('CP.messages')->with(['messages' => $messages]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /* $this->validate($request, [
        'id' => 'required|integer',
        ]); */

        $message = Message::findOrfail($id);
        $message->unread = !$message->unread; // revers unread state
        $message->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
        ]);

        Message::findOrfail($request->id)->delete();
    }
}
