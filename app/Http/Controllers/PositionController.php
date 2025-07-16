<?php

namespace App\Http\Controllers;

use App\Mail\PositionEmail;
use App\Models\Position;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\PhpWord;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $index = 1;
        $positions = Position::where('status', 1)->get();
        return view('positions.index', compact('positions', 'index'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('positions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|integer',
            'department_id' => 'required|integer',
            'description' => 'nullable|string|max:500',
            'salary' => 'required|numeric|min:0',
            'active' => 'string|default:S',
            'status' => 'boolean|default:1',
        ]);

        $position = Position::create([
            'name' => $data['name'],
            'level' => $data['level'],
            'department_id' => $data['department_id'],
            'description' => $data['description'],
            'salary' => $data['salary'],
            'user_id' => Auth::user()->id,
            'active' => "S",
            'status' => 1, // Status by default
        ]);

        if ($position) {
            return redirect()->route('positions')->with('success', 'Position created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create position.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        $position = Position::where('id',$id)->where('status',1)->first();
        return view('positions.show', compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) {
        $position = Position::where('id',$id)->where('status',1)->first();
        return view('positions.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
        $position = Position::where('id',$id)->where('status',1)->first();

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:positions,name,' . $position->id,
            'level' => 'required|integer',
            'department_id' => 'required|integer',
            'description' => 'nullable|string|max:500',
            'salary' => 'required|numeric|min:0',
            'active' => 'required|string|in:S,N', // S = Si, N = No
            'status' => 'boolean|default:1',
        ]);

        $position->update([
            'name' => $data['name'],
            'level' => $data['level'],
            'department_id' => $data['department_id'],
            'description' => $data['description'],
            'salary' => $data['salary'],
            'active' => $data['active'],
            'status' => 1, // Status by default
            'updated_at' => now(),
        ]);

        if ($position) {
            return redirect()->route('positions')->with('success', 'Position updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update position.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $position = Position::where('id',$id)->where('status',1)->first();
        $position->update(['active'=>"N",'status'=>0,'updated_at'=>now()]);
        return redirect()->route('positions')->with('success', 'Position deleted successfully.');
    }

    public function pdf($id = null, $download = True) {
        if ($id){
            $position = Position::where('id',$id)->where('status',1)->first();
            $pdf = Pdf::loadView('positions.id', compact('position'));
        }
        else{
            $positions = Position::where('status',1)->get();
            $pdf = Pdf::loadView('positions.all', compact('positions'));
        }

        if ($download) {
            return $pdf->stream('reporte_puestos'.date('dmY_his').'.pdf'); // para descarga
        } else {
            return $pdf->output(); // contenido en crudo para email
        }
    }

    public function docx($id = null, $download = True) {
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
        # Titulo "Reporte de puestos"  # Mayusculas, negras, Arial 16 centrado
        $section->addText('REPORTE DE PUESTOS', [
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
        $position = Position::where('id', $id)->where('status', 1)->first();
                if (!$position) {
                    return back()->with('error', 'Puesto no encontrada');
                }

                $section->addText("ID: {$position->id}");
                $section->addText("Nombre: {$position->name}");
                $section->addText("Nivel: {$position->level}");
                $section->addText("Departamento: {$position->department_id}");
                $section->addText("Salario: {$position->OS}");
                $section->addText("Activo: " . ($position->active === 'S' ? 'Sí' : 'No'));
                $section->addText("Creado: " . ($position->created_at ? $position->created_at->format('d/m/Y H:i') : ''));
                $section->addText("Actualizado: " . ($position->updated_at ? $position->updated_at->format('d/m/Y H:i') : ''));
                $section->addTextBreak(1);

                $section->addText('Descripción:', ['bold' => true, 'color' => '007bff']);
                $section->addText($position->description ?? 'Sin descripción.');
            }
            else {
                // Tabla para todos
                $positions = Position::where('status', 1)->get();

                $table = $section->addTable([
                    'borderSize' => 6,
                    'borderColor' => '999999',
                    'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
                    'cellMargin' => 80
                ]);

                // Encabezado
                $table->addRow();
                $headers = ['ID', 'Nombre', 'Nivel', 'Departamento', 'Descripcion', 'Salario', 'Activo'];

                $niveles = [
                    1 => 'Administrativo',
                    2 => 'Operativo',
                    3 => 'Supervisión/Coordinación',
                    4 => 'Dirección/Gerencia',
                ];
                foreach ($headers as $header) {
                    $table->addCell(1200, ['bgColor' => 'cccccc'])->addText($header, ['bold' => true]);
                }

                foreach ($positions as $position) {
                    $table->addRow();
                    $table->addCell(1200)->addText($position->id);
                    $table->addCell(1200)->addText($position->name);
                    $table->addCell(1200)->addText($niveles[$position->level] ?? 'Desconocido');
                    $table->addCell(1200)->addText($position->department_id);
                    $table->addCell(1200)->addText($position->description);
                    $table->addCell(1200)->addText($position->salary);
                    $table->addCell(1200)->addText($position->active === 'S' ? 'Sí' : 'No');
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
            return response()->download($temp_file, 'reporte_puestos_'. date('dmY_his') .'.docx')->deleteFileAfterSend(true);
        } else {
            // Devolver el contenido para email u otro uso
            $content = file_get_contents($temp_file);
            unlink($temp_file);
            return $content;
        }
    }

    public function xlsx($id = null, $download = True) {
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
            // Nombre del reporte "REPORTE DE PUESTOS" en D1:L1 BOLD, Arial 14, Merge & center
            $sheet->mergeCells('D1:L1');
            $sheet->setCellValue('D1', 'REPORTE DE PUESTOS');
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
            // Titulo del reporte "REPORTE DE PUESTOS" en A4:L4 BOLD, Arial 16, Merge & center
            $sheet->mergeCells('A4:L4');
            $sheet->setCellValue('A4', 'REPORTE DE PUESTOS');
            $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(16)->setName('Arial');
            $sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            // columnas de la tabla, en A5:L5 BOLD, Middle Align, Arial 12
            $headers = ['ID', 'Nombre', 'Nivel', 'Departamento', 'Descripcion', 'Salario', 'Activo'];
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . '5', $header);
                $sheet->getStyle($col . '5')->getFont()->setBold(true)->setSize(12)->setName('Arial');
                $sheet->getStyle($col . '5')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $col++;
            }
            // COLUMNAS CON LOS DATOS en A6:L6 si puedes centrar y ajustar los datos lo agradeceria.
            $fila = 6;
            $niveles = [
                1 => 'Administrativo',
                2 => 'Operativo',
                3 => 'Supervisión/Coordinación',
                4 => 'Dirección/Gerencia',
            ];
            $positions = $id ? [Position::where('id', $id)->where('status', 1)->first()] : Position::where('status', 1)->get();
            foreach ($positions as $position) {
                if (!$position) continue;

                $datos = [
                    $position->id,
                    $position->name,
                    $niveles[$position->level] ?? 'Desconocido',
                    $position->department_id,
                    $position->description,
                    $position->salary,
                    $position->active === 'S' ? 'Sí' : 'No',
                    $position->description ?? 'Sin descripción',
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
                return response()->download($temp_file, 'reporte_puestos_'.date('dmY_hi') .'.xlsx')->deleteFileAfterSend(true);
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

        Se ha generado y enviado correctamente el reporte de las puestos o puesto registrados en el sistema.
        Adjunto a este correo encontrará los archivos en formato PDF, Excel y Word para su consulta.

        Saludos cordiales,
        Departamento de sistemas.
        EOT;
        $mailable = new PositionEmail($message);
        $mailable->attachData($pdfContent, 'reporte_puestos_' . date('dmY_Hi') .'.pdf', [
            'mime' => 'application/pdf'
        ]);
        $mailable->attachData($docxContent, 'reporte_puestos_' . date('dmY_Hi') .'.docx', [
            'mime' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ]);
        $mailable->attachData($xlsxContent, 'reporte_puestos_' . date('dmY_Hi') .'.xlsx', [
            'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]);
        Mail::to($to)->send($mailable);
        return back()->with('success', 'Correo enviado con éxito a ' . $to);
    }
}
