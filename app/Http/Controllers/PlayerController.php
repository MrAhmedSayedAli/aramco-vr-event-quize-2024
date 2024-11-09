<?php

namespace App\Http\Controllers;


use App\Http\Requests\Player\LoginRequest;
use App\Http\Requests\Player\RegisterRequest;
use App\Models\Player;
use App\Models\PlayerQueue;
use App\Models\Quiz;
use App\Services\QuizService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yajra\DataTables\Facades\DataTables;


class PlayerController extends Controller
{

    //====================================================>
    public function login(Request $request)
    {
        $this->seo()->setTitle('CheckIN And Start');
        return view('quiz.login');
    }

    //====================================================>
    public function doLogin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric|digits:4'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $code = $request->input('user_id');

        try {
            $player = Player::where('uuid', $code)->firstOrFail();
            $queue = PlayerQueue::where('player_id', $player->id)->where('status', false)->whereDate('created_at', Carbon::today())->first();
            if ($queue == null) {
                $newQueue = new PlayerQueue;
                $newQueue->player_id = $player->id;
                $newQueue->save();
                return view('quiz.done-check', ['msg' => 'Done']);
            }
            return view('quiz.done-check', ['msg' => 'You are already checked in.']);
        } catch (ModelNotFoundException  $e) {
            return back()->withErrors(['user_id' => 'The entered code is invalid. Please contact the registration']);
        }
    }

    //====================================================>
    public function playerForgetID(Request $request)
    {
        $this->seo()->setTitle('Forge ID');
        return view('quiz.forget');
    }

    //====================================================>
    public function playerDoForgetID(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|digits:10',
            'email' => 'required|email|not_regex:/@aramco\.com$/i',
        ], [
            'email.not_regex' => 'Aramco E-mail not allowed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $email = $request->input('email');
        $phone = $request->input('phone');

        try {
            $player = Player::where('email', $email)->where('phone', $phone)->firstOrFail();
            return view('quiz.done', ['code' => $player->uuid]);
        } catch (ModelNotFoundException  $e) {
            return back()->withErrors(['email' => 'The entered email or phone is invalid.']);
        }


    }

    //====================================================>
    public function playerRegister()
    {
        $this->seo()->setTitle('Player Register');
        return view('quiz.register');
    }

    //====================================================>
    public function playerDoRegister(RegisterRequest $request)
    {
        $request->validated();
        $input = $request->input();
        $model = new Player;

        $model->name = $input['name'];
        $model->phone = $input['phone'];
        $model->email = $input['email'];
        $model->uuid = $this->generateUniqueCode();

        if ($model->save()) {
            return view('quiz.done', ['code' => $model->uuid]);
        } else {
            return back()->withErrors(['name' => 'Error Try Another Time']);
        }
    }
    //====================================================>
    //====================================================>
    public function register(Request $request)
    {
        $this->seo()->setTitle('Register');
        return view('dashboard.player_form');
    }

    //====================================================>
    public function doRegister(RegisterRequest $request)
    {
        $request->validated();
        $input = $request->input();
        $model = new Player;

        $model->name = $input['name'];
        $model->phone = $input['phone'];
        $model->uuid = $this->generateUniqueCode();

        if ($model->save()) {
            return view('dashboard.player_code', ['code' => $model->uuid]);
        } else {
            return back()->withErrors(['name' => 'Error Try Another Time']);
        }
    }

    //====================================================>
    private function generateUniqueCode()
    {
        do {
            $code = random_int(1004, 9999);
        } while (Player::where("uuid", $code)->exists());
        return $code;
    }

    //====================================================>
    public function export()
    {
        try {

            $data = Quiz::with(['Player', 'QuizAnswer'])->orderBy('score', 'desc')->get();


            $spreadsheet = new Spreadsheet();
            $spreadsheet->getProperties()->setCreator('Ahmed Elsayed Ali  +201015884959 ')
                ->setLastModifiedBy('Ahmed Elsayed Ali  +201015884959 ')
                ->setTitle('Ahmed Elsayed Ali  +201015884959 ')
                ->setSubject('Ahmed Elsayed Ali  +201015884959 ')
                ->setDescription('Ahmed Elsayed Ali  +201015884959 ')
                ->setKeywords('Ahmed Elsayed Ali  +201015884959 ')
                ->setCategory('Ahmed Elsayed Ali  +201015884959 ');


            $xlsIndex1 = $spreadsheet->setActiveSheetIndex(0);

            $xlsIndex1->setTitle('Players');

            $headerStyle = [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => '808080',
                    ],
                ],
            ];


            $rowStyle = [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ];

            $rowErrorStyle = [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => [
                        'argb' => 'ffff000a',
                    ],
                ],
            ];

            $xlsIndex1->setCellValue('A1', 'Player')
                ->setCellValue('B1', 'Phone')
                ->setCellValue('C1', 'Quiz Date')
                ->setCellValue('D1', 'Score')
                ->setCellValue('E1', 'Duration')
                ->setCellValue('F1', 'Answers 1')
                ->setCellValue('G1', 'Answers 2')
                ->setCellValue('H1', 'Answers 3')
                ->setCellValue('I1', 'Answers 4')
                ->setCellValue('J1', 'Answers 5')
                ->setCellValue('K1', 'Answers 6')
                ->setCellValue('L1', 'Answers 7')
                ->setCellValue('M1', 'Answers 8')
                ->setCellValue('M1', 'Answers 9')
                ->setCellValue('O1', 'Status');

            $xlsIndex1->getStyle('A1')->applyFromArray($headerStyle);
            $xlsIndex1->getStyle('B1')->applyFromArray($headerStyle);
            $xlsIndex1->getStyle('C1')->applyFromArray($headerStyle);
            $xlsIndex1->getStyle('D1')->applyFromArray($headerStyle);
            $xlsIndex1->getStyle('E1')->applyFromArray($headerStyle);

            $xlsIndex1->getStyle('F1')->applyFromArray($headerStyle);
            $xlsIndex1->getStyle('G1')->applyFromArray($headerStyle);
            $xlsIndex1->getStyle('H1')->applyFromArray($headerStyle);
            $xlsIndex1->getStyle('I1')->applyFromArray($headerStyle);
            $xlsIndex1->getStyle('J1')->applyFromArray($headerStyle);
            $xlsIndex1->getStyle('K1')->applyFromArray($headerStyle);
            $xlsIndex1->getStyle('L1')->applyFromArray($headerStyle);
            $xlsIndex1->getStyle('M1')->applyFromArray($headerStyle);
            $xlsIndex1->getStyle('N1')->applyFromArray($headerStyle);

            $xlsIndex1->getStyle('O1')->applyFromArray($headerStyle);

            $index = 2;
            foreach ($data as $row) {
                $xlsIndex1->setCellValue('A' . $index, $row->Player->name ?? 'NULL');
                $xlsIndex1->setCellValue('B' . $index, $row->Player->phone ?? 'NULL');
                $xlsIndex1->setCellValue('C' . $index, $row->created_at->format('Y-m-d-H:i:s') ?? 'NULL');
                $xlsIndex1->setCellValue('D' . $index, $row->score ?? 'NULL');
                $xlsIndex1->setCellValue('E' . $index, $row->duration ?? 'NULL');

                foreach ($row->QuizAnswer as $ans) {

                    $boolC = false;
                    $cAns = 'INCORRECT';
                    $LET = '';
                    if ($ans->is_correct) {
                        $cAns = 'CORRECT';
                        $boolC = true;

                    }
                    switch ($ans->inc) {
                        case 1:
                            $LET = 'F';
                            break;
                        case 2:
                            $LET = 'G';
                            break;

                        case 3:
                            $LET = 'H';
                            break;

                        case 4:
                            $LET = 'I';
                            break;

                        case 5:
                            $LET = 'J';
                            break;
                        case 6:
                            $LET = 'K';
                            break;
                        case 7:
                            $LET = 'L';
                            break;
                        case 8:
                            $LET = 'M';
                            break;
                        case 9:
                            $LET = 'N';
                            break;
                        default:
                    }

                    $xlsIndex1->setCellValue($LET . $index, $cAns);
                    if ($boolC)
                        $xlsIndex1->getStyle($LET . $index)->applyFromArray($rowStyle);
                    else
                        $xlsIndex1->getStyle($LET . $index)->applyFromArray($rowErrorStyle);
                }

                $xlsIndex1->setCellValue('O' . $index, $row->status ? 'completed' : 'incomplete');

                $xlsIndex1->getStyle('A' . $index)->applyFromArray($rowStyle);
                $xlsIndex1->getStyle('B' . $index)->applyFromArray($rowStyle);
                $xlsIndex1->getStyle('C' . $index)->applyFromArray($rowStyle);
                $xlsIndex1->getStyle('D' . $index)->applyFromArray($rowStyle);
                $xlsIndex1->getStyle('E' . $index)->applyFromArray($rowStyle);


                if ($row->status) {
                    $xlsIndex1->getStyle('O' . $index)->applyFromArray($rowStyle);
                } else {
                    $xlsIndex1->getStyle('O' . $index)->applyFromArray($rowErrorStyle);
                }


                $index++;
            }

            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode('#');
            $sheet = $spreadsheet->getActiveSheet();
            foreach ($sheet->getColumnIterator() as $column) {
                $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
            }

            $filename = 'Players_' . date("Y/m/d") . '.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');


        } catch (Exception $e) {
            abort(500);
        }
    }

    //====================================================>
    public function playerCheckInBoard()
    {
        $this->seo()->setTitle('Check In Board');
        return view('home.check-in', ['quiz' => null]);
    }

    //====================================================>
    public function playerCheckInBoardAjax(Request $request)
    {
        if ($request->ajax()) {
            $data = PlayerQueue::whereDate('created_at', Carbon::today())
                ->where('created_at', '>=', Carbon::now()->subMinutes(40))
                ->with([
                    'Player' => function ($q) {
                        $q->select('id', 'name', 'uuid');
                    }
                ])->orderBy('created_at', 'asc')->whereIn('status', [0])->get();//->unique('player_id');

            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['state'])
                ->editColumn('name', function ($row) {
                    return $row->Player->name ?? 'NULL';
                })
                ->editColumn('code', function ($row) {
                    return $row->Player->uuid ?? 'NULL';
                })
                ->editColumn('timer', function ($row) {
                    $minutesDifference = Carbon::parse($row->created_at)->diffInMinutes(Carbon::now());
                    $minutes = $minutesDifference % 60;
                    return $minutes;
                })
                ->editColumn('state', function ($row) {

                    $status = '';

                    switch ($row->status) {
                        case 0:
                            $status = 'Waiting';
                            break;
                        case 1:
                            $status = 'Playing';
                            break;
                    }
                    return '<span class="inline-flex items-center bg-green-100 text-green-800 text-md font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">' . $status . '</span>';

                })
                ->make(true);
        }
        return '';
    }

    //====================================================>
    public function playerLeaderboard()
    {
        $this->seo()->setTitle('Leader Board');
        return view('home.leader', ['quiz' => null]);
    }

    //====================================================>
    public function playerLeaderboardAjax(Request $request)
    {
        if ($request->ajax()) {
            $data = Quiz::select(['id', 'player_id', 'score', 'duration'])->with([
                'Player' => function ($q) {
                    $q->select('id', 'name');
                }
            ])->orderBy('score', 'desc')
                ->where('status', true)
                ->get()
                ->unique('player_id');

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    return $row->Player->name ?? 'NULL';
                })
                ->make(true);
        }
        return '';
    }
    //====================================================>


}
