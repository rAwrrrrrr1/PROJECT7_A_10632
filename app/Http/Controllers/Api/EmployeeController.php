<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();

        if(count($employees) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $employees,
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null,
        ], 400);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_pegawai' => 'required|max:255|regex:/[a-zA-Z]/',
            'nip' => 'required|max:6|numeric',
            'role' => 'required',
            'alamat' => 'required',
            'tgl_lahir' => 'required|date_format:y/m/d',
            'no_telp' => 'required|max:13|numeric'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $employee = Employee::create($storeData);
        return response([
            'message' => 'Add Employee Success',
            'data' =>$employee
        ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);

        if(!is_null($employee)){
            return response([
                'messagse' => 'Retreive Employee Success',
                'data' => $employee
            ], 200);
        }

        return response([
            'messagse' => 'Employee Not Found',
            'data' => null
        ], 404);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        if(is_null($employee)){
            return response([
                'messagse' => 'Employee Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_pegawai' => ['required','max:60',Rule::unique('products')->ignore($employee)],
            'nip' => 'required',
            'role' => 'required',
            'alamat' => 'required',
            'tgl_lahir' => 'required',
            'no_telp' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $employee->nama_pegawai = $updateData['nama_pegawai'];
        $employee->nip = $updateData['nip'];
        $employee->role = $updateData['role'];
        $employee->alamat = $updateData['alamat'];
        $employee->tgl_lahir = $updateData['tgl_lahir'];
        $employee->no_telp = $updateData['no_telp'];

        if($employee->save()){
            return response([
                'messagse' => 'Update Employee Success',
                'data' => $employee
            ], 200);
        }

        return response([
            'messagse' => 'Update Employee Failed',
            'data' => null
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        if(is_null($employee)){
            return response([
                'messagse' => 'Employee Not Found',
                'data' => null
            ], 404);
        }

        if($employee->delete()){
            return response([
                'messagse' => 'Delete Employee Success',
                'data' => $employee
            ], 200);
        }

        return response([
            'messagse' => 'Delete Employee Failed',
            'data' => null
        ], 400);
    }
}
