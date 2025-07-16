<?php

namespace App\Http\Controllers;

use App\Models\Assigned;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Assign;

class AssignedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $index = 1;
        $assigned = Assigned::where('status', 1)->get();
        return view('assigneds.index', compact('assigned', 'index'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $computers = \App\Models\Computer::where('status', 1)->get();
        $employees = \App\Models\Employee::where('status', 1)->get();
        return view('assigneds.create', compact('computers', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'computer_id' => 'required|exists:computers,id',
            'employee_id' => 'required|exists:employees,id',
            'assigned_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $assigned = Assigned::create([
            'computer_id' => $data['computer_id'],
            'employee_id' => $data['employee_id'],
            'assigned_date' => $data['assigned_date'],
            'returned_date' => null,
            'notes' => $data['notes'],
            'user_id' => Auth::user()->id,
            'active' => "S",
            'status' => 1,
        ]);

        if ($assigned) return redirect()->route('assigneds')->with('success', 'Assigned successfully created.');
        else return redirect()->back()->with('error', 'Failed to create assigned.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $assigned = Assigned::find($id);
        return view('assigneds.show', compact('assigned'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $computers = \App\Models\Computer::where('status', 1)->get();
        $employees = \App\Models\Employee::where('status', 1)->get();
        $users = \App\Models\User::where('status',1)->get();
        $assigned = Assigned::where('id', $id)->first();
        return view('assigneds.edit', compact('assigned','computers','employees', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $assigned = Assigned::where('id',$id)->where('status',1)->first();
        $data = $request->validate([
            'computer_id' => 'required|exists:computers,id',
            'employee_id' => 'required|exists:employees,id',
            'assigned_date' => 'required|date',
            'returned_date'=> 'nullable|date',
            'notes' => 'nullable|string',
            'user_id' => 'integer|required|exists:users,id',
            'active' => 'string|max:1'
        ]);

        $assigned->update([
            'computer_id' => $data['computer_id'],
            'employee_id' => $data['employee_id'],
            'assigned_date' => $data['assigned_date'],
            'returned_date' => $data['returned_date'],
            'notes' => $data['notes'],
            'user_id' => $data['user_id'],
            'active' => $data['active'],
            'status' => 1,
            'updated_at' => now()
        ]);

        if ($assigned) return redirect()->route('assigneds')->with('success', 'Assigend updated successfully');
        else return redirect()->back()->with('Error', 'Assigend could not updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $assigned = Assigned::where('id', $id)->where('status', 1)->first();
        if ($assigned) $assigned->update(['status'=>0]);
        return redirect()->back()->with("Sucess", "Delete success");
    }

    public function pdf($id = null, $download = true)
    {
        if ($id){
            $assigned = Assigned::where('id',$id)->where('status',1)->first();
            $pdf = Pdf::loadView('assigneds.id', compact('Assign'));
        }
        else{
            $assigns = Assigned::where('status',1)->get();
            $pdf = Pdf::loadView('assigneds.all', compact('assigns'));
        }

        if ($download) {
            return $pdf->stream('reporte_asignaciones'.date('dmY_his').'.pdf'); // para descarga
        } else {
            return $pdf->output(); // contenido en crudo para email
        }
    }

    public function docx() {}
    public function xlsx() {}
    public function email() {}

    public function card($id) {
        $assigned = Assigned::where('id', $id)->where('status', 1)->first();
        $pdf = Pdf::loadView('assigneds.card', compact('assigned'));

        // Ruta donde se guardará el PDF
        $folder = public_path('storage/assigneds/');
        $filename = $assigned->id . '.pdf';
        $fullPath = $folder . $filename;

        // Crear la carpeta si no existe
        if (!file_exists($folder)) {
            mkdir($folder, 0775, true);
        }

        // Guardar el PDF si no existe
        if (!file_exists($fullPath)) {
            $pdf->save($fullPath);
        }

        // Mostrar el PDF en el navegador
        return $pdf->stream();
    }
}
