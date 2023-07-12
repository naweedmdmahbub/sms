<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Laravue\Models\Department;
use App\Laravue\Models\Semester;
use App\Laravue\Models\Student;
use Illuminate\Http\Request;

class SuperDashboardController extends Controller
{
    public function getModelData(Request $request)
    {
        $models = [];
        foreach($request->all() as $model){
            $mdl = 'App\Laravue\Models\\'.$model;
            $mdl = $mdl::all();
            array_push($models, $mdl);
        }
        return $models;
    }

    
    public function getDashboardData()
    {
        $students = Student::count();
        $departments = Department::count();
        $department_students = Department::withCount('students')->get();
        $semester_students = Semester::withCount('students')->get();
        return [
            'students' => $students,
            'departments' => $departments,
            'department_students' => $department_students,
            'semester_students' => $semester_students,
        ];
    }
}
