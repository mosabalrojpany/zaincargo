<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ShipmentComment;
use Illuminate\Http\Request;

class ShipmentCommentController extends Controller
{
    //
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'shipment_id' => 'required|integer|min:1|exists:shipping_invoices,id,customer_id,' . authClient()->user()->id,
        ]);

        $this->validateData();

        $comment = new ShipmentComment();
        $comment->customer_id = authClient()->user()->id;
        $comment->shipment_id = $request->shipment_id;

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

        $comment = ShipmentComment::where('customer_id', authClient()->user()->id)->findOrfail($request->id);
        return $this->setData($comment);
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

        return response()->json([
            'redirectTo' => url()->previous() . "#$comment->id",
        ], 200);
    }
}
