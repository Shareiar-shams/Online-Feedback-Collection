<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Course;
use App\Models\Admin\Module;
use App\Models\Admin\Content;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $courses = Course::all();
        return view('admin.course.index',compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.course.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|max:255',
                'level' => 'required',
                'price' => 'required|numeric',
                'featured_image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
            
            $imageName = null;

            if($request->hasFile('featured_image'))
            {
                $imageName = $request->featured_image->getClientOriginalName();
                $imageName = $request->featured_image->store('public');
            }
    
            $course = new Course();
            $course->title = $request->title; 
            $course->level = $request->level; 
            $course->price = $request->price; 
            $course->featured_image = $imageName;
            $course->save();
            
            foreach($request->modules as $moduleData){
                $module = new Module();
                $module->title = $moduleData['title'];
                $module->course_id = $course->id; 
                $module->save();
                if(isset($moduleData['content']) && is_array($moduleData['content'])){
                    foreach($moduleData['content'] as $contentData){
                        $content = new Content();
                        $content->title = $contentData['title'];
                        $data = $contentData;
                        unset($data['title']);
                        
                        $content->data = json_encode($data);
                        $content->module_id = $module->id; 
                        $content->save();
                    }
    
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Course saved successfully!',
                'formData' => $request->all()
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error saving Course: ' . $e->getMessage(),
            ]);
        }

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
        $course = Course::find($id);
        return view('admin.course.edit',compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|max:255',
                'level' => 'required',
                'price' => 'required|numeric',
                'featured_image.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
            $imageName = null;

            if($request->hasFile('featured_image'))
            {
                $imageName = $request->featured_image->getClientOriginalName();
                $imageName = $request->featured_image->store('public');
            }else{
                $data = Course::where('id',$id)->first();
                $imageName = $data->featured_image;
            }
    
            $course = Course::find($id);
            $course->title = $request->title; 
            $course->level = $request->level; 
            $course->price = $request->price; 
            $course->featured_image = $imageName;
            $course->save();
            
            foreach($request->modules as $moduleData){
                if(isset($moduleData['id'])){
                    $module = Module::find($moduleData['id']);
                }else{
                    $module = new Module();
                }
                
                $module->title = $moduleData['title'];
                $module->course_id = $course->id; 
                $module->save();
                if(isset($moduleData['content']) && is_array($moduleData['content'])){
                    foreach($moduleData['content'] as $contentData){
                        if (isset($contentData['id'])) {
                            $content = Content::find($contentData['id']);
                        }else{
                            $content = new Content();
                        }
                            
                        $content->title = $contentData['title'];
                        $data = $contentData;
                        unset($data['title']);
                        unset($data['id']);
                        
                        $content->data = json_encode($data);
                        $content->module_id = $module->id; 
                        $content->save();
                    }
    
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Course Update successfully!',
                'formData' => $request->all()
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error saving Course: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::find($id);

        $course->delete();
        $notification = array(
            'message' => 'Course Delete.', 
            'alert-type' => 'error',
        );
        return redirect()->back()->with($notification);
    }
    
    public function moduleDelete(string $id){
        $module = Module::find($id);
        if (!$module) {
            return response()->json([
                'success' => false,
                'message' => 'Module not found'
            ]);
        }
        $module->contents()->delete();
        $module->delete();

        return response()->json([
            'success' => true,
            'message' => 'Module and its contents deleted successfully'
        ]);
    }

    public function contentDelete(string $id){
        $content = Content::find($id);
        if (!$content) {
            return response()->json([
                'success' => false,
                'message' => 'Content not found'
            ]);
        }
        $content->delete();
        return response()->json([
            'success' => true,
            'message' => 'Contents deleted successfully'
        ]);
    }
}
