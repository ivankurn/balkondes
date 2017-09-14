<?php

namespace App\Http\Controllers;

use App\Http\Models\Transaction;
use App\Http\Models\TransactionPackage;
use App\Http\Models\Tourist;
use App\Http\Models\TouristJourney;
use App\Http\Models\TouristPackage;
use App\Http\Requests\AddCustomTransactionPost;
use App\Http\Requests\AddGeneralTransactionPost;
use App\Lib\MyHelper;
use Carbon\Carbon;
use DateTime;
use DB;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Milon\Barcode\DNS1D;
use PDF;
use Validator;

class C_Transaction extends Controller
{
    private $BalkondesPackageController;
    private $DriverController;
    private $PackageController;
    private $TouristController;
    private $TouristPackageController;

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');

        $this->BalkondesPackageController = "App\Http\Controllers\C_BalkondesPackage";
        $this->DriverController = "App\Http\Controllers\DriverVehicle\C_DriverApi";
        $this->PackageController = "App\Http\Controllers\C_Package";
        $this->TouristController = "App\Http\Controllers\C_Tourist";
        $this->TouristPackageController = "App\Http\Controllers\C_TouristPackage";
    }

    public function add ()
    {
        return view('Transactions.add');
    }

    public function addGeneralPost (AddGeneralTransactionPost $request)
    {
        $idPackage = $request->input('package_id');
        $tourists = json_decode($request->input('tourists'), true);
        $touristsPackage = [];

        foreach ($tourists as $key => $value)
        {
            $validator = Validator::make($value, [
                'name'          => 'required|string|max:45',
                'email'         => 'email|max:100',
                'mobilephone'   => 'string|max:18'
            ]);

            if ($validator->fails())
            {
                return response()->json(json_encode([
                    'status'    => 'fail',
                    'index'     => $key,
                    'messages'  => $validator->errors()->all()
                ]), 200);
            }

            $tourists[$key]['created_at'] = Carbon::now('Asia/Jakarta');
        }

        if (!app($this->PackageController)->isPackageExist($idPackage))
        {
            return response()->json(json_encode([
                'status'    => 'fail',
                'messages'  => 'Paket Wisata Balkondes tidak tersedia.'
            ]), 200);
        }

        $packageDetail = app($this->PackageController)->getPackageDetail($idPackage);
        $touristCount = count($tourists);

        DB::beginTransaction();

        // Insert Transaction
        $queryInsertTransaction = Transaction::create([
            'tourist_count' => $touristCount,
            'grand_total'   => $touristCount * $packageDetail['price'],
            'status'        => 'Paid'
        ]);

        if (!$queryInsertTransaction)
        {
            DB::rollback();

            return response()->json(json_encode([
                'status'    => 'fail',
                'messages'  => 'Proses menyimpan data transaksi gagal.'
            ]), 200);
        }
        // End - Insert Transaction

        // Insert Transaction Package
        $queryInsertTransactionPackage = TransactionPackage::create([
            'id_transaction'    => $queryInsertTransaction->id_transaction,
            'id_package'        => $idPackage,
            'qty'               => $touristCount,
            'price'             => $packageDetail['price'],
            'created_at'        => Carbon::now('Asia/Jakarta')
        ]);

        if (!$queryInsertTransactionPackage)
        {
            DB::rollback();

            return response()->json(json_encode([
                'status'    => 'fail',
                'messages'  => 'Proses menyimpan data transaksi gagal.'
            ]), 200);
        }
        // End - Insert Transaction Package

        $tickets = [];

        // Insert Tourist
        foreach ($tourists as $key => $value)
        {
            $ticket = [];
            $queryInsertTourist = Tourist::create($value);

            if (!$queryInsertTourist)
            {
                DB::rollback();

                return response()->json(json_encode([
                    'status'    => 'fail',
                    'messages'  => 'Proses menyimpan data tourist gagal.'
                ]), 200);
            }

            $ticket['barcode'] = parent::createRandomCode(app($this->TouristPackageController)->getAllBarcode());

            array_push($tickets, $ticket);

            // Insert Tourist Package
            $queryInsertTouristPackage = TouristPackage::create([
                'id_tourist'                => $queryInsertTourist->id_tourist,
                'id_transaction_packages'   => $queryInsertTransactionPackage->id_transaction_packages,
                'barcode'                   => $ticket['barcode'],
                'created_at'                => Carbon::now('Asia/Jakarta')
            ]);

            if (!$queryInsertTouristPackage)
            {
                DB::rollback();

                return response()->json(json_encode([
                    'status'    => 'fail',
                    'messages'  => 'Proses menyimpan data tourist package gagal.'
                ]), 200);
            }
            // End - Insert Tourist Package
        }
        // End - Insert Tourist

        DB::commit();

        // Create Barcode and QRcode
        foreach ($tickets as $ticket)
        {
            if (!File::exists(resource_path('assets/borobudur/tickets/barcode/' . $ticket['barcode'] . '.png')))
            {
                $barcodeImage = new DNS1D();
                $barcodeImage->setStorPath(env('APP_TICKET_DIRECTORY_PATH') . '/barcode/');
                $barcodeImage->getBarcodePNGPath($ticket['barcode'], "C128");
            }

            if (!File::exists(resource_path('assets/borobudur/tickets/qrcode/' . $ticket['barcode'] . '.png')))
            {
                $qrcodeImage = new QrCode($ticket['barcode']);
                $qrcodeImage->setSize(300);
                $qrcodeImage->writeFile(env('APP_TICKET_DIRECTORY_PATH') . '/qrcode/' . $ticket['barcode'] . '.png');
            }
        }
        // End - Create Barcode and QRcode

        return response()->json(json_encode([
            'status'    => 'success',
            'messages'  => [
                'Proses penambahan transaksi berhasil.'
            ],
            'data'      => [
                'date'              => date_format($queryInsertTransaction->created_at, 'jS \o\f F, Y'),
                'time'              => date_format($queryInsertTransaction->created_at, 'g:i:s a'),
                'transaction_id'    => $queryInsertTransaction->id_transaction,
                'package_name'      => $packageDetail['name'],
                'tourist_count'     => $touristCount,
                'price'             => $packageDetail['price'],
                'grand_total'       => $touristCount * $packageDetail['price'],
                'tickets'           => $tickets,
                'tourists'          => $tourists,
                'routes'            => app($this->BalkondesPackageController)->getDetailBalkondesPackage($idPackage)
            ]
        ]), 200);
    }

    public function addCustomPost (AddCustomTransactionPost $request)
    {

    }

    public function getList (Request $request)
    {
        $skip = !empty($request->get('skip')) ? $request->get('skip') : 0;
        $take = !empty($request->get('take')) ? $request->get('take') : 10;

        return view('contents.Transactions.list', [
            'sidebar'  => [
                'menu_active'   => 'transactions',
                'sub_active'    => 'transaction list'
            ],
            'data'  => [
                'transactions_list' => $this->getTransactions($skip, $take),
                'transaction_count' => $this->getTransactionCount()
            ],
            'title' => 'Daftar Transaksi'
        ]);
    }

    public function getTransactions ($skip, $take)
    {
        $queryTransaction = Transaction::join('TransactionPackages', 'TransactionPackages.id_transaction', 'Transactions.id_transaction')
            ->join('Packages', 'Packages.id_package', 'TransactionPackages.id_package')
            ->select(
                'Packages.name',
                'Transactions.id_transaction',
                'Transactions.tourist_count',
                'Transactions.grand_total',
                'Transactions.status',
                'Transactions.created_at'
            )
            ->skip($skip)
            ->take($take)
            ->orderBy('Transactions.created_at', 'desc')
            ->get()
            ->toarray();

        return $queryTransaction;
    }

    public function getTransactionCount ()
    {
        $count = Transaction::count();

        return $count;
    }

    public function printInvoice (Request $request)
    {
        $idTransaction = $request->get('no');

        if (empty($idTransaction))
        {
            return view('contents.Transactions.invoice', [
                'sidebar'  => [
                    'menu_active'   => 'transactions',
                    'sub_active'    => 'transaction list'
                ],
                'data' => [
                    'error'  => [
                        'Data Transaksi tidak ditemukan.'
                    ]
                ],
                'title' => 'Cetak Invoice'
            ]);
        }

        $queryTransaction = Transaction::join('TransactionPackages', 'TransactionPackages.id_transaction', 'Transactions.id_transaction')
            ->join('Packages', 'Packages.id_package', 'TransactionPackages.id_package')
            ->select(
                'Packages.name',
                'Packages.price',
                'Transactions.id_transaction',
                'Transactions.tourist_count',
                'Transactions.grand_total',
                'Transactions.created_at'
            )
            ->where('Transactions.id_transaction', $idTransaction)
            ->get()
            ->toarray();

        if (empty($queryTransaction))
        {
            return view('contents.Transactions.invoice', [
                'sidebar'  => [
                    'menu_active'   => 'transactions',
                    'sub_active'    => 'transaction list'
                ],
                'data' => [
                    'error'  => [
                        'Data Transaksi tidak ditemukan.'
                    ]
                ],
                'title' => 'Cetak Invoice'
            ]);
        }

        return view('contents.Transactions.invoice', [
            'sidebar'  => [
                'menu_active'   => 'transactions',
                'sub_active'    => 'transaction list'
            ],
            'data'  => [
                'invoice' => $queryTransaction[0]
            ],
            'title' => 'Cetak Invoice'
        ]);
    }

    public function printTicket (Request $request)
    {
        $idTransaction = $request->get('no');

        if (empty($idTransaction))
        {
            return view('contents.Transactions.invoice', [
                'sidebar'  => [
                    'menu_active'   => 'transactions',
                    'sub_active'    => 'transaction list'
                ],
                'data' => [
                    'error'  => [
                        'Data Transaksi tidak ditemukan.'
                    ]
                ],
                'title' => 'Cetak Tiket'
            ]);
        }

        $queryTicket = Transaction::join('TransactionPackages', 'TransactionPackages.id_transaction', 'Transactions.id_transaction')
            ->join('Packages', 'Packages.id_package', 'TransactionPackages.id_package')
            ->join('TouristPackages', 'TouristPackages.id_transaction_packages', 'TransactionPackages.id_transaction_packages')
            ->join('Tourists', 'Tourists.id_tourist', 'TouristPackages.id_tourist')
            ->select(
                'Packages.name',
                'Packages.price',
                'Transactions.id_transaction',
                'Transactions.tourist_count',
                'Transactions.grand_total',
                'Transactions.created_at',
                'TouristPackages.barcode',
                'Tourists.name as tourist_name',
                'Tourists.email as tourist_email',
                'Tourists.mobilephone as tourist_mobilephone'
            )
            ->where('Transactions.id_transaction', $idTransaction)
            ->get()
            ->toarray();

        if (empty($queryTicket))
        {
            return view('contents.Transactions.invoice', [
                'sidebar'  => [
                    'menu_active'   => 'transactions',
                    'sub_active'    => 'transaction list'
                ],
                'data' => [
                    'error'  => [
                        'Data Transaksi tidak ditemukan.'
                    ]
                ],
                'title' => 'Cetak Tiket'
            ]);
        }

        return view('contents.Transactions.ticket', [
            'sidebar'  => [
                'menu_active'   => 'transactions',
                'sub_active'    => 'transaction list'
            ],
            'data'  => [
                'tickets'   => $queryTicket
            ],
            'title' => 'Cetak Tiket'
        ]);
    }
}
