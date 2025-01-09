<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\CreateForms;
use App\Models\User;
use App\Models\User\FormSubmission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forms = CreateForms::orderBy('id', 'desc')->limit(5)->get();;
        return view('admin.index',compact('forms'));
    }

    public function submitted_form_list(): View
    {
        $lists = FormSubmission::all();
        return view('admin.listed',compact('lists'));
    }


    public function getTodayFeedbackCount()
    {
        $count = FormSubmission::whereDate('created_at', Carbon::today())->count();
        return response()->json(['count' => $count]);
    }

    public function getThisMonthFeedbackCount()
    {
        $count = FormSubmission::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        return response()->json(['count' => $count]);
    }

    public function show_forms(): View
    {
        $forms = CreateForms::all();
        return view('admin.allForms',compact('forms'));
    }

    /**
     * Display a listing of the resource.
     */
    public function profile(): View
    {
        return view('admin.profile');
    }


    /**
     * ImageUpdate the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function imgupdate(Request $request, $id)
    {
        $this->validate($request,[
            'image.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($request->hasFile('image'))
        {
            $imageName = $request->image->getClientOriginalName();
            $imageName = $request->image->store('public');
        }
        else
        {
            $data = User::where('id',$id)->first();
            $imageName = $data->image;
        }

        $admin =  User::find($id);
        $admin->image = $imageName;
        $admin->save(); 
        $notification = array(
            'message' => 'Picture Changed!', 
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Admin Password the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function passupdate(Request $request, $id)
    {
        $this->validate($request,[
            'old_password' => 'required|string',
            'new_password' =>  ['required','string',Password::min( 8 ),'same:c_password','different:old_password'],
        ]);

        $admin =  User::find($id);
        if (Hash::check($request->old_password, $admin->password)) { 
            $admin->fill([
                'password' => Hash::make($request->new_password)
            ])->save();

            $notification = array(
                'message' => 'Password Changed!', 
                'alert-type' => 'success',
            );
        } 
        else{
            $notification = array(
                'message' => 'Password does not match!', 
                'alert-type' => 'error',
            );
        }
        return redirect()->back()->with($notification);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.form');
    }

    public function status(Request $request,$id)
    {
        $this->validate($request,[
            'status' => 'required',
        ]);

        // Find the item to update
        $item = CreateForms::find($id);

        // Find other items with the same status
        $otherItems = CreateForms::where('id', '!=', $id)->get();

        // Update the current item's status
        $item->status = $request->status;
        $item->save();

        // Update the status of other items to 0
        if($request->status == 1){
            foreach ($otherItems as $otherItem) {
                $otherItem->status = 0;
                $otherItem->save();
            }
        }
 
        $notification = array(
            'message' => 'Status Change!', 
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            
            $request->validate([
                'formData' => 'required|string',
            ]);

            $formData = $request->input('formData');
            // Save form to database
            $form = new CreateForms();
            $form->formName = $request->formName;
            $form->formSubtitle = $request->formSubtitle;
            $form->data = $formData;
            $form->save();
            

            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'Form saved successfully!',
                'formdata' => $formData,
            ]);
        } catch (\Exception $e) {
            // Handle errors
            return response()->json([
                'success' => false,
                'message' => 'Error saving form: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $form = CreateForms::find($id);
        return view('admin.showForm',compact('form'));
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
        // dd($request);

        $this->validate($request,[
            'name' => 'required|string|max:255',
            'position' => 'nullable',
            'phone' => 'required|min:11|max:14',
        ]);

        $admin =  User::find($id);
        $admin->name = $request->name;
        $admin->position = $request->position;
        $admin->phone = $request->phone;
        $admin->save(); 
        $notification = array(
            'message' => 'Profile Updated Successfully!', 
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        CreateForms::where('id',$id)->delete();
        $notification = array(
            'message' => 'Form destroy.', 
            'alert-type' => 'error',
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function submitted_form_delete(string $id)
    {
        FormSubmission::where('id',$id)->delete();
        $notification = array(
            'message' => 'Feedback Delete.', 
            'alert-type' => 'error',
        );
        return redirect()->back()->with($notification);
    }
}
