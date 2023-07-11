<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Laravue\Models\Category;
use App\Traits\ImageTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    use ImageTrait;
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchParams = $request->all();
        $categoryQuery = Category::with('image');
        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        $keyword = Arr::get($searchParams, 'keyword', '');

        if (!empty($keyword)) {
            $categoryQuery->where('name', 'LIKE', '%' . $keyword . '%');
        }

        return CategoryResource::collection($categoryQuery->orderBy('id', 'asc')->paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreUpdateRequest $request)
    {
        try {
            $input = $request->only('name', 'code', 'description', 'image');
            DB::beginTransaction();
            $category = Category::create($input);
            if($request->hasFile('image')){
                $filename = $request->image->getClientOriginalName();
                $image_upload_path = public_path('\uploads\categories');
                $request->image->move($image_upload_path, $filename);
                $this->createImage($filename,$category);
//                dd($request->all(), $request->file(), $request->image, $filename, public_path(), $extension, $image_upload_path);
            }
            DB::commit();
            return new CategoryResource($category);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json( new \Illuminate\Support\MessageBag(['catch_exception'=>$ex->getMessage()]), 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryStoreUpdateRequest $request, $id)
    {
        try {
            $input = $request->only('name', 'code', 'description');
            $category = Category::find($id);
            DB::beginTransaction();
            $category->fill($input)->update();
            
            //Only deleting image when new image is selected.
            // When no new image is selected, image remains the same, that means no delete option for image only.
            if($request->hasFile('image')){
                $prev_image =  $category->image;
                if($prev_image){
                    $path = public_path('\uploads\categories\\').$prev_image->filename;
                    if(file_exists($path)) {
                        unlink($path);
                        $prev_image->delete();
                    }
                }
                $filename = $request->image->getClientOriginalName();
                $image_upload_path = public_path('\uploads\categories');
                $request->image->move($image_upload_path, $filename);
                $this->createImage($filename,$category);
            }
            DB::commit();
            return new CategoryResource($category);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json( new \Illuminate\Support\MessageBag(['catch_exception'=>$ex->getMessage()]), 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if (!auth()->user()->can('categories.delete')) {
        //     abort(403, 'Unauthorized action.');
        // }

        // dd('hi',$id);
        
        try {
            $category = Category::find($id);
            $image =  $category->image;
            if($image){
                $path = public_path('\uploads\categories\\').$image->filename;
                if(file_exists($path)) {
                    unlink($path);
                    $image->delete();
                }
            }
            $category->delete();
            return response()->json(null, 204);
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }
    }
}
