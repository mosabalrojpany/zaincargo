<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\ShipmentComment;
use App\Models\User;
use App\Notifications\Shipments\Comments\NewComment;
use App\Notifications\Shipments\Comments\UpdateComment;
use Auth;
use Illuminate\Http\Request;

class ShipmentCommentController extends Controller
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
        $query = ShipmentComment::with(['customer:id,code,name', 'user:id,name'])->latest('shipment_id')->latest('id');

        /* for search options */
        if ($request->search) {

            $this->validate($request, [
                'state' => 'nullable|boolean',
                'comment' => 'nullable|string|max:32',

                'shipment_id' => 'nullable|integer|min:1',
                'code' => 'nullable|integer|min:1',
                'user' => 'nullable|integer|min:1',

                'from' => 'nullable|date',
                'to' => 'nullable|date|after_or_equal:from',
            ]);

            if (!is_null($request->state)) {
                $query->where('unread', $request->state)->whereNull('user_id');
            }
            if ($request->shipment_id) {
                $query->where('shipment_id', $request->shipment_id);
            }
            if ($request->user) {
                $query->where('user_id', $request->user);
            }
            if ($request->code) {
                $query->whereHas('customer', function ($q) use ($request) {
                    $q->where('code', get_customer_code_starts_with() . $request->code);
                });
            }
            if ($request->comment) {
                $query->where('comment', 'like', "%$request->comment%");
            }
            if ($request->from) {
                $query->whereDate('created_at', '>=', $request->from);
            }
            if ($request->to) {
                $query->whereDate('created_at', '<=', $request->to);
            }
        }

        $users = User::select('id', 'name')->get();

        $comments = $query->paginate(20);

        $comments->appends([
            $request->query(),
        ]);

        return view('CP.shipment_comments')->with([
            'comments' => $comments,
            'users' => $users,
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
        $this->validate($request, [
            'shipment_id' => 'required|integer|min:1|exists:shipping_invoices,id',
        ]);

        $this->validateData();

        $comment = new ShipmentComment();
        $comment->user_id = Auth::user()->id;
        $comment->shipment_id = $request->shipment_id;

        $this->setData($comment);
        $comment->shipment->customer->notify(new NewComment($comment));
        $this->returnResponse($comment);
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

        $this->validateData();

        /* When customer_id is null that means user added comment , so that means user can edit comment */
        $comment = ShipmentComment::whereNull('customer_id')->findOrfail($request->id);

        $this->setData($comment);

        if ($comment->wasChanged()) {
            $comment->shipment->customer->notify(new UpdateComment($comment));
        }

        $this->returnResponse($comment);
    }

    /**
     * Update state of the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateState($id)
    {
        /* when user_id null that means comment added by customer , so that means user can change state */
        $comment = ShipmentComment::whereNull('user_id')->findOrfail($id);
        $comment->unread = !$comment->unread; // revers unread state
        $comment->save();

        return redirect()->to(url()->previous() . "#$comment->id");
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

        ShipmentComment::findOrfail($request->id)->delete();
        Notification::ShipmentComments()->deleteByDataId($request->id);
    }

    private function validateData()
    {
        request()->validate([
            'comment' => 'required|string|min:3|max:500',
        ]);
    }

    private function setData($comment)
    {
        $comment->comment = request()->comment;
        $comment->save();
    }

    private function returnResponse($comment)
    {
        return response()->json([
            'redirectTo' => url()->previous() . "#$comment->id",
        ], 200);
    }

}
