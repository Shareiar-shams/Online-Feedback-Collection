<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\CreateForms;
use App\Models\User\FormSubmission;
use App\Events\NewFormSubmission;
use Illuminate\Http\Request;

class ViewportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $form = CreateForms::where('status', 1)
            ->orderBy('id', 'desc')->first();
        return view('user.index',compact('form'));
    }

    public function test()
    {
        return view('user.test');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        event(new NewFormSubmission('hello world'));

        return response()->json(['success' => true]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Save form submission to the database
        $data = $request->except('_token');
        $jsonData = json_encode($data);

        // Save data into your model
        $submission = new FormSubmission();
        $submission->data = $jsonData;
        $submission->save();

        // Trigger the event
        broadcast(new NewFormSubmission($submission));


        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
