<?php

namespace App\Http\Controllers;

use App\Mail\ComputerEmail;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Computer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;


class ComputerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $index = 1;
        $computers = Computer::where('status', 1)->get();
        return view('computers.index', compact('computers','index'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::where('status', 1)->get();
        $branches = Branch::where('status', 1)->get();
        return view('computers.create', compact('brands', 'branches'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'serial_number' => 'required|string|unique:computers,serial_number',
            'brand_id' => 'required|integer', # Como aun no existe la tabla de brands, se optara por numero entero
            'model' => 'required|string|max:255',
            'description' => 'required|string',
            'specify' => 'required|string',
            'os' => 'required|string',
            'purchase_date' => 'nullable|date', # Se optara por nullable por que no se si tengamos tickets de las compras de la computadoras
            'warranty_until'=> 'nullable|date', # Se optara por nullable por que no se si algunas no tienen garantias
            'branch_id' => 'required|integer', # Lugar donde esta la computadora, aun no existe la tabla de sucursales asi que vamos a ponerlos en numeros por lo pronto
        ]);

        $computer = Computer::create([
            'name'=>$data['name'],
            'serial_number' => $data['serial_number'],
            'brand_id' => $data['brand_id'],
            'model'=>$data['model'],
            'description'=>$data['description'],
            'specify'=>$data['specify'],
            'os'=>$data['os'],
            'purchase_date' => $data['purchase_date'],
            'warranty_until'=> $data['warranty_until'] ,
            'branch_id' => $data['branch_id'],
            'created_by' => Auth::user()->id,
            'active'=>"S",
            'status'=>1
        ]);


        if ($computer) return redirect()->route('computers')->with("success", "Computer add successfary");
        else return redirect()->back()->with("error", "No se pudo agregar la computadora");

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $computer = Computer::where('id',Crypt::decrypt($id))->where('status', 1)->first();
        return view('computers.show', compact('computer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $computer = Computer::where('id',Crypt::decrypt($id))->where('status', 1)->first();
        $brands = Brand::where('status', 1)->get();
        $branches = Branch::where('status', 1)->get();
        return view('computers.edit', compact('brands', 'branches', 'computer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $computer = Computer::where('id',$id)->where('status',1)->first();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'serial_number' => 'required|string|unique:computers,serial_number,' . $computer->id,
            'brand_id' => 'required|integer', # Como aun no existe la tabla de brands, se optara por numero entero
            'model' => 'required|string|max:255',
            'description' => 'required|string',
            'specify' => 'required|string',
            'os' => 'required|string',
            'purchase_date' => 'nullable|date', # Se optara por nullable por que no se si tengamos tickets de las compras de la computadoras
            'warranty_until'=> 'nullable|date', # Se optara por nullable por que no se si algunas no tienen garantias
            'branch_id' => 'required|integer', # Lugar donde esta la computadora, aun no existe la tabla de sucursales asi que vamos a ponerlos en numeros por lo pronto
            'active' => 'required|string|max:1'
        ]);

        $computer->update([
            'name'=>$data['name'],
            'serial_number' => $data['serial_number'],
            'brand_id' => $data['brand_id'],
            'model'=>$data['model'],
            'description'=>$data['description'],
            'specify'=>$data['specify'],
            'os'=>$data['os'],
            'purchase_date' => $data['purchase_date'],
            'warranty_until'=> $data['warranty_until'] ,
            'branch_id' => $data['branch_id'],
            'updated_by' => Auth::user()->id,
            'active'=>$data['active'],
            'status'=>1
        ]);

        if ($computer) {
            return redirect()->route('computers')->with("success", "Computadora actualizada");
        } else {
            return redirect()->back()->with("error", "No se pudo actualizar la computadora");
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $computer = Computer::where('id',$id)->where('status', 1)->first();
        $computer->update(['status' => 0, 'updated_at' => now(), 'active' => "N", 'deleted_by' => Auth::user()->id]);
        if ($computer)return redirect()->route('computers')->with("success", "Computadora eliminada");
    }

    public function cancel($id)
    {
        $computer = Computer::where('id',$id)->where('status', 1)->first();
        $computer->update(['updated_at' => now(), 'active' => "N", 'cancel_by' => Auth::user()->id ]);
        if ($computer)return redirect()->route('computers')->with("success", "Computadora cancelada");
    }

    public function pdf($id = null, $download = true)
    {
        if ($id){
            $computer = Computer::where('id', $id)->where('status',1)->first();
            $pdf = Pdf::loadView('computers.id', compact('computer'));
        }
        else{
            $computers = Computer::where('status',1)->get();
            $pdf = Pdf::loadView('computers.all', compact('computers'));
        }

        if ($download) {
            return $pdf->stream('reporte_computadoras'.date('dmY_his').'.pdf'); // para descarga
        } else {
            return $pdf->output(); // contenido en crudo para email
        }
    }

    public function docx($id = null, $download = true)
    {
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
        $computer = Computer::where('id', decrypt($id))->where('status', 1)->first();
                if (!$computer) {
                    return back()->with('error', 'Computadora no encontrada');
                }

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
                $computers = Computer::where('status', 1)->get();

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

    public function xlsx($id = null, $download = true)
    {
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
        $computers = $id ? [Computer::where('id', decrypt($id))->where('status', 1)->first()] : Computer::where('status', 1)->get();
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

    public function email($id = null)
    {
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
        $mailable = new ComputerEmail($message);
        $mailable->attachData($pdfContent, 'reporte_computadoras.pdf', [
            'mime' => 'application/pdf'
        ]);
        $mailable->attachData($docxContent, 'reporte_computadoras.docx', [
            'mime' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ]);
        $mailable->attachData($xlsxContent, 'reporte_computadoras.xlsx', [
            'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]);
        Mail::to($to)->send($mailable);
        return back()->with('success', 'Correo enviado con éxito a ' . $to);
    }

}
