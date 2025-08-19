<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;
use App\Mail\BrandEmail;
use Illuminate\Support\Facades\Mail;

class BrandController extends Controller
{
    public function index()
    {
        $index = 1;
        $brands = Brand::where('status', 1)->get();
        return view('brands.index', compact('brands', 'index'));
    }

    public function create()
    {
        return view('brands.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'website' => 'required|string|max:100',
            'support_email' => 'required|email|max:50',
            'is_active_supplier' => 'boolean',
        ]);

        $brand = Brand::create([
            'name' => $data['name'],
            'website' => $data['website'],
            'support_email' => $data['support_email'],
            'is_active_supplier' => $request->has('is_active_supplier'),
            'created_by' => Auth::user()->id,
        ]);

        if ($brand) {
            return redirect()->route('brands')->with('success', 'Brand created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create brand.');
        }
    }

    public function show($id)
    {
        $brand = Brand::where('id', Crypt::decrypt($id))->where('status', 1)->first();
        if (!$brand) {
            return redirect()->back()->with('error', 'Brand not found.');
        }
        return view('brands.show', compact('brand'));
    }

    public function edit($id)
    {
        $brand = Brand::where('id', Crypt::decrypt($id))->where('status', 1)->first();
        if (!$brand) {
            return redirect()->back()->with('error', 'Brand not found.');
        }
        return view('brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::where('id', $id)->where('status', 1)->first();
        if (!$brand) {
            return redirect()->back()->with('error', 'Brand not found.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'website' => 'required|string|max:100',
            'support_email' => 'required|email|max:50',
            'is_active_supplier' => 'boolean',
        ]);

        $brand->update([
            'name' => $data['name'],
            'website' => $data['website'],
            'support_email' => $data['support_email'],
            'is_active_supplier' => $request->has('is_active_supplier'),
            'updated_by' => Auth::user()->id,
        ]);

        return redirect()->route('brands')->with('success', 'Brand updated successfully.');
    }

    public function destroy($id)
    {
        $brand = Brand::where('id', $id)->where('status', 1)->first();
        if (!$brand) {
            return redirect()->back()->with('error', 'Brand not found.');
        }
        $brand->update(['status' => 0, 'deleted_by' => Auth::user()->id, 'deleted_at' => now()]);
        return redirect()->route('brands')->with('success', 'Brand deleted successfully.');
    }

    public function cancel($id)
    {
        $brand = Brand::where('id', $id)->where('status', 1)->first();
        if (!$brand) {
            return redirect()->back()->with('error', 'Brand not found.');
        }
        $brand->update(['active' => 'N', 'cancel_by' => Auth::user()->id, 'cancel_at' => now()]);
        return redirect()->route('brands')->with('success', 'Brand canceled successfully.');
    }

    public function pdf($id = null, $download = true)
    {
        if ($id) {
            $brand = Brand::where('id', Crypt::decrypt($id))->where('status', 1)->first();
            if (!$brand) return redirect()->route('brands')->with('error', 'Brand not found');
            $pdf = Pdf::loadView('brands.id', compact('brand'));
            $filename = 'report_of_' . $brand->name . '_' . now()->format('dmY_His') . '.pdf';
        } else {
            $brands = Brand::where('status', 1)->get();
            $pdf = Pdf::loadView('brands.all', compact('brands'));
            $filename = 'report_of_brands_' . now()->format('dmY_His') . '.pdf';
        }
        if ($download) return $pdf->stream($filename);
        else return $pdf->output();
    }

    public function docx($id = null, $download = true)
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        if ($id) {
            $brand = Brand::where('id', $id)->where('status', 1)->first();
            if (!$brand) return back()->with('error', 'Brand not found');
            $section->addText("ID: {$brand->id}");
            $section->addText("Name: {$brand->name}");
        } else {
            $brands = Brand::where('status', 1)->get();
            $table = $section->addTable();
            $table->addRow();
            $table->addCell(1750)->addText('ID');
            $table->addCell(1750)->addText('Name');
            foreach ($brands as $brand) {
                $table->addRow();
                $table->addCell(1750)->addText($brand->id);
                $table->addCell(1750)->addText($brand->name);
            }
        }
        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $tempFile = tempnam(sys_get_temp_dir(), 'brand_report');
        $writer->save($tempFile);
        if ($download) {
            return response()->download($tempFile, 'brand_report.docx')->deleteFileAfterSend(true);
        } else {
            return file_get_contents($tempFile);
        }
    }

    public function xlsx($id = null, $download = true)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        if ($id) {
            $brand = Brand::where('id', $id)->where('status', 1)->first();
            if (!$brand) return back()->with('error', 'Brand not found');
            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', 'Name');
            $sheet->setCellValue('A2', $brand->id);
            $sheet->setCellValue('B2', $brand->name);
        } else {
            $brands = Brand::where('status', 1)->get();
            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', 'Name');
            $row = 2;
            foreach ($brands as $brand) {
                $sheet->setCellValue('A' . $row, $brand->id);
                $sheet->setCellValue('B' . $row, $brand->name);
                $row++;
            }
        }
        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'brand_report');
        $writer->save($tempFile);
        if ($download) {
            return response()->download($tempFile, 'brand_report.xlsx')->deleteFileAfterSend(true);
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

        $message = "Attached is the brand report.";
        $mailable = new BrandEmail($message);
        $mailable->attachData($pdfContent, 'brand_report.pdf', ['mime' => 'application/pdf']);
        $mailable->attachData($docxContent, 'brand_report.docx', ['mime' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']);
        $mailable->attachData($xlsxContent, 'brand_report.xlsx', ['mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);
        Mail::to($to)->send($mailable);

        return back()->with('success', 'Email sent successfully to ' . $to);
    }
}
