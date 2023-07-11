<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentStoreUpdateRequest;
use App\Http\Resources\DepartmentResource;
use App\Laravue\Models\Department;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class DepartmentController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd('hi');
        $searchParams = $request->all();
        $departmentQuery = Department::query();
        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        $keyword = Arr::get($searchParams, 'keyword', '');

        if (!empty($keyword)) {
            $departmentQuery->where('name', 'LIKE', '%' . $keyword . '%');
        }

        return DepartmentResource::collection($departmentQuery->orderBy('id', 'asc')->paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentStoreUpdateRequest $request)
    {
        // dd($request->all());
        try {
            $input = $request->only('name', 'email', 'number', 'total_credit', 'department_head');
            $department = Department::create($input);
            return new DepartmentResource($department);
        } catch (Exception $ex) {
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
    public function update(DepartmentStoreUpdateRequest $request, $id)
    {
        try {
            $input = $request->only('name', 'email', 'number', 'total_credit', 'department_head');
            $department = Department::find($id);
            $department->fill($input)->update();
            return new DepartmentResource($department);
        } catch (Exception $ex) {
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
        // if (!auth()->user()->can('departments.delete')) {
        //     abort(403, 'Unauthorized action.');
        // }

        // dd('hi',$id);
        
        try {
            $department = Department::find($id);
            $department->delete();
            return response()->json(null, 204);
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }
    }
}
