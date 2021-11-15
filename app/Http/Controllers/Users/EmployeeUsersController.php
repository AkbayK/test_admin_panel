<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employees\StoreEmployeeRequest;
use App\Http\Requests\Employees\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeUsersController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Employee::class);

        $this->items = User::employee()->byAuthor()->filter($request);
        return view('employees.index', [
            'items' => $this->items->simplePaginate(10)
        ]);
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(StoreEmployeeRequest $request)
    {
        $this->authorize('create', Employee::class);
        
        DB::beginTransaction();
        try {
            $validated = $request->validated();
            $validated['role_id'] = Role::EMPLOYEE;
            $validated['author_id'] = auth()->user()->id;
            $validated['password'] = Hash::make($validated['password']);
            $item = User::create($validated);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect(route('employee.index'))->with('success', 'Успешно создано');
    }

    public function edit(Employee $employee)
    {
        return view('employees.create', [
            'item' => $employee
        ]);
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $this->authorize('update', $employee);

        DB::beginTransaction();
        try {
            $validated = $request->validated();
            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            }
            $employee->update($validated);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect(route('employee.index'))->with('success', 'Успешно обновлено');
    }

    public function destroy(Employee $employee)
    {
        $this->authorize('delete', $employee);

        DB::beginTransaction();
        try {
            $employee->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->errorResponse($e->getMessage(), 400);
        }

        return redirect(route('employee.index'))->with('success', 'Успешно удалено'); 
    }
}
