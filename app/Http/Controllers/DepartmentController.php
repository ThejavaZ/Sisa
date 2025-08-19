<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;
use App\Mail\DepartmentEmail;
use Illuminate\Support\Facades\Mail;

class DepartmentController extends Controller
{
    public function index()
    {
        $index = 1;
        $departments = Department::where('status', 1)->get();
        return view('departments.index', compact('departments', 'index'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'cost_center' => 'required|string|max:20',
        ]);

        $department = Department::create([
            'name' => $data['name'],
            'cost_center' => $data['cost_center'],
            'created_by' => Auth::user()->id,
        ]);

        if ($department) {
            return redirect()->route('departments')->with('success', 'Department created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create department.');
        }
    }

    public function show($id)
    {
        $department = Department::where('id', Crypt::decrypt($id))->where('status', 1)->first();
        if (!$department) {
            return redirect()->back()->with('error', 'Department not found.');
        }
        return view('departments.show', compact('department'));
    }

    public function edit($id)
    {
        $department = Department::where('id', Crypt::decrypt($id))->where('status', 1)->first();
        if (!$department) {
            return redirect()->back()->with('error', 'Department not found.');
        }
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        $department = Department::where('id', $id)->where('status', 1)->first();
        if (!$department) {
            return redirect()->back()->with('error', 'Department not found.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'cost_center' => 'required|string|max:20',
        ]);

        $department->update([
            'name' => $data['name'],
            'cost_center' => $data['cost_center'],
            'updated_by' => Auth::user()->id,
        ]);

        return redirect()->route('departments')->with('success', 'Department updated successfully.');
    }

    public function destroy($id)
    {
        $department = Department::where('id', $id)->where('status', 1)->first();
        if (!$department) {
            return redirect()->back()->with('error', 'Department not found.');
        }
        $department->update(['status' => 0, 'deleted_by' => Auth::user()->id, 'deleted_at' => now()]);
        return redirect()->route('departments')->with('success', 'Department deleted successfully.');
    }

    public function cancel($id)
    {
        $department = Department::where('id', $id)->where('status', 1)->first();
        if (!$department) {
            return redirect()->back()->with('error', 'Department not found.');
        }
        $department->update(['active' => 'N', 'cancel_by' => Auth::user()->id, 'cancel_at' => now()]);
        return redirect()->route('departments')->with('success', 'Department canceled successfully.');
    }

    public function pdf($id = null, $download = true)
    {
        if ($id) {
            $department = Department::where('id', Crypt::decrypt($id))->where('status', 1)->first();
            if (!$department) return redirect()->route('departments')->with('error', 'Department not found');
            $pdf = Pdf::loadView('departments.id', compact('department'));
            $filename = 'report_of_' . $department->name . '_' . now()->format('dmY_His') . '.pdf';
        } else {
            $departments = Department::where('status', 1)->get();
            $pdf = Pdf::loadView('departments.all', compact('departments'));
            $filename = 'report_of_departments_' . now()->format('dmY_His') . '.pdf';
        }
        if ($download) return $pdf->stream($filename);
        else return $pdf->output();
    }

    public function docx($id = null, $download = true)
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        if ($id) {
            $department = Department::where('id', $id)->where('status', 1)->first();
            if (!$department) return back()->with('error', 'Department not found');
            $section->addText("ID: {$department->id}");
            $section->addText("Name: {$department->name}");
        } else {
            $departments = Department::where('status', 1)->get();
            $table = $section->addTable();
            $table->addRow();
            $table->addCell(1750)->addText('ID');
            $table->addCell(1750)->addText('Name');
            foreach ($departments as $department) {
                $table->addRow();
                $table->addCell(1750)->addText($department->id);
                $table->addCell(1750)->addText($department->name);
            }
        }
        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $tempFile = tempnam(sys_get_temp_dir(), 'department_report');
        $writer->save($tempFile);
        if ($download) {
            return response()->download($tempFile, 'department_report.docx')->deleteFileAfterSend(true);
        } else {
            return file_get_contents($tempFile);
        }
    }

    public function xlsx($id = null, $download = true)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        if ($id) {
            $department = Department::where('id', $id)->where('status', 1)->first();
            if (!$department) return back()->with('error', 'Department not found');
            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', 'Name');
            $sheet->setCellValue('A2', $department->id);
            $sheet->setCellValue('B2', $department->name);
        } else {
            $departments = Department::where('status', 1)->get();
            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', 'Name');
            $row = 2;
            foreach ($departments as $department) {
                $sheet->setCellValue('A' . $row, $department->id);
                $sheet->setCellValue('B' . $row, $department->name);
                $row++;
            }
        }
        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'department_report');
        $writer->save($tempFile);
        if ($download) {
            return response()->download($tempFile, 'department_report.xlsx')->deleteFileAfterSend(true);
        } else {
            return file_get_contents($tempFile);
        }
    }

    public function email($id = null)
    {
        $to = Auth::user()->email;
        $pdfContent = $this->pdf($id, false);
        $docxContent = $this->docx($id, false);
        $xlsxContent = $this->xlsx($id, false);

        $message = "Attached is the department report.";
        $mailable = new DepartmentEmail($message);
        $mailable->attachData($pdfContent, 'department_report.pdf', ['mime' => 'application/pdf']);
        $mailable->attachData($docxContent, 'department_report.docx', ['mime' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']);
        $mailable->attachData($xlsxContent, 'department_report.xlsx', ['mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);
        Mail::to($to)->send($mailable);

        return back()->with('success', 'Email sent successfully to ' . $to);
    }
}
