<?php

namespace App\Http\Controllers\Main;

use App\Models\FrequentlyAskedQuestion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrequentlyAskedQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = FrequentlyAskedQuestion::active()->latest('id');

        /*  Start search    */
        $this->validate($request, [
            'search' => 'nullable|string|max:32',
        ]);

        if (!is_null($request->search)) {
            $query->where('question', 'LIKE', "%$request->search%")->orWhere('answer', 'LIKE', "%$request->search%");
        }
        /*  End search    */

        $faqs = $query->paginate(10);
        $faqs->appends($request->query());

        return view('main.faq', [
            'faqs' => $faqs,
        ]);
    }

}
