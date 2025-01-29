<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AndonCategory;
use App\Models\Employees;
use App\Models\User;
use App\Models\AndonNo;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Andon;
use App\Exports\AndonHistoryExport;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AndonReceivedController extends Controller
{
    public function index(Request $request)
    {

        $user = auth()->user(); // Get the authenticated user

        $cariGuard = AndonCategory::where('id', $user->andoncat_id)->first();

        // dd($cariGuard);
        $dateRange = $request->input('daterange');

        // $andonData = Andon::leftJoin('tblAndonNo', 'tblandon.Andon_No', '=', 'tblAndonNo.Andon_No')
        //     ->whereNull('tblandon.AndonDateClosed')
        //     ->where('tblandon.Andon_No', $cariGuard->AndonSerie)
        //     ->select('tblandon.*', 'tblAndonNo.Andon_Color')
        //     ->get();
        $andonData = Andon::leftJoin('tblAndonNo', 'tblandon.Andon_No', '=', 'tblAndonNo.Andon_No')
            ->whereNull('tblandon.AndonDateClosed')
            ->whereRaw('SUBSTRING(tblandon.Andon_No, -1) = ?', [$cariGuard->CodeAndon])
            ->select('tblandon.*', 'tblAndonNo.Andon_Color')
            ->get();

        $Andon_Serie = session('Andon_Serie');
        $Workcenter = session('Workcenter');
        $RiseUp_OprNo = session('RiseUp_OprNo');
        $AndonDateOpen = session('AndonDateOpen');
        $AndonDateReceived = session('AndonDateReceived');
        $AndonDateAccepted = session('AndonDateAccepted');
        $AndonDateSolving = session('AndonDateSolving');
        $AndonDateClosed = session('AndonDateClosed');
        $RiseUp_EmployeeName = session('RiseUp_EmployeeName');
        $DescriptionProblem = session('DescriptionProblem');
        $AndonOpenReceived = session('AndonOpenReceived');
        $AndonReceivedSolving = session('AndonReceivedSolving');
        $AndonSolvingAccepted = session('AndonSolvingAccepted');
        $AndonAcceptedClosed = session('AndonAcceptedClosed');
        $andonAccumulatedTime = session('andonAccumulatedTime');

        if ($user->andoncat_id) {
            // If the user has an `andoncat_id`, retrieve data based on it
            $andonCategory = AndonCategory::where('id', $user->andoncat_id)->first();
            $andon = Andon::where('id', $user->andoncat_id)->first();
            $employee = Employees::where('id', $andonCategory->Guard_EmployeeID)->first();
            $playAudio = $andonCategory->Sirene == 1;

            if ($andonCategory->Sirene == 1) {
                Alert::info('Andon Baru', 'Pesan Andon Baru')
                    ->showConfirmButton('Ok');
            }
        } else {
            // If not, you may use `Guard_EmployeeID` if it's available
            $contactPerson = $user->Guard_EmployeeID;
        }

        return view('andonreceived.index', compact('andonCategory', 'employee', 'andonData', 'playAudio'));
    }

    public function historyAndon()
    {
        // session()->forget('Andon_Serie');
        // session()->forget('Workcenter');
        // session()->forget('RiseUp_OprNo');
        // session()->forget('AndonDateOpen');
        // session()->forget('AndonDateReceived');
        // session()->forget('AndonDateSolving');
        // session()->forget('AndonDateAccepted');
        // session()->forget('AndonDateClosed');
        // session()->forget('RiseUp_EmployeeName');
        // session()->forget('DescriptionProblem');
        // session()->forget('AndonOpenReceived');
        // session()->forget('AndonReceivedSolving');
        // session()->forget('AndonSolvingAccepted');
        // session()->forget('AndonAcceptedClosed');
        // session()->forget('andonAccumulatedTime');
        $user = auth()->user(); // Get the authenticated user

        $cariGuard = AndonCategory::where('id', $user->andoncat_id)->first();

        $andonData = Andon::leftJoin('tblAndonNo', 'tblandon.Andon_No', '=', 'tblAndonNo.Andon_No')
            ->whereNotNull('tblandon.Andon_Serie')
            ->whereRaw('SUBSTRING(tblandon.Andon_No, -1) = ?', [$cariGuard->CodeAndon])
            ->select('tblandon.*', 'tblAndonNo.Andon_Color')
            ->get();

        $Andon_Serie = session('Andon_Serie');
        $Workcenter = session('Workcenter');
        $RiseUp_OprNo = session('RiseUp_OprNo');
        $AndonDateOpen = session('AndonDateOpen');
        $AndonDateReceived = session('AndonDateReceived');
        $AndonDateAccepted = session('AndonDateAccepted');
        $AndonDateSolving = session('AndonDateSolving');
        $AndonDateClosed = session('AndonDateClosed');
        $RiseUp_EmployeeName = session('RiseUp_EmployeeName');
        $DescriptionProblem = session('DescriptionProblem');
        $AndonOpenReceived = session('AndonOpenReceived');
        $AndonReceivedSolving = session('AndonReceivedSolving');
        $AndonSolvingAccepted = session('AndonSolvingAccepted');
        $AndonAcceptedClosed = session('AndonAcceptedClosed');
        $andonAccumulatedTime = session('andonAccumulatedTime');

        if ($user->andoncat_id) {
            // If the user has an `andoncat_id`, retrieve data based on it
            $andonCategory = AndonCategory::where('id', $user->andoncat_id)->first();
            $andon = Andon::where('id', $user->andoncat_id)->first();
            $employee = Employees::where('id', $andonCategory->Guard_EmployeeID)->first();
        } else {
            // If not, you may use `Guard_EmployeeID` if it's available
            $contactPerson = $user->Guard_EmployeeID;
        }

        return view('andonreceived.history', compact('andonCategory', 'employee', 'andonData'));
    }

    public function saveToSession($andonSerie)
    {
        $user = auth()->user(); // Get the authenticated user

        // Retrieve data based on the $andonSerie parameter
        $data = Andon::where('Andon_Serie', $andonSerie)->first();

        $record = AndonCategory::where('AndonSerie', $andonSerie)->first();

        if ($data) {
            // Update the 'AndonDateReceived' with the current date and time
            $data->AndonDateReceived = Carbon::now();
            $data->save(); // Save the changes

            // Calculate andon received - andon open
            $andonReceivedTime = Carbon::parse($data->AndonDateReceived);
            $andonOpenTime = Carbon::parse($data->AndonDateOpen);
            $AndonOpenReceived = $andonReceivedTime->diffInMinutes($andonOpenTime);

            // Calculate andon solving - andon received
            $andonSolvingTime = Carbon::parse($data->AndonDateSolving);
            $andonReceivedTime = Carbon::parse($data->AndonDateReceived);
            $AndonReceivedSolving = $andonReceivedTime->diffInMinutes($andonSolvingTime);

            // Calculate andon accepted - andon solving
            $andonAcceptedTime = Carbon::parse($data->AndonDateAccepted);
            $andonSolvingTime = Carbon::parse($data->AndonDateSolving);
            $AndonSolvingAccepted = $andonSolvingTime->diffInMinutes($andonAcceptedTime);

            // Calculate andon closed - andon accepted
            $andonClosedTime = Carbon::parse($data->AndonDateClosed);
            $andonAcceptedTime = Carbon::parse($data->AndonDateAccepted);
            $AndonAcceptedClosed = $andonAcceptedTime->diffInMinutes($andonClosedTime);

            // calculate accumulated delays
            $andonAccumulatedTime = $AndonOpenReceived + $AndonReceivedSolving + $AndonSolvingAccepted + $AndonAcceptedClosed;

            // $employeeNumber = AndonCategory::where('AndonSerie', $andonSerie)->first()->employee->EmployeeNumber;

            // Andon::where('Andon_Serie', $andonSerie)->update([
            //     'Received_EmployeeID' => $employeeNumber,
            // ]);

            if ($user->andoncat_id) {
                AndonCategory::where('id', $user->andoncat_id)
                    ->update(['AndonSerie' => $data->Andon_Serie]);

                AndonCategory::where('AndonSerie', $data->Andon_Serie)
                    ->update(['Sirene' => '0']);
            }

            // Save data to the session
            session(['Andon_Serie' => $data->Andon_Serie]);
            session(['Workcenter' => $data->Workcenter]);
            session(['RiseUp_OprNo' => $data->RiseUp_OprNo]);
            session(['AndonDateOpen' => $data->AndonDateOpen]);
            session(['AndonDateReceived' => $data->AndonDateReceived]);
            session(['AndonDateSolving' => $data->AndonDateSolving]);
            session(['AndonDateAccepted' => $data->AndonDateAccepted]);
            session(['AndonDateClosed' => $data->AndonDateClosed]);
            session(['RiseUp_EmployeeName' => $data->RiseUp_EmployeeName]);
            session(['DescriptionProblem' => $data->DescriptionProblem]);
            session(['AndonOpenReceived' => $AndonOpenReceived]);
            session(['AndonReceivedSolving' => $AndonReceivedSolving]);
            session(['AndonSolvingAccepted' => $AndonSolvingAccepted]);
            session(['AndonAcceptedClosed' => $AndonAcceptedClosed]);
            session(['andonAccumulatedTime' => $andonAccumulatedTime]);

            // Redirect back to the previous page or wherever you need
            return back()->with('added', 'Received Success!');
        } else {
            // Handle the case where 'andon' data does not exist
            return back()->with('error', 'Andon not found!');
        }
    }

    public function saveToSessionHistory($andonSerie)
    {
        $user = auth()->user(); // Get the authenticated user

        // Retrieve data based on the $andonSerie parameter
        $data = Andon::where('Andon_Serie', $andonSerie)->first();

        $record = AndonCategory::where('AndonSerie', $andonSerie)->first();

        if ($data) {

            // Calculate andon received - andon open
            $andonReceivedTime = Carbon::parse($data->AndonDateReceived);
            $andonOpenTime = Carbon::parse($data->AndonDateOpen);
            $AndonOpenReceived = $andonReceivedTime->diffInMinutes($andonOpenTime);

            // Calculate andon solving - andon received
            $andonSolvingTime = Carbon::parse($data->AndonDateSolving);
            $andonReceivedTime = Carbon::parse($data->AndonDateReceived);
            $AndonReceivedSolving = $andonReceivedTime->diffInMinutes($andonSolvingTime);

            // Calculate andon accepted - andon solving
            $andonAcceptedTime = Carbon::parse($data->AndonDateAccepted);
            $andonSolvingTime = Carbon::parse($data->AndonDateSolving);
            $AndonSolvingAccepted = $andonSolvingTime->diffInMinutes($andonAcceptedTime);

            // Calculate andon closed - andon accepted
            $andonClosedTime = Carbon::parse($data->AndonDateClosed);
            $andonAcceptedTime = Carbon::parse($data->AndonDateAccepted);
            $AndonAcceptedClosed = $andonAcceptedTime->diffInMinutes($andonClosedTime);

            // calculate accumulated delays
            $andonAccumulatedTime = $AndonOpenReceived + $AndonReceivedSolving + $AndonSolvingAccepted + $AndonAcceptedClosed;

            // if ($user->andoncat_id) {

            //     AndonCategory::where('AndonSerie', $data->Andon_Serie)
            //         ->update(['Sirene' => '0']);
            // }

            // Save data to the session
            session(['HistoryAndon_Serie' => $data->Andon_Serie]);
            session(['HistoryWorkcenter' => $data->Workcenter]);
            session(['HistoryRiseUp_OprNo' => $data->RiseUp_OprNo]);
            session(['HistoryAndonDateOpen' => $data->AndonDateOpen]);
            session(['HistoryAndonDateReceived' => $data->AndonDateReceived]);
            session(['HistoryAndonDateSolving' => $data->AndonDateSolving]);
            session(['HistoryAndonDateAccepted' => $data->AndonDateAccepted]);
            session(['HistoryAndonDateClosed' => $data->AndonDateClosed]);
            session(['HistoryRiseUp_EmployeeName' => $data->RiseUp_EmployeeName]);
            session(['HistoryDescriptionProblem' => $data->DescriptionProblem]);
            session(['HistoryAndonOpenReceived' => $AndonOpenReceived]);
            session(['HistoryAndonReceivedSolving' => $AndonReceivedSolving]);
            session(['HistoryAndonSolvingAccepted' => $AndonSolvingAccepted]);
            session(['HistoryAndonAcceptedClosed' => $AndonAcceptedClosed]);
            session(['HistoryandonAccumulatedTime' => $andonAccumulatedTime]);


            // Redirect back to the previous page or wherever you need
            return back()->with('added', 'Success Checking!');
        } else {
            // Handle the case where 'andon' data does not exist
            return back()->with('error', 'Andon not found!');
        }
    }

    public function updateAndonReceived(Request $request, $Andon_Serie)
    {
        $Andonserie = $request->input('Andon_Serie');

        $record = AndonCategory::where('AndonSerie', $Andon_Serie)->first();

        $data = Andon::where('Andon_Serie', $Andon_Serie)->first();
        if ($record) {

            // Update andon date solving
            $data->AndonDateSolving = Carbon::now();
            $data->save(); // Save the changes

            // Update the 'AndonSerie' in the AndonCat model
            $record->update([
                'AndonSerie' => $Andon_Serie,
            ]);


            $request->validate([
                'DescriptionSolving' => 'required',
            ]);

            $employeeNumber = AndonCategory::where('AndonSerie', $Andon_Serie)->first()->employee->EmployeeNumber;

            Andon::where('Andon_Serie', $Andon_Serie)->update([
                'DescriptionSolving' => $request->input('DescriptionSolving'),
                'AndonRemark' => $request->input('AndonRemark'),
                'Guard_Name' => $record->ContactPerson,
                'Guard_HPWA' => $record->HP_WA,
                'Guard_ID' => $employeeNumber,
            ]);

            // forget session ketika berhasil di store
            session()->forget('Andon_Serie');

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Success');
        } else {
            // Handle the case where the record is not found
            return redirect()->back()->with('error', 'Andon not found!');
        }
    }

    public function updateAndonReceivedSolved(Request $request, $Andon_Serie)
    {
        $Andonserie = $request->input('Andon_Serie');

        $record = AndonCategory::where('AndonSerie', $Andon_Serie)->first();

        $data = Andon::where('Andon_Serie', $Andon_Serie)->first();
        if ($record) {

            // Update andon date solving
            $data->AndonDateClosed = Carbon::now();
            $data->save(); // Save the changes

            // Update the 'AndonSerie' in the AndonCat model
            $record->update([
                'AndonSerie' => $Andon_Serie,
            ]);

            $employeeNumber = AndonCategory::where('AndonSerie', $Andon_Serie)->first()->employee->EmployeeNumber;

            Andon::where('Andon_Serie', $Andon_Serie)->update([
                'AndonRemark' => $request->input('AndonRemark'),
            ]);

            $record->update([
                'AndonSerie' => NULL,
            ]);


            // forget session ketika berhasil di store
            session()->forget('Andon_Serie');

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Success');
        } else {
            // Handle the case where the record is not found
            return redirect()->back()->with('error', 'Andon not found!');
        }
    }

    public function andonexport(Request $request)
    {
        $dateRange = $request->input('daterange');

        if ($dateRange) {
            [$startDate, $endDate] = explode(' to ', $dateRange);

            $startDateTime = Carbon::parse($startDate)->startOfDay();
            $endDateTime = Carbon::parse($endDate)->endOfDay();

            $query = Andon::whereBetween('AndonDateOpen', [$startDateTime, $endDateTime]);
        } else {
            $query = Andon::query();
        }

        $data = $query->get();

        return Excel::download(new AndonHistoryExport($data), 'AndonHistory.xlsx');
    }

    // public function andonModalClose(){
    //     session()->forget('Andon_Serie');
    //     session()->forget('Workcenter');
    //     session()->forget('RiseUp_OprNo');
    //     session()->forget('AndonDateOpen');
    //     session()->forget('AndonDateReceived');
    //     session()->forget('AndonDateSolving');
    //     session()->forget('AndonDateAccepted');
    //     session()->forget('AndonDateClosed');
    //     session()->forget('RiseUp_EmployeeName');
    //     session()->forget('DescriptionProblem');
    //     session()->forget('AndonOpenReceived');
    //     session()->forget('AndonReceivedSolving');
    //     session()->forget('AndonSolvingAccepted');
    //     session()->forget('AndonAcceptedClosed');
    //     session()->forget('andonAccumulatedTime');
    //     return redirect()->back();

    // }
}
