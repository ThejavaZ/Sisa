<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;
use App\Mail\BranchEmail;
use Illuminate\Support\Facades\Mail;

class BranchController extends Controller
{
    public function index()
    {
        $index = 1;
        $branches = Branch::where('status', 1)->get();
        return view('branches.index', compact('branches', 'index'));
    }

    public function create()
    {
        return view('branches.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'street' => 'required|string|max:20',
            'interior_number' => 'nullable|string|max:20',
            'exterior_number' => 'required|string|max:20',
            'colony' => 'required|string|max:40',
            'zip_code' => 'required|string|max:10',
            'phone' => 'string|max:20',
        ]);

        $branch = Branch::create([
            'name' => $data['name'],
            'street' => $data['street'],
            'interior_number' => $data['interior_number'],
            'exterior_number' => $data['exterior_number'],
            'colony' => $data['colony'],
            'zip_code' => $data['zip_code'],
            'phone' => $data['phone'],
            'is_main' => $request->has('is_main'),
            'created_by' => Auth::user()->id,
        ]);

        if ($branch) return redirect()->route('branches')->with('success', 'Branch created successfully.'); 
        else return redirect()->back()->with('error', 'Failed to create branch.');
        
    }

    public function show($id)
    {
        $branch = Branch::where('id', Crypt::decrypt($id))->where('status', 1)->first();
        if (!$branch) {
            return redirect()->back()->with('error', 'Branch not found.');
        }
        return view('branches.show', compact('branch'));
    }

    public function edit($id)
    {
        $branch = Branch::where('id', Crypt::decrypt($id))->where('status', 1)->first();
        if (!$branch) {
            return redirect()->back()->with('error', 'Branch not found.');
        }
        return view('branches.edit', compact('branch'));
    }

    public function update(Request $request, $id)
    {
        $branch = Branch::where('id', $id)->where('status', 1)->first();
        if (!$branch) {
            return redirect()->back()->with('error', 'Branch not found.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'street' => 'required|string|max:20',
            'interior_number' => 'nullable|string|max:20',
            'exterior_number' => 'required|string|max:20',
            'colony' => 'required|string|max:40',
            'zip_code' => 'required|string|max:10',
            'phone' => 'required|string|max:20',
            'is_main' => 'boolean',
        ]);

        $branch->update([
            'name' => $data['name'],
            'street' => $data['street'],
            'interior_number' => $data['interior_number'],
            'exterior_number' => $data['exterior_number'],
            'colony' => $data['colony'],
            'zip_code' => $data['zip_code'],
            'phone' => $data['phone'],
            'is_main' => $request->has('is_main'),
            'updated_by' => Auth::user()->id,
        ]);

        return redirect()->route('branches')->with('success', 'Branch updated successfully.');
    }

    public function destroy($id)
    {
        $branch = Branch::where('id', Crypt::decrypt($id))->where('status', 1)->first();
        if (!$branch) {
            return redirect()->back()->with('error', 'Branch not found.');
        }
        $branch->update(['status' => 0, 'deleted_by' => Auth::user()->id, 'deleted_at' => now()]);
        return redirect()->route('branches')->with('success', 'Branch deleted successfully.');
    }

    public function cancel($id)
    {
        $branch = Branch::where('id', Crypt::decrypt($id))->where('status', 1)->first();
        if (!$branch) {
            return redirect()->back()->with('error', 'Branch not found.');
        }
        $branch->update(['active' => 'N', 'cancel_by' => Auth::user()->id, 'cancel_at' => now()]);
        return redirect()->route('branches')->with('success', 'Branch canceled successfully.');
    }

    public function pdf($id = null, $download = true)
    {
        if ($id) {
            $branch = Branch::where('id', Crypt::decrypt($id))->where('status', 1)->first();
            if (!$branch) return redirect()->route('branches')->with('error', 'Branch not found');
            $pdf = Pdf::loadView('branches.id', compact('branch'));
            $filename = 'report_of_' . $branch->name . '_' . now()->format('dmY_His') . '.pdf';
        } else {
            $branches = Branch::where('status', 1)->get();
            $pdf = Pdf::loadView('branches.all', compact('branches'));
            $filename = 'report_of_branches_' . now()->format('dmY_His') . '.pdf';
        }
        if ($download) return $pdf->stream($filename);
        else return $pdf->output();
    }

    public function docx($id = null, $download = true)
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        if ($id) {
            $branch = Branch::where('id', Crypt::decrypt($id))->where('status', 1)->first();
            if (!$branch) return back()->with('error', 'Branch not found');
            $section->addText("ID: {$branch->id}");
            $section->addText("Name: {$branch->name}");
        } else {
            $branches = Branch::where('status', 1)->get();
            $table = $section->addTable();
            $table->addRow();
            $table->addCell(1750)->addText('ID');
            $table->addCell(1750)->addText('Name');
            foreach ($branches as $branch) {
                $table->addRow();
                $table->addCell(1750)->addText($branch->id);
                $table->addCell(1750)->addText($branch->name);
            }
        }
        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $tempFile = tempnam(sys_get_temp_dir(), 'branch_report');
        $writer->save($tempFile);
        if ($download) {
            return response()->download($tempFile, 'branch_report.docx')->deleteFileAfterSend(true);
        } else {
            return file_get_contents($tempFile);
        }
    }

    public function xlsx($id = null, $download = true)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        if ($id) {
            $branch = Branch::where('id', Crypt::decrypt($id))->where('status', 1)->first();
            if (!$branch) return back()->with('error', 'Branch not found');
            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', 'Name');
            $sheet->setCellValue('A2', $branch->id);
            $sheet->setCellValue('B2', $branch->name);
        } else {
            $branches = Branch::where('status', 1)->get();
            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', 'Name');
            $row = 2;
            foreach ($branches as $branch) {
                $sheet->setCellValue('A' . $row, $branch->id);
                $sheet->setCellValue('B' . $row, $branch->name);
                $row++;
            }
        }
        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'branch_report');
        $writer->save($tempFile);
        if ($download) {
            return response()->download($tempFile, 'branch_report.xlsx')->deleteFileAfterSend(true);
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

        $message = "Attached is the branch report.";
        $mailable = new BranchEmail($message);
        $mailable->attachData($pdfContent, 'branch_report.pdf', ['mime' => 'application/pdf']);
        $mailable->attachData($docxContent, 'branch_report.docx', ['mime' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']);
        $mailable->attachData($xlsxContent, 'branch_report.xlsx', ['mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);
        Mail::to($to)->send($mailable);

        return back()->with('success', 'Email sent successfully to ' . $to);
    }
}
