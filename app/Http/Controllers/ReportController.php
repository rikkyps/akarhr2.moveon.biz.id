<?php

namespace App\Http\Controllers;

use App\AccountList;
use App\AttendanceEmployee;
use App\Deposit;
use App\Employee;
use App\Expense;
use App\Leave;
use App\LeaveType;
use App\PaySlip;
use App\TimeSheet;
use App\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function incomeVsExpense(Request $request)
    {
        if(\Auth::user()->can('Manage Report'))
        {
            $deposit = Deposit::where('created_by', \Auth::user()->creatorId());

            $labels       = $data = [];
            $expenseCount = $incomeCount = 0;
            if(!empty($request->start_month) && !empty($request->end_month))
            {

                $start = strtotime($request->start_month);
                $end   = strtotime($request->end_month);

                $currentdate = $start;
                $month       = [];
                while($currentdate <= $end)
                {
                    $month = date('m', $currentdate);
                    $year  = date('Y', $currentdate);

                    $depositFilter = Deposit::where('created_by', \Auth::user()->creatorId())->whereMonth('date', $month)->whereYear('date', $year)->get();

                    $depositsTotal = 0;
                    foreach($depositFilter as $deposit)
                    {
                        $depositsTotal += $deposit->amount;
                    }
                    $incomeData[] = $depositsTotal;
                    $incomeCount  += $depositsTotal;

                    $expenseFilter = Expense::where('created_by', \Auth::user()->creatorId())->whereMonth('date', $month)->whereYear('date', $year)->get();
                    $expenseTotal  = 0;
                    foreach($expenseFilter as $expense)
                    {
                        $expenseTotal += $expense->amount;
                    }
                    $expenseData[] = $expenseTotal;
                    $expenseCount  += $expenseTotal;

                    $labels[]    = date('M Y', $currentdate);
                    $currentdate = strtotime('+1 month', $currentdate);

                }

            }
            else
            {
                for($i = 0; $i < 6; $i++)
                {
                    $month = date('m', strtotime("-$i month"));
                    $year  = date('Y', strtotime("-$i month"));

                    $depositFilter = Deposit::where('created_by', \Auth::user()->creatorId())->whereMonth('date', $month)->whereYear('date', $year)->get();

                    $depositTotal = 0;
                    foreach($depositFilter as $deposit)
                    {
                        $depositTotal += $deposit->amount;
                    }

                    $incomeData[] = $depositTotal;
                    $incomeCount  += $depositTotal;

                    $expenseFilter = Expense::where('created_by', \Auth::user()->creatorId())->whereMonth('date', $month)->whereYear('date', $year)->get();
                    $expenseTotal  = 0;
                    foreach($expenseFilter as $expense)
                    {
                        $expenseTotal += $expense->amount;
                    }
                    $expenseData[] = $expenseTotal;
                    $expenseCount  += $expenseTotal;

                    $labels[] = date('M Y', strtotime("-$i month"));
                }

            }

            $incomeArr['label']           = __('Income');
            $incomeArr['borderColor']     = '#6777ef';
            $incomeArr['fill']            = '!0';
            $incomeArr['backgroundColor'] = '#6777ef';
            $incomeArr['data']            = $incomeData;

            $expenseArr['label']           = __('Expense');
            $expenseArr['borderColor']     = '#fc544b';
            $expenseArr['fill']            = '!0';
            $expenseArr['backgroundColor'] = '#fc544b';
            $expenseArr['data']            = $expenseData;

            $data[] = $incomeArr;
            $data[] = $expenseArr;

            return view('report.income_expense', compact('labels', 'data', 'incomeCount', 'expenseCount'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function leave(Request $request)
    {

        if(\Auth::user()->can('Manage Report'))
        {
            $employeesList = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $employeesList->prepend('All', '');

            $employees = User::where('created_by', \Auth::user()->creatorId())->where('type', 'employee');
            if(!empty($request->employee))
            {
                $employees->where('id', $request->employee);
            }
            $employees = $employees->get();

            $leaves = [];
            foreach($employees as $employee)
            {

                $employeeLeave['id']       = $employee->id;
                $employeeLeave['employee'] = $employee->name;

                $approved = Leave::where('employee_id', $employee->id)->where('status', 'Approve');
                $reject   = Leave::where('employee_id', $employee->id)->where('status', 'Reject');
                $pending  = Leave::where('employee_id', $employee->id)->where('status', 'Pending');

                $approved = $approved->count();
                $reject   = $reject->count();
                $pending  = $pending->count();

                $employeeLeave['approved'] = $approved;
                $employeeLeave['reject']   = $reject;
                $employeeLeave['pending']  = $pending;

                $leaves[] = $employeeLeave;
            }

            return view('report.leave', compact('employeesList', 'leaves'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function employeeLeave(Request $request, $employee_id, $status)
    {
        if(\Auth::user()->can('Manage Report'))
        {
            $leaveTypes = LeaveType::where('created_by', \Auth::user()->creatorId())->get();
            $leaves     = [];
            foreach($leaveTypes as $leaveType)
            {
                $leave        = new Leave();
                $leave->title = $leaveType->title;
                $leave->total = Leave::where('employee_id', $employee_id)->where('status', $status)->where('leave_type_id', $leaveType->id)->count();
                $leaves[]     = $leave;
            }
            $leaveData = Leave::where('employee_id', $employee_id)->where('status', $status)->get();

            return view('report.leaveShow', compact('leaves', 'leaveData'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }


    }


    public function accountStatement(Request $request)
    {

        if(\Auth::user()->can('Manage Report'))
        {
            $accountList = AccountList::where('created_by', \Auth::user()->creatorId())->get()->pluck('account_name', 'id');
            $accountList->prepend('All', '');


            if($request->type == 'expense')
            {
                $accountData = Expense::orderBy('id');

                if(!empty($request->start_month) && !empty($request->end_month))
                {

                    $start = strtotime($request->start_month);
                    $end   = strtotime($request->end_month);

                    $currentdate = $start;

                    while($currentdate <= $end)
                    {
                        $data['month'] = date('m', $currentdate);
                        $data['year']  = date('Y', $currentdate);

                        $accountData->Orwhere(
                            function ($query) use ($data){
                                $query->whereMonth('date', $data['month'])->whereYear('date', $data['year']);
                            }
                        );

                        $currentdate = strtotime('+1 month', $currentdate);
                    }
                }

                if(!empty($request->account))
                {
                    $accountData->where('account_id', $request->account);
                }
            }
            else
            {
                $accountData = Deposit::orderBy('id');

                if(!empty($request->start_month) && !empty($request->end_month))
                {

                    $start = strtotime($request->start_month);
                    $end   = strtotime($request->end_month);

                    $currentdate = $start;

                    while($currentdate <= $end)
                    {
                        $data['month'] = date('m', $currentdate);
                        $data['year']  = date('Y', $currentdate);

                        $accountData->Orwhere(
                            function ($query) use ($data){
                                $query->whereMonth('date', $data['month'])->whereYear('date', $data['year']);
                            }
                        );
                        $currentdate = strtotime('+1 month', $currentdate);
                    }
                }

                if(!empty($request->account))
                {
                    $accountData->where('account_id', $request->account);
                }
            }

            $accountData->where('created_by', \Auth::user()->creatorId());
            $accountData = $accountData->get();


            return view('report.account_statement', compact('accountData', 'accountList'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function payroll(Request $request)
    {

        if(\Auth::user()->can('Manage Report'))
        {
            $employeesList = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $employeesList->prepend('All', '');

            $payslips = PaySlip::where('created_by', \Auth::user()->creatorId());

            if(!empty($request->month))
            {
                $payslips->where('salary_month', $request->month);
            }
            if(!empty($request->employee))
            {
                $payslips->where('employee_id', $request->employee);
            }

            $payslips = $payslips->get();

            $totalBasicSalary = 0;
            $totalNetSalary   = 0;
            foreach($payslips as $payslip)
            {
                $totalBasicSalary += $payslip->basic_salary;
                $totalNetSalary   += $payslip->net_payble;
            }

            return view('report.payroll', compact('payslips', 'totalBasicSalary', 'totalNetSalary', 'employeesList'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function dailyAttendance(Request $request)
    {
        if(\Auth::user()->can('Manage Report'))
        {
            $employeesList = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'user_id');
            $employeesList->prepend('All', '');

            $attendances = AttendanceEmployee::where('created_by', \Auth::user()->creatorId());

            if(!empty($request->date))
            {
                $attendances->where('date', $request->date);
            }
            else
            {
                $attendances->where('date', date('Y-m-d'));
            }

            if(!empty($request->employee))
            {
                $attendances->where('employee_id', $request->employee);
            }

            $attendances = $attendances->get();


            return view('report.dailyAttendance', compact('attendances', 'employeesList'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function monthlyAttendance(Request $request)
    {
        if(\Auth::user()->can('Manage Report'))
        {
            $employeesList = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'user_id');
            $employeesList->prepend('All', '');

            $attendances = AttendanceEmployee::where('created_by', \Auth::user()->creatorId());

            if(!empty($request->start_date) && !empty($request->end_date))
            {
                $attendances->where('date', '>=', $request->start_date);
                $attendances->where('date', '<=', $request->end_date);
            }
            else
            {
                $attendances->where('date', '>=', date('Y-m-01'));
                $attendances->where('date', '<=', date('Y-m-t'));

            }

            if(!empty($request->employee))
            {
                $attendances->where('employee_id', $request->employee);
            }

            $attendances = $attendances->get();


            return view('report.monthlyAttendance', compact('attendances', 'employeesList'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function timesheet(Request $request)
    {
        if(\Auth::user()->can('Manage Report'))
        {
            $employeesList = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'user_id');
            $employeesList->prepend('All', '');

            $timesheets = TimeSheet::where('created_by', \Auth::user()->creatorId());

            if(!empty($request->start_date) && !empty($request->end_date))
            {
                $timesheets->where('date', '>=', $request->start_date);
                $timesheets->where('date', '<=', $request->end_date);
            }

            if(!empty($request->employee))
            {
                $timesheets->where('employee_id', $request->employee);
            }

            $timesheets = $timesheets->get();

            return view('report.timesheet', compact('timesheets', 'employeesList'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }
}
