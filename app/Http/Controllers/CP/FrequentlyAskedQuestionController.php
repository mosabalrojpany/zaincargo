<?php

namespace App\Http\Controllers\CP;

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
        $query = FrequentlyAskedQuestion::latest('id');

        /*  Start search    */
        if ($request->search) {

            $this->validate(request(), [
                'state' => 'nullable|boolean',
                'question' => 'nullable|string|max:32',
                'answer' => 'nullable|string|max:32',
            ]);

            if (!is_null($request->state)) {
                $query->where('active', $request->state);
            }
            if ($request->question) {
                $query->where('question', 'Like', "%$request->question%");
            }
            if ($request->answer) {
                $query->where('answer', 'Like', "%$request->answer%");
            }
        }
        /*  End search    */

        $faqs = $query->paginate(20);
        $faqs->appends($request->query());

        return view('CP.faqs.index', [
            'faqs' => $faqs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('CP.faqs.create');
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

        $faq = new FrequentlyAskedQuestion();
        $this->setData($faq);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        checkIfIdCorrect($id);
        $faq = FrequentlyAskedQuestion::findOrfail($id);

        return view('CP.faqs.edit', [
            'faq' => $faq,
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

        $this->validateData();

        $faq = FrequentlyAskedQuestion::findOrfail($request->id);
        $this->setData($faq);
    }

    private function validateData()
    {
        request()->validate([
            'question' => 'required|string|min:10|max:150',
            'answer' => 'required|min:12|string',
            'state' => 'required|boolean',
        ]);
    }

    private function setData(FrequentlyAskedquestion $faq)
    {
        $request = request();
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->active = $request->state;
        $faq->save();
    }

}
