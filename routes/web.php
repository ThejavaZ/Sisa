<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\ComputerController;
use \App\Http\Controllers\AssignedController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\DepartmentController;
use \App\Http\Controllers\EmployeeController;
use \App\Http\Controllers\PositionController;
use \App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

# --- Authenticated Routes ---
Route::get('/auth/login',[HomeController::class, 'login'])->name('login');
Route::get('/auth/register',[HomeController::class, 'register'])->name('register');
Route::post('/auth/register/store',[HomeController::class, 'registerStore'])->name('register.store');
Route::post('/auth/login/store',[HomeController::class, 'loginStore'])->name('login.store');
Route::get('/auth/forgot',[HomeController::class, 'forgotPassword'])->name('forgot.password');
Route::post('/auth/forgot/store',[HomeController::class, 'forgotPasswordStore'])->name('forgot.password.store');
# -- End Authenticated Routes ---


Route::middleware(['auth'])->group(function (){

        # --- common routes ---
        Route::get('/',[HomeController::class, 'index'])->name('home');
        Route::get('/profile',[HomeController::class, 'profile'])->name('profile');
        Route::get('/settigs',[HomeController::class, 'settings'])->name('settings');
        Route::get('/logout',[HomeController::class, 'logout'])->name('logout');
        # --- End common Routes ---

        # --- Computers Routes ---
        Route::get('/computers', [ComputerController::class, 'index'])->name('computers');
        Route::get('/computers/create', [ComputerController::class, 'create'])->name('computers.create');
        Route::post('/computers/store', [ComputerController::class, 'store'])->name('computers.store');

        Route::get('/computers/pdf/{id?}', [ComputerController::class, 'pdf'])->name('computers.pdf');
        Route::get('/computers/docx/{id?}', [ComputerController::class, 'docx'])->name('computers.docx');
        Route::get('/computers/xlsx/{id?}',[ComputerController::class, 'xlsx'])->name('computers.xlsx');
        Route::get('/computers/email/{id?}',[ComputerController::class, 'email'])->name('computers.email');

        Route::get('/computers/{id}', [ComputerController::class, 'show'])->name('computers.show');
        Route::get('/computers/{id}/edit',[ComputerController::class, 'edit'])->name('computers.edit');
        Route::post('/computers/{id}/update', [ComputerController::class, 'update'])->name('computers.update');
        Route::post('/computers/{id}/cancel', [ComputerController::class, 'cancel'])->name('computers.cancel');
        Route::post('/computers/{id}', [ComputerController::class, 'destroy'])->name('computers.destroy');
        # --- End Computers Routes ---

        # --- Assigned Routes ---
        Route::get('/assigneds', [AssignedController::class, 'index'])->name('assigneds');
        Route::get('/assigneds/create', [AssignedController::class, 'create'])->name('assigneds.create');
        Route::post('/assigneds/store', [AssignedController::class, 'store'])->name('assigneds.store');

        Route::get('/assigneds/pdf/{id?}',[AssignedController::class, 'pdf'])->name('assigneds.pdf');
        Route::get('/assigneds/docx/{id?}',[AssignedController::class, 'docx'])->name('assigneds.docx');
        Route::get('/assigneds/xlsx/{id?}',[AssignedController::class, 'xlsx'])->name('assigneds.xlsx');
        Route::get('/assigneds/email/{id?}',[AssignedController::class, 'email'])->name('assigneds.email');


        Route::get('/assigneds/{id}', [AssignedController::class, 'show'])->name('assigneds.show');
        Route::get('/assigneds/{id}/edit',[AssignedController::class, 'edit'])->name('assigneds.edit');
        Route::post('/assigneds/{id}/update', [AssignedController::class, 'update'])->name('assigneds.update');
        Route::post('/assigneds/{id}/cancel', [AssignedController::class, 'destroy'])->name('assigneds.cancel');
        Route::post('/assigneds/{id}', [AssignedController::class, 'destroy'])->name('assigneds.destroy');

        Route::get('/assigneds/card/{id}',[AssignedController::class, 'card'])->name('assigneds.card');
        # --- End Assigned Routes ---

        # --- Employees Routes ---
        Route::get('/employees', [EmployeeController::class, 'index'])->name('employees');
        Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
        Route::post('/employees/store', [EmployeeController::class, 'store'])->name('employees.store');

        Route::get('/employees/pdf/{id?}', [EmployeeController::class, 'pdf'])->name('employees.pdf');
        Route::get('/employees/docx/{id?}', [EmployeeController::class, 'docx'])->name('employees.docx');
        Route::get('/employees/xlsx/{id?}', [EmployeeController::class, 'xlsx'])->name('employees.xlsx');
        Route::get('/employees/email/{id?}', [EmployeeController::class, 'email'])->name('employees.email');

        Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employees.show');
        Route::get('/employees/{id}/edit',[EmployeeController::class, 'edit'])->name('employees.edit');
        Route::post('/employees/{id}/update', [EmployeeController::class, 'update'])->name('employees.update');
        Route::post('/employees/{id}/cancel', [EmployeeController::class, 'destroy'])->name('employees.cancel');
        Route::post('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
        # --- End Employees Routes ---

        # --- Positions Routes ---
        Route::get('/positions', [PositionController::class, 'index'])->name('positions');
        Route::get('/positions/create', [PositionController::class, 'create'])->name('positions.create');
        Route::post('/positions/store', [PositionController::class, 'store'])->name('positions.store');

        Route::get('/positions/pdf/{id?}',[PositionController::class, 'pdf'])->name('positions.pdf');
        Route::get('/positions/docx/{id?}',[PositionController::class, 'docx'])->name('positions.docx');
        Route::get('/positions/xlsx/{id?}',[PositionController::class, 'xlsx'])->name('positions.xlsx');
        Route::get('/positions/email/{id?}',[PositionController::class, 'email'])->name('positions.email');

        Route::get('/positions/{id}', [PositionController::class, 'show'])->name('positions.show');
        Route::get('/positions/{id}/edit',[PositionController::class, 'edit'])->name('positions.edit');
        Route::post('/positions/{id}/update', [PositionController::class, 'update'])->name('positions.update');
        Route::post('/positions/{id}/cancel', [PositionController::class, 'destroy'])->name('positions.cancel');
        Route::post('/positions/{id}', [PositionController::class, 'destroy'])->name('positions.destroy');
        # --- End Positions Routes ---

        # --- Departments Routes ---
        Route::get('/departments',[DepartmentController::class, 'index'])->name('departments');
        Route::get('/departments/create',[DepartmentController::class, 'index'])->name('departments.create');
        Route::get('/departments/store',[DepartmentController::class, 'index'])->name('departments.store');

        Route::get('/departments/pdf/{id?}',[DepartmentController::class, 'index'])->name('departments.pdf');
        Route::get('/departments/docx/{id?}',[DepartmentController::class, 'index'])->name('departments.docx');
        Route::get('/departments/xlsx/{id?}',[DepartmentController::class, 'index'])->name('departments.xlsx');
        Route::get('/departments/email/{id?}',[DepartmentController::class, 'index'])->name('departments.email');

        Route::get('/departments/{id}',[DepartmentController::class, 'index'])->name('departments.show');
        Route::get('/departments/{id}/edit',[DepartmentController::class, 'index'])->name('departments.edit');
        Route::get('/departments/{id}/update',[DepartmentController::class, 'index'])->name('departments.update');
        Route::get('/departments/{id}/cancel',[DepartmentController::class, 'index'])->name('departments.cancel');
        Route::get('/departments/{id}',[DepartmentController::class, 'index'])->name('departments.destroy');
        # --- End Departments Routes ---

        # --- Brands Routes ---
        Route::get('/brands',[BrandController::class, 'index'])->name('brands');
        Route::get('/brands/create',[BrandController::class, 'index'])->name('brands.create');
        Route::get('/brands/store',[BrandController::class, 'index'])->name('brands.store');

        Route::get('/brands/pdf/{id?}',[BrandController::class, 'index'])->name('brands.pdf');
        Route::get('/brands/docx/{id?}',[BrandController::class, 'index'])->name('brands.docx');
        Route::get('/brands/xlsx/{id?}',[BrandController::class, 'index'])->name('brands.xlsx');
        Route::get('/brands/email/{id?}',[BrandController::class, 'index'])->name('brands.email');

        Route::get('/brands/{id}',[BrandController::class, 'index'])->name('brands.show');
        Route::get('/brands/{id}/edit',[BrandController::class, 'index'])->name('brands.edit');
        Route::get('/brands/{id}/update',[BrandController::class, 'index'])->name('brands.update');
        Route::get('/brands/{id}/cancel',[BrandController::class, 'index'])->name('brands.cancel');
        Route::get('/brands/{id}',[BrandController::class, 'index'])->name('brands.destroy');
        # --- End Brands Routes ---

        # --- Branches Routes ---
        Route::get('/branches',[BranchController::class, 'index'])->name('branches');
        Route::get('/branches/create',[BranchController::class, 'index'])->name('branches.create');
        Route::get('/branches/store',[BranchController::class, 'index'])->name('branches.store');

        Route::get('/branches/pdf/{id?}',[BranchController::class, 'index'])->name('branches.pdf');
        Route::get('/branches/docx/{id?}',[BranchController::class, 'index'])->name('branches.docx');
        Route::get('/branches/xlsx/{id?}',[BranchController::class, 'index'])->name('branches.xlsx');
        Route::get('/branches/email/{id?}',[BranchController::class, 'index'])->name('branches.email');

        Route::get('/branches/{id}',[BranchController::class, 'index'])->name('branches.show');
        Route::get('/branches/{id}/edit',[BranchController::class, 'index'])->name('branches.edit');
        Route::get('/branches/{id}/update',[BranchController::class, 'index'])->name('branches.update');
        Route::get('/branches/{id}/cancel',[BranchController::class, 'index'])->name('branches.destroy');
        Route::get('/branches/{id}',[BranchController::class, 'index'])->name('branches.destroy');
        # --- End Branch Routes ---

        # --- Users Routes ---
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users/store', [UserController::class, 'store'])->name('users.store');

        Route::get('/users/pdf/{id?}',[UserController::class, 'pdf'])->name('users.pdf');
        Route::get('/users/docx/{id?}',[UserController::class, 'docx'])->name('users.docx');
        Route::get('/users/xlsx/{id?}',[UserController::class, 'xlsx'])->name('users.xlsx');
        Route::get('/users/email/{id?}',[UserController::class, 'email'])->name('users.email');

        Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
        Route::get('/users/{id}/edit',[UserController::class, 'edit'])->name('users.edit');
        Route::post('/users/{id}/update', [UserController::class, 'update'])->name('users.update');
        Route::post('/users/{id}/cancel', [UserController::class, 'cancel'])->name('users.cancel');
        Route::post('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::post('/users/{id}/password',[UserController::class, 'changePassword'])->name('users.password');
        # --- End Users Routes ---

    }
);

