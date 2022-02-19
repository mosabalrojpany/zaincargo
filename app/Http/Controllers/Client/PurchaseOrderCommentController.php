<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrderComment;
use Illuminate\Http\Request;

class PurchaseOrderCommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required|integer|min:1|exists:purchase_orders,id,customer_id,' . authClient()->user()->id,
        ]);

        $this->validateData();

        $comment = new PurchaseOrderComment();
        $comment->customer_id = authClient()->user()->id;
        $comment->order_id = $request->order_id;

        $this->setData($comment);
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

        $comment = PurchaseOrderComment::where('customer_id', authClient()->user()->id)->findOrfail($request->id);
        return $this->setData($comment);
    }

    private function validateData()
    {
        request()->validate([
            'comment' => 'required|string|min:9|max:500',
        ]);
    }

    private function setData($comment)
    {
        $comment->comment = request()->comment;
        $comment->save();

        return response()->json([
            'redirectTo' => url()->previous() . "#$comment->id",
        ], 200);
    }

}
