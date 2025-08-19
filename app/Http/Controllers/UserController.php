<?php

namespace App\Http\Controllers;

use App\Mail\UserEmail;
use Illuminate\Http\Request;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()->role > 2) return redirect()->route('home')->with('ERROR', 'Not autorized');
        $users = User::where('status', 1)->get();
        $index = 1;
        return view('users.index', compact('users','index'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|integer',
            'language' => 'required|integer',
            'active' => 'string|max:1',
            'status' => 'boolean|default:1',
        ]);

        $user = User::create([
            "name"=>$data['name'],
            "email"=>$data["email"],
            "password"=>Hash::make("Sisa." . Date('Y')),
            "role"=>$data["role"],
            "language"=>$data["language"],
            "created_by" => Auth::user()->id,
            "active"=>"S",
            "status"=>1
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $user->id . '.png';
            $path = 'users/img/';
            $storedPath = $image->storeAs($path, $imageName, 'public');
            $user->save();
        }

        if ($user) return redirect()->route("users")->with("success", "user created correctly");
        else return redirect()->back()->with("error","user not created correctly");
    }

    public function show($id)
    {
        $user = User::where('id',Crypt::decrypt($id))->where('status', 1)->first();
        if ($user->id == 1) return redirect()->route('users')->with('error', "Don't show admin");
        if (!$user) return redirect()->back()->with('error', 'User not exists');
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::where('id',Crypt::decrypt($id))->where('status',1)->first();
        if ($user->id == 1) return redirect()->route('users')->with('error', "Don't show admin");
        if (!$user) return redirect()->back()->with('error', 'User not exists');
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::where('id',$id)->where('status',1)->first();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|email|unique:users,email,'. $user->id,
            'role' => 'required|integer',
            'language' => 'required|integer',
        ]);

        $user->update([
            "name"=>$data['name'],
            "email"=>$data["email"],
            "role"=>$data["role"],
            "language"=>$data["language"],
            'updated_by' => Auth::user()->id,
            "active"=>"S",
            "status"=>1
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete('users/img/' . $user->id . '.png');
            $image = $request->file('image');
            $imageName = $user->id . '.png';
            $image->storeAs('users', $imageName, 'public');
        }

        if ($request->has('delete_image')) {
            Storage::disk('public')->delete('users/img/' . $user->id . '.png');
        }
        return redirect()->route('users')->with('success', 'user updated correctly');
    }

    public function destroy($id)
    {
        $user = User::where('id',$id)->where('status',1)->first();
        $user->update(["active" => "N", "status" => 0, "deleted_at" => now(), "deleted_by" => Auth::user()->id]);
        return redirect()->route("users")->with("success", "User deleted correctly");
    }

    public function cancel($id)
    {
        $user = User::where('id',$id)->where('status',1)->first();
        $user->update(["active" => "N", "cancel_at" => now(), "cancel_by"=>Auth::user()->id]);
        return redirect()->route("users")->with("success", "user canceled correctly");
    }

    public function changePassword($id)
    {
        $user = User::where('id',$id)->where('status',1)->first();
        $user->updated(['password'=>Hash::make('Sisa.' . Date('Y')), 'updated_by' => Auth::user()->id]);
        return redirect()->route("users")->with("success", "password changed correctly");
    }

    public function pdf($id = null, $download = true)
    {
        if ($id) {
            $user = User::where('id', Crypt::decrypt($id))->where('status', 1)->first();
            if ($user->id == 1) return redirect()->route('users')->with('ERROR', 'Don´t show admin');
            if (Auth::user()->role != 1) return redirect()->route('home')->with('ERROR', 'user not autorized');
            $pdf = Pdf::loadView('users.id', compact('user'));
            $filename = 'reporte_de_' . $user->id . '_' . $user->name . '_' . now()->format('dmY_His') . '.pdf';
        } else {
            $users = User::where('status', 1)::where('id'!=1)->get();
            if (Auth::user()->role != 1) return redirect()->route('home')->with('ERROR', 'user not autorized');
            $pdf = Pdf::loadView('users.all', compact('users'));
            $filename = 'reporte_de_usuarios_' . now()->format('dmY_His') . '.pdf';
        }
        if ($download == true) return $pdf->stream($filename);
        else return $pdf->output();
    }

    public function docx($id = null, $download = True)
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
        $section->addText('REPORTE DE USUARIOS', [
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
        $user = User::where('id', $id)->where('status', 1)->first();
                if (!$user) {
                    return back()->with('error', 'Puesto no encontrada');
                }

                $section->addText("ID: {$user->id}");
                $section->addText("Nombre: {$user->name}");
                $section->addText("Email: {$user->email}");
                $section->addText("Rol: " . ($user->role === 1 ? 'Administrador' : 'Operador'));
                $section->addText("Idioma: " . ($user->languaje === 1 ? 'Español' : 'Inglés'));
                $section->addText("Activo: " . ($user->active === 'S' ? 'Sí' : 'No'));
                $section->addText("Creado: " . ($user->created_at ? $user->created_at->format('d/m/Y H:i') : ''));
                $section->addText("Actualizado: " . ($user->updated_at ? $user->updated_at->format('d/m/Y H:i') : ''));
                $section->addTextBreak(1);
            }
            else {
                // Tabla para todos
                $users = User::where('status', 1)->get();

                $table = $section->addTable([
                    'borderSize' => 6,
                    'borderColor' => '999999',
                    'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
                    'cellMargin' => 80
                ]);

                // Encabezado
                $table->addRow();
                $headers = ['ID', 'Nombre', 'Email', 'Rol', 'Idioma', 'Activo'];

                foreach ($headers as $header) {
                    $table->addCell(1200, ['bgColor' => 'cccccc'])->addText($header, ['bold' => true]);
                }

                foreach ($users as $user) {
                    $table->addRow();
                    $table->addCell(1200)->addText($user->id);
                    $table->addCell(1200)->addText($user->name);
                    $table->addCell(1200)->addText($user->email);
                    $table->addCell(1200)->addText($user->role === 1 ? 'Administrador' : 'Operador');
                    $table->addCell(1200)->addText($user->languaje === 1 ? 'Español' : 'Inglés');
                    $table->addCell(1200)->addText($user->active === 'S' ? 'Sí' : 'No');
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
            return response()->download($temp_file, 'reporte_usuarios_'. date('dmY_his') .'.docx')->deleteFileAfterSend(true);
        } else {
            // Devolver el contenido para email u otro uso
            $content = file_get_contents($temp_file);
            unlink($temp_file);
            return $content;
        }
    }

    public function xlsx($id = null, $download = True)
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
            // Nombre del reporte "REPORTE DE USUARIOS" en D1:L1 BOLD, Arial 14, Merge & center
            $sheet->mergeCells('D1:L1');
            $sheet->setCellValue('D1', 'REPORTE DE USUARIOS');
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
            // Titulo del reporte "REPORTE DE USUARIOS" en A4:L4 BOLD, Arial 16, Merge & center
            $sheet->mergeCells('A4:L4');
            $sheet->setCellValue('A4', 'REPORTE DE USUARIOS');
            $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(16)->setName('Arial');
            $sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            // columnas de la tabla, en A5:L5 BOLD, Middle Align, Arial 12
            $headers = ['ID', 'Nombre', 'Email', 'Rol', 'Idioma', 'Activo'];
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . '5', $header);
                $sheet->getStyle($col . '5')->getFont()->setBold(true)->setSize(12)->setName('Arial');
                $sheet->getStyle($col . '5')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $col++;
            }
            // COLUMNAS CON LOS DATOS en A6:L6 si puedes centrar y ajustar los datos lo agradeceria.
            $fila = 6;
            $users = $id ? [User::where('id', $id)->where('status', 1)->first()] : User::where('status', 1)->get();
            foreach ($users as $user) {
                if (!$user) continue;

                $datos = [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role === 1 ? 'Administrador' : 'Operador',
                    $user->languaje === 1 ? 'Español' : 'Inglés',
                    $user->active === 'S' ? 'Sí' : 'No',
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
                return response()->download($temp_file, 'reporte_usuarios_'.date('dmY_hi') .'.xlsx')->deleteFileAfterSend(true);
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
        $mailable = new UserEmail($message);
        $mailable->attachData($pdfContent, 'reporte_usuarios_'. date('dmY_Hi') .'.pdf', [
            'mime' => 'application/pdf'
        ]);
        $mailable->attachData($docxContent, 'reporte_usuarios_'. date('dmY_Hi') .'.docx', [
            'mime' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ]);
        $mailable->attachData($xlsxContent, 'reporte_usuarios_'. date('dmY_Hi') .'.xlsx', [
            'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]);
        Mail::to($to)->send($mailable);
        return back()->with('success', 'Correo enviado con éxito a ' . $to);
    }
}
