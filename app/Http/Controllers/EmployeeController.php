<?php

namespace App\Http\Controllers;

use App\Mail\EmployeeEmail;
use App\Models\Branch;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Position;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $index = 1;
        $employees = Employee::where('status',1)->get();
        return view('employees.index', compact('employees', 'index'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::where('status', 1)->get();
        $positions = Position::where('status', 1)->get();
        return view('employees.create', compact('positions','branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:40',
            'first_lastname' => 'required|string|max:40',
            'seccond_lastname' => 'required|string|max:40',
            'street' => 'required|string|max:20',
            'interior_number' => 'required|string|max:20',
            'exterior_number' => 'required|string|max:20',
            'colony' => 'required|string|max:40',
            'zip_code' => 'required|string|max:10',
            'email' => 'required|email|max:50|unique:employees,email',
            'phone' => 'nullable|string|max:20',
            'employee_number' => 'required|string|max:40',
            'hire_date' => 'nullable|date',
            'birth_date' => 'nullable|date',
            'gender' => 'required|string',
            'RFC' => 'string|max:13|required',
            'curp' => 'string|required',
            'NSS' => 'string|required',
            'branch_id' => 'integer|required',
            'emergency_contact'=>'string|nullable',
            'position_id' => 'required|integer|exists:positions,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $employee = Employee::create([
            'name' => $data['name'],
            'first_lastname' => $data['first_lastname'],
            'seccond_lastname' => $data['seccond_lastname'],
            'street' => $data['street'],
            'interior_number' => $data['interior_number'],
            'exterior_number' => $data['exterior_number'],
            'colony' => $data['colony'],
            'zip_code' => $data['zip_code'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'hire_date' => $data['hire_date'],
            'birth_date' => $data['birth_date'],
            'gender' => $data['gender'],
            'RFC' => $data['RFC'],
            'curp' => $data['curp'],
            'NSS' => $data['NSS'],
            'branch_id' => $data['branch_id'],
            'emergency_contact' => $data['emergency_contact'],
            'position_id' => $data['position_id'],
            'created_by' => Auth::user()->id,
            'active' => 'S',
            'status' => 1,
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $employee->id . '.png';
            $path = 'employees/';
            $storedPath = $image->storeAs($path, $imageName, 'public');
        }

        return redirect()->route('employees')->with('success', 'Empleado creado correctamente.');
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $employee = Employee::where('id', $id)->where('status', 1)->first();
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $positions = Position::where('status', 1)->get();
        $employee = Employee::where('id', $id)->where('status', 1)->first();
        return view('employees.edit', compact('employee', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {

        $employee = Employee::where('id',$id)->where('status',1)->first();

        $data = $request->validate([
            'name' => 'required|string|max:40',
            'first_lastname' => 'required|string|max:40',
            'seccond_lastname' => 'required|string|max:40',
            'street' => 'required|string|max:20',
            'interior_number' => 'required|string|max:20',
            'exterior_number' => 'required|string|max:20',
            'colony' => 'required|string|max:40',
            'zip_code' => 'required|string|max:10',
            'email' => 'required|email|max:50|unique:employees,email,' . $employee->id,
            'phone' => 'nullable|string|max:20',
            'hire_date' => 'nullable|date',
            'birth_date' => 'nullable|date',
            'gender' => 'required|string',
            'RFC' => 'string|max:13|required',
            'curp' => 'string|required',
            'NSS' => 'string|required',
            'branch_id' => 'integer|required',
            'emergency_contact'=>'string|nullable',
            'position_id' => 'required|integer|exists:positions,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $employee->update([
            'name' => $data['name'],
            'first_lastname' => $data['first_lastname'],
            'seccond_lastname' => $data['seccond_lastname'],
            'street' => $data['street'],
            'interior_number' => $data['interior_number'],
            'exterior_number' => $data['exterior_number'],
            'colony' => $data['colony'],
            'zip_code' => $data['zip_code'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'hire_date' => $data['hire_date'],
            'birth_date' => $data['birth_date'],
            'gender' => $data['gender'],
            'RFC' => $data['RFC'],
            'curp' => $data['curp'],
            'NSS' => $data['NSS'],
            'branch_id' => $data['branch_id'],
            'emergency_contact' => $data['emergency_contact'],
            'position_id' => $data['position_id'],
            'user_id' => Auth::user()->id,
            'active' => 'S',
            'status' => 1,
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete('employees/' . $employee->id . '.png');
            $image = $request->file('image');
            $imageName = $employee->id . '.png';
            $image->storeAs('employees', $imageName, 'public');
        }

        if ($request->has('delete_image')) {
            Storage::disk('public')->delete('employees/' . $employee->id . '.png');
        }

        return redirect()->route('employees')->with('success', 'Empleado actualizado correctamente.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $employee = Employee::where('id',$id)->where('status',1)->first();
        $employee->update(['active'=>"N",'status'=>0,'updated_at'=>now()]);
        return redirect()->route('employees')->with('success', 'employee deleted successfully.');

    }

    public function pdf($id = null, $download = True) {
        if ($id){
            $employee = Employee::where('id',$id)->where('status',1)->first();
            $pdf = Pdf::loadView('employees.id', compact('employee'));
        }
        else{
            $employees = Employee::where('status',1)->get();
            $pdf = Pdf::loadView('employees.all', compact('employees'));
        }

        if ($download) {
            return $pdf->stream('reporte_empleados_'.date('dmY_his').'.pdf'); // para descarga
        } else {
            return $pdf->output(); // contenido en crudo para email
        }
    }

    public function docx($id = null, $download = true) {
        $phpWord = new PhpWord;
        $section = $phpWord->addSection();
        # --- Header ---
        # Logo de la empresa de la empresa centrado W-30 H-30 centrado
        $image = public_path('/sisa-logo.png');
        if (file_exists($image)){
            $section->addImage($image,[
                'width' => 60,
                'height' => 60,
                'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
            ]);
        }
        # Titulo "Reporte de Computadoras"  # Mayusculas, negras, Arial 16 centrado
        $section->addText('REPORTE DE COMPUTADORAS', [
            'bold' => true,
            'size' => 16,
            'allCaps' => true,
            'color' => '000000',
            'name' => 'Arial'
        ], ['alignment' => 'center']);

        # Fecha y hora actual # Mayusculas, Negras, Arial 14 a la derecha
        $section->addText(date('D-M-Y H:i'), [
            'bold' => true,
            'size' => 12,
            'color' => '000000',
            'name' => 'Arial'
        ], ['alignment' => 'right']);

        # Ciudad, Estado, Pais (Hermosillo, Sonora, México) # Mayusculas, Negras, Arial 14 a la derecha
        $section->addText('Hermosillo, Sonora, México', [
            'bold' => true,
            'size' => 12,
            'allCaps' => true,
            'color' => '000000',
            'name' => 'Arial'
        ], ['alignment' => 'right']);

        # --- Header ---
        $section->addTextBreak(1);
        # --- Main ---
        if ($id){
        $computer = Employee::where('id', $id)->where('status', 1)->first();
                if (!$computer) {
                    return back()->with('error', 'Computadora no encontrada');
                }

                $section->addText("ID: {$computer->id}");
                $section->addText("Nombre: {$computer->name}");
                $section->addText("Número de serie: {$computer->serial_number}");
                $section->addText("Marca: {$computer->brand_id}");
                $section->addText("Modelo: {$computer->model}");
                $section->addText("Sistema Operativo: {$computer->OS}");
                $section->addText("Fecha de compra: {$computer->purchase_date}");
                $section->addText("Fecha de garantía: {$computer->warranty_until}");
                $section->addText("Sucursal: {$computer->branch_id}");
                $section->addText("Activo: " . ($computer->active === 'S' ? 'Sí' : 'No'));
                $section->addText("Creado: " . ($computer->created_at ? $computer->created_at->format('d/m/Y H:i') : ''));
                $section->addText("Actualizado: " . ($computer->updated_at ? $computer->updated_at->format('d/m/Y H:i') : ''));
                $section->addTextBreak(1);

                $section->addText('Especificaciones:', ['bold' => true, 'color' => '007bff']);
                $section->addText($computer->specify ?? 'Sin especificaciones.');
                $section->addTextBreak(1);

                $section->addText('Descripción:', ['bold' => true, 'color' => '007bff']);
                $section->addText($computer->description ?? 'Sin descripción.');
            }
            else {
                // Tabla para todos
                $computers = Employee::where('status', 1)->get();

                $table = $section->addTable([
                    'borderSize' => 6,
                    'borderColor' => '999999',
                    'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
                    'cellMargin' => 80
                ]);

                // Encabezado
                $table->addRow();
                $headers = ['ID', 'Nombre', 'Serie', 'Marca', 'Modelo', 'SO', 'Compra', 'Garantía', 'Sucursal', 'Activo'];
                foreach ($headers as $header) {
                    $table->addCell(1200, ['bgColor' => 'cccccc'])->addText($header, ['bold' => true]);
                }

                foreach ($computers as $computer) {
                    $table->addRow();
                    $table->addCell(1200)->addText($computer->id);
                    $table->addCell(1200)->addText($computer->name);
                    $table->addCell(1200)->addText($computer->serial_number);
                    $table->addCell(1200)->addText($computer->brand_id);
                    $table->addCell(1200)->addText($computer->model);
                    $table->addCell(1200)->addText($computer->OS);
                    $table->addCell(1200)->addText($computer->purchase_date);
                    $table->addCell(1200)->addText($computer->warranty_until);
                    $table->addCell(1200)->addText($computer->branch_id);
                    $table->addCell(1200)->addText($computer->active === 'S' ? 'Sí' : 'No');
                }
        }
        # --- Main ---
        # --- Footer ---
        $section->addTextBreak(2);
        $footer = $section->addFooter();
        #   # Numero de pagina

        #   # Usuario que lo genero
        $footer->addText('Generado por: ' . (Auth::user()->name ?? 'Sistema') . ('('.Auth::user()->email.')'), ['italic' => true, 'size' => 10], ['alignment' => 'right']);
        $footer->addPreserveText('Página {PAGE} de {NUMPAGES}.', [
        'size' => 10
        ], ['alignment' => 'center']);
        # --- Footer ---
            // Guardar en memoria
        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $temp_file = tempnam(sys_get_temp_dir(), 'word');
        $writer->save($temp_file);
        if ($download) {
            // Descargar el archivo
            return response()->download($temp_file, 'reporte_computadora_'. date('dmY_his') .'.docx')->deleteFileAfterSend(true);
        } else {
            // Devolver el contenido para email u otro uso
            $content = file_get_contents($temp_file);
            unlink($temp_file);
            return $content;
        }

    }


    public function xlsx($id = null, $download = true) {
        # --- Header ---
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Imagen de la empresa dentro exclusivamente dentro de A1:C3, Merge & center
        $logo = public_path('./sisa-logo.png');
        if (file_exists($logo)){
            $drawing = new Drawing();
            $drawing->setPath($logo);
            $drawing->setCoordinates('A1');
            $drawing->setHeight(70);
            $drawing->setWorksheet($sheet);
        }
        $sheet->mergeCells('A1:C3');
        // Nombre del reporte "REPORTE DE COMPUTADORAS" en D1:L1 BOLD, Arial 14, Merge & center
        $sheet->mergeCells('D1:L1');
        $sheet->setCellValue('D1', 'REPORTE DE COMPUTADORAS');
        $sheet->getStyle('D1')->getFont()->setBold(true)->setSize(14)->setName('Arial');
        $sheet->getStyle('D1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Nombre del usuario en D2:L2 BOLD, Arial 14, Merge & center
        $sheet->mergeCells('D2:L2');
        $sheet->setCellValue('D2', 'Usuario: ' . (Auth::user()->name ?? 'Sistema'));
        $sheet->getStyle('D2')->getFont()->setBold(true)->setSize(14)->setName('Arial');
        $sheet->getStyle('D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        // FECHA en formato D/M/Y h:i en D3:L3 BOLD, Arial 14, Merge & center
        $sheet->mergeCells('D3:L3');
        $sheet->setCellValue('D3', date('d/m/Y H:i'));
        $sheet->getStyle('D3')->getFont()->setBold(true)->setSize(14)->setName('Arial');
        $sheet->getStyle('D3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        # --- Header ---
        # --- Main ---
        // Titulo del reporte "REPORTE DE COMPUTADORAS" en A4:L4 BOLD, Arial 16, Merge & center
        $sheet->mergeCells('A4:L4');
        $sheet->setCellValue('A4', 'REPORTE DE COMPUTADORAS');
        $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(16)->setName('Arial');
        $sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        // columnas de la tabla, en A5:L5 BOLD, Middle Align, Arial 12
        $headers = ['ID', 'Nombre', 'Serie', 'Marca', 'Modelo', 'SO', 'Compra', 'Garantía', 'Sucursal', 'Activo', 'Especificaciones', 'Descripción'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '5', $header);
            $sheet->getStyle($col . '5')->getFont()->setBold(true)->setSize(12)->setName('Arial');
            $sheet->getStyle($col . '5')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $col++;
        }
        // COLUMNAS CON LOS DATOS en A6:L6 si puedes centrar y ajustar los datos lo agradeceria.
        $fila = 6;
        $computers = $id ? [Employee::where('id', $id)->where('status', 1)->first()] : Employee::where('status', 1)->get();
        foreach ($computers as $computer) {
            if (!$computer) continue;

            $datos = [
                $computer->id,
                $computer->name,
                $computer->serial_number,
                $computer->brand_id,
                $computer->model,
                $computer->OS,
                $computer->purchase_date,
                $computer->warranty_until,
                $computer->branch_id,
                $computer->active === 'S' ? 'Sí' : 'No',
                $computer->specify ?? 'Sin especificaciones',
                $computer->description ?? 'Sin descripción',
            ];

            $col = 'A';
            foreach ($datos as $valor) {
                $sheet->setCellValue($col . $fila, $valor);
                $sheet->getStyle($col . $fila)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getColumnDimension($col)->setAutoSize(true);
                $col++;
            }
            $fila++;
        }
        # ---Main ---

        // --- OUTPUT ---
        $writer = new Xlsx($spreadsheet);
        $temp_file = tempnam(sys_get_temp_dir(), 'excel_');

        $writer->save($temp_file);

        if ($download) {
            return response()->download($temp_file, 'reporte_computadoras_'.date('dmY_h1') .'.xlsx')->deleteFileAfterSend(true);
        } else {
            $content = file_get_contents($temp_file);
            unlink($temp_file);
            return $content;
        }
    }


    public function email($id = null) {
        $to = Auth::user()->email;
        $pdfContent = $this->pdf($id, false);
        $docxContent = $this->docx($id, false);
        $xlsxContent = $this->xlsx($id, false);

        $message = <<<EOT
        Estimado usuario,

        Se ha generado y enviado correctamente el reporte de las computadoras o computadora registrados en el sistema.
        Adjunto a este correo encontrará los archivos en formato PDF, Excel y Word para su consulta.

        Saludos cordiales,
        Departamento de sistemas.
        EOT;
        $mailable = new EmployeeEmail($message);
        $mailable->attachData($pdfContent, 'reporte_computadoras_'. date('dmY_Hi') .'.pdf', [
            'mime' => 'application/pdf'
        ]);
        $mailable->attachData($docxContent, 'reporte_computadoras_'. date('dmY_Hi') .'.docx', [
            'mime' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ]);
        $mailable->attachData($xlsxContent, 'reporte_computadoras._'. date('dmY_Hi') .'xlsx', [
            'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]);
        Mail::to($to)->send($mailable);
        return back()->with('success', 'Correo enviado con éxito a ' . $to);
    }
}
