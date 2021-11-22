
@php
    $logo=asset(Storage::url('uploads/logo/'));
 $company_logo=Utility::getValByName('company_logo');
 $company_small_logo=Utility::getValByName('company_small_logo');
@endphp
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#">
                <img class="img-fluid" src="{{$logo.'/'.(isset($company_logo) && !empty($company_logo)?$company_logo:'logo.png')}}" alt="" width="">
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('home')}}">
                <img class="img-fluid" src="{{$logo.'/'.(isset($company_small_logo) && !empty($company_small_logo)?$company_small_logo:'small_logo.png')}}" alt="">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="dropdown {{ request()->is('home*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}"> <i class="fas fa-tachometer-alt"></i> <span>{{ __('Dashboard') }}</span></a>
            </li>

            @if(\Auth::user()->type=='super admin')
                <li class="dropdown ">
                <li class="{{ request()->is('user*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('user.index') }}"><i class="fas fa-user"></i>{{ __('Company') }}</a></li>
                </li>
            @else
                @if( Gate::check('Manage User') || Gate::check('Manage Role') || Gate::check('Manage Employee Profile')  || Gate::check('Manage Employee Last Login'))
                    <li class="dropdown {{ (Request::route()->getName() == 'user.index' || Request::route()->getName() == 'roles.index' || Request::route()->getName() == 'permissions.index' || Request::route()->getName() == 'employee.profile' || Request::route()->getName() == 'lastlogin') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>{{ __('Staff') }}</span></a>
                        <ul class="dropdown-menu">
                            @can('Manage User')
                                <li class="{{ request()->is('user*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('user.index') }}">{{ __('User') }}</a>
                                </li>
                            @endcan
                            @can('Manage Role')
                                <li class="{{ request()->is('roles*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('roles.index') }}">{{ __('Role') }}</a>
                                </li>
                            @endcan
                            @can('Manage Employee Profile')
                                <li class="{{ request()->is('employee-profile') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('employee.profile') }}">{{ __('Employee Profile') }}</a>
                                </li>
                            @endcan
                            @can('Manage Employee Last Login')
                                <li class="{{ request()->is('lastlogin') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('lastlogin') }}">{{ __('Last Login') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
            @endif
            @if(Gate::check('Manage Employee'))
                @if(\Auth::user()->type =='employee')
                    @php
                        $employee=App\Employee::where('user_id',\Auth::user()->id)->first();
                    @endphp
                    <li class="{{ request()->is('employee*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('employee.show',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))}}"><i class="fas fa-users"></i> <span>{{ __('Employee') }}</span></a>
                    </li>
                @else
                    <li class="{{ (Request::route()->getName() == 'employee.index') ||  (Request::route()->getName() == 'employee.create') ||  (Request::route()->getName() == 'employee.edit') ||  (Request::route()->getName() == 'employee.show') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('employee.index')}}"><i class="fas fa-users"></i> <span>{{ __('Employee') }}</span></a>
                    </li>
                @endif
            @endif

            @if(Gate::check('Manage Set Salary') || Gate::check('Manage Pay Slip'))
                <li class="{{ (Request::route()->getName() == 'setsalary.index' || Request::route()->getName() == 'setsalary.show' ||  Request::route()->getName() == 'payslip.index' || Request::route()->getName() == 'payslip.employeepayslip' || Request::route()->getName() == 'setsalary.edit' || Request::route()->getName() == 'employeesalary' || Request::route()->getName() == 'payslip.employeepayslip' || Request::route()->getName() == 'payslip.pdf') ? 'active' : '' }}">
                    <a class="nav-link has-dropdown" data-toggle="dropdown" href="#"><i class="fas fa-receipt"></i> <span>{{ __('Payroll') }}</span></a>
                    <ul class="dropdown-menu">
                        @can('Manage Set Salary')
                            <li class="{{ request()->is('setsalary*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('setsalary.index') }}">{{ __('Set Salary') }}</a>
                            </li>
                        @endcan
                        @can('Manage Pay Slip')
                            <li class="{{ request()->is('payslip*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('payslip.index') }}">{{ __('Payslip') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

            @if(\Auth::user()->type=='employee')
                <li class="{{ (Request::route()->getName() == 'employeesalary' || Request::route()->getName() == 'payslip.employeepayslip' ||  Request::route()->getName() == 'setsalary.show') ? 'active' : '' }}">
                    <a class="nav-link has-dropdown" data-toggle="dropdown" href="#"><i class="fas fa-receipt"></i> <span>{{ __('Payroll') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ (Request::segment(2) == 'employeeSalary' || Request::segment(1) == 'setsalary') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('employeesalary') }}">{{ __('My Salary') }}</a>
                        </li>
                        <li class="{{ (Request::segment(2) == 'employeepayslip') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('payslip.employeepayslip') }}">{{ __('Payslip') }}</a>
                        </li>
                    </ul>
                </li>
            @endif
            @if( Gate::check('Manage Attendance') || Gate::check('Manage Leave') || Gate::check('Manage TimeSheet'))
                <li class="dropdown {{ (Request::route()->getName() == 'attendanceemployee.index' || Request::route()->getName() == 'leave.index'  || Request::route()->getName() == 'timesheet.index') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>{{ __('Timesheet') }}</span></a>
                    <ul class="dropdown-menu">
                        @can('Manage TimeSheet')
                            <li class="{{ request()->is('timesheet*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('timesheet.index') }}">{{ __('Timesheet') }}</a>
                            </li>
                        @endcan
                        @can('Manage Attendance')
                            <li class="{{ request()->is('attendanceemployee*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('attendanceemployee.index') }}">{{ __('Attendance') }}</a>
                            </li>
                        @endcan
                        @can('Manage Leave')
                            <li class="{{ request()->is('leave*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('leave.index') }}">{{ __('Manage Leave') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif
            @if(Gate::check('Manage Indicator') || Gate::check('Manage Appraisal') || Gate::check('Manage Goal Tracking'))
                <li class="{{ (Request::route()->getName() == 'indicator.index' || Request::route()->getName() == 'appraisal.index' || Request::route()->getName() == 'goaltracking.index') ? 'active' : '' }}">
                    <a class="nav-link has-dropdown" data-toggle="dropdown" href="#"><i class="fa fa-cube"></i> <span>{{ __('Performance') }}</span></a>
                    <ul class="dropdown-menu">
                        @can('Manage Indicator')
                            <li class="{{ request()->is('indicator*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('indicator.index') }}">{{ __('Indicator') }}</a>
                            </li>
                        @endcan
                        @can('Manage Appraisal')
                            <li class="{{ request()->is('appraisal*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('appraisal.index') }}">{{ __('Appraisal') }}</a>
                            </li>
                        @endcan
                        @can('Manage Goal Tracking')
                            <li class="{{ request()->is('goaltracking*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('goaltracking.index') }}">{{ __('Goal Tracking') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

            @if(Gate::check('Manage Account List') || Gate::check('Manage Payee')  || Gate::check('Manage Payer')  || Gate::check('Manage Deposit') || Gate::check('Manage Expense') || Gate::check('Manage Transfer Balance'))
                <li class="{{ (Request::route()->getName() == 'accountlist.index' || Request::route()->getName() == 'accountbalance' || Request::route()->getName() == 'payees.index' || Request::route()->getName() == 'payer.index' || Request::route()->getName() == 'deposit.index' || Request::route()->getName() == 'expense.index' || Request::route()->getName() == 'transferbalance.index' || Request::route()->getName() == 'viewtransaction.index') ? 'active' : '' }}">
                    <a class="nav-link has-dropdown" data-toggle="dropdown" href="#"><i class="fas fa-wallet"></i> <span>{{ __('Finance') }}</span></a>
                    <ul class="dropdown-menu">
                        @can('Manage Account List')
                            <li class="{{ request()->is('accountlist*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('accountlist.index') }}">{{ __('Account List') }}</a>
                            </li>
                        @endcan
                        @can('View Balance Account List')
                            <li class="{{ request()->is('accountbalance*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('accountbalance') }}">{{ __('Account Balance') }}</a>
                            </li>
                        @endcan

                        @can('Manage Payee')
                            <li class="{{ request()->is('payees*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('payees.index') }}">{{ __('Payees') }}</a>
                            </li>
                        @endcan
                        @can('Manage Payer')
                            <li class="{{ request()->is('payer*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('payer.index') }}">{{ __('Payers') }}</a>
                            </li>
                        @endcan
                        @can('Manage Deposit')
                            <li class="{{ request()->is('deposit*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('deposit.index') }}">{{ __('Deposit') }}</a>
                            </li>
                        @endcan
                        @can('Manage Expense')
                            <li class="{{ request()->is('expense*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('expense.index') }}">{{ __('Expense') }}</a>
                            </li>
                        @endcan
                        @can('Manage Transfer Balance')
                            <li class="{{ request()->is('transferbalance*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('transferbalance.index') }}">{{ __('Transfer Balance') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

            @if(Gate::check('Manage Trainer') || Gate::check('Manage Training'))
                <li class="{{ (Request::route()->getName() == 'trainer.index' || Request::route()->getName() == 'training.index' || Request::route()->getName() == 'training.show') ? 'active' : '' }}">
                    <a class="nav-link has-dropdown" data-toggle="dropdown" href="#"><i class="fa fa-graduation-cap"></i> <span>{{ __('Training') }}</span></a>
                    <ul class="dropdown-menu">
                        @can('Manage Training')
                            <li class="{{ request()->is('training*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('training.index') }}">{{ __('Training List') }}</a>
                            </li>
                        @endcan
                        @can('Manage Trainer')
                            <li class="{{ request()->is('trainer*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('trainer.index') }}">{{ __('Trainer') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

            @if(Gate::check('Manage Awards') || Gate::check('Manage Transfer')  || Gate::check('Manage Resignation')  || Gate::check('Manage Travels') || Gate::check('Manage Promotion') || Gate::check('Manage Complaint')|| Gate::check('Manage Warning') || Gate::check('Manage Termination') || Gate::check('Manage Announcement'))
                <li class="dropdown {{ (Request::route()->getName() == 'award.index' ||  Request::route()->getName() == 'transfer.index' || Request::route()->getName() == 'resignation.index' || Request::route()->getName() == 'travel.index' ||  Request::route()->getName() == 'promotion.index' || Request::route()->getName() == 'complaint.index' || Request::route()->getName() == 'warning.index' || Request::route()->getName() == 'termination.index' || Request::route()->getName() == 'announcement.index') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-user-cog"></i> <span>{{ __('HR') }}</span></a>
                    <ul class="dropdown-menu">
                        @can('Manage Award')
                            <li class="{{ request()->is('award*') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('award.index') }}">{{ __('Award') }}</a>
                            </li>
                        @endcan
                        @can('Manage Transfer')
                            <li class="{{ request()->is('transfer*') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('transfer.index') }}">{{ __('Transfer') }}</a>
                            </li>
                        @endcan
                        @can('Manage Resignation')
                            <li class="{{ request()->is('resignation*') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('resignation.index') }}">{{ __('Resignation') }}</a>
                            </li>
                        @endcan
                        @can('Manage Travel')
                            <li class="{{ request()->is('travel*') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('travel.index') }}">{{ __('Trip') }}</a>
                            </li>
                        @endcan
                        @can('Manage Promotion')
                            <li class="{{ request()->is('promotion*') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('promotion.index') }}">{{ __('Promotion') }}</a>
                            </li>
                        @endcan
                        @can('Manage Complaint')
                            <li class="{{ request()->is('complaint*') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('complaint.index') }}">{{ __('Complaints') }}</a>
                            </li>
                        @endcan
                        @can('Manage Warning')
                            <li class="{{ request()->is('warning*') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('warning.index') }}">{{ __('Warning') }}</a>
                            </li>
                        @endcan
                        @can('Manage Termination')
                            <li class="{{ request()->is('termination*') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('termination.index') }}">{{ __('Termination') }}</a>
                            </li>
                        @endcan
                        @can('Manage Announcement')
                            <li class="{{ request()->is('announcement*') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('announcement.index') }}">{{ __('Announcement') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

            @if(Auth::user()->type != 'super admin')
                <li class="{{ (Request::route()->getName() == 'chats') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('chats')}}"><i class="fas fa-comments"></i> <span>{{__('Chats')}}</span></a>
                </li>
            @endif

            @can('Manage Ticket')
                <li class="{{ request()->is('ticket*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('ticket.index')}}"><i class="fas fa-ticket-alt"></i> <span>{{ __('Ticket') }}</span></a>
                </li>
            @endcan
            @can('Manage Event')
                <li class="{{ request()->is('event*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('event.index')}}"><i class="fas fa-calendar-alt"></i> <span>{{ __('Event') }}</span></a>
                </li>
            @endcan
            @can('Manage Meeting')
                <li class="{{ request()->is('meeting*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('meeting.index')}}"><i class="fas fa-handshake"></i> <span>{{ __('Meeting') }}</span></a>
                </li>
            @endcan
            @if(Gate::check('Manage Assets'))
                <li class="{{ (Request::segment(1) == 'account-assets')?'active':''}}">
                    <a class="nav-link" href="{{ route('account-assets.index') }}">
                        <i class="fa fa-calculator"></i> <span>{{__('Assets')}}</span>
                    </a>
                </li>
            @endif
            @if(Gate::check('Manage Document'))
                <li class="{{ (Request::segment(1) == 'document-upload')?'active':''}}">
                    <a class="nav-link" href="{{ route('document-upload.index') }}">
                        <i class="fa fa-file"></i> <span>{{__('Document')}}</span>
                    </a>
                </li>
            @endif
            @if(Gate::check('Manage Company Policy'))
                <li class="{{ (Request::segment(1) == 'company-policy')?'active':''}}">
                    <a class="nav-link" href="{{ route('company-policy.index') }}"><i class="fa fa-pray"></i><span>{{__('Company Policy')}}</span></a>
                </li>
            @endif
            @if(Gate::check('Manage Plan'))
                <li class="{{ request()->is('plans*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('plans.index')}}"><i class="fas fa-trophy"></i> <span>{{ __('Plan') }}</span></a>
                </li>
            @endif
            @if(Gate::check('manage coupon'))
                <li class="{{ (Request::segment(1) == 'coupons')?'active':''}}">
                    <a class="nav-link" href="{{ route('coupons.index') }}"><i class="fas fa-gift"></i><span>{{__('Coupon')}}</span></a>
                </li>
            @endif
            @if(Gate::check('Manage Order'))
                <li class="{{ request()->is('orders*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('order.index')}}"><i class="fas fa-cart-plus"></i> <span>{{ __('Order') }}</span></a>
                </li>
            @endif

            @if(Gate::check('Manage Report'))
                <li class="dropdown {{ (Request::route()->getName() == 'report.income-expense' || Request::route()->getName() == 'report.leave' || Request::route()->getName() == 'report.account.statement' || Request::route()->getName() == 'report.payroll' || Request::route()->getName() == 'report.monthly.attendance' || Request::route()->getName() == 'report.daily.attendance' || Request::route()->getName() == 'report.timesheet' ) ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-list"></i> <span>{{ __('Report') }}</span></a>
                    <ul class="dropdown-menu">
                        @can('Manage Report')
                            <li class="{{ request()->is('report/income-expense') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('report.income-expense') }}">{{ __('Income Vs Expense') }}</a>
                            </li>
                            <li class="{{ request()->is('report/leave') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('report.leave') }}">{{ __('Leave') }}</a>
                            </li>
                            <li class="{{ request()->is('report/account-statement') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('report.account.statement') }}">{{ __('Account Statement') }}</a>
                            </li>
                            <li class="{{ request()->is('report/payroll') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('report.payroll') }}">{{ __('Payroll') }}</a>
                            </li>
                            <li class="{{ request()->is('report/daily/attendance') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('report.daily.attendance') }}">{{ __('Daily Attendance') }}</a>
                            </li>
                            <li class="{{ request()->is('report/monthly/attendance') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('report.monthly.attendance') }}">{{ __('Monthly Attendance') }}</a>
                            </li>
                            <li class="{{ request()->is('report/timesheet') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('report.timesheet') }}">{{ __('Timesheet') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif


            @if(Gate::check('Manage Department') || Gate::check('Manage Designation')  || Gate::check('Manage Document Type')  || Gate::check('Manage Branch') || Gate::check('Manage Award Type') || Gate::check('Manage Termination Types')|| Gate::check('Manage Payslip Type') || Gate::check('Manage Allowance Option') || Gate::check('Manage Loan Options')  || Gate::check('Manage Deduction Options') || Gate::check('Manage Expense Type')  || Gate::check('Manage Income Type') || Gate::check('Manage
             Payment Type')  || Gate::check('Manage Leave Type') || Gate::check('Manage Training Type'))
                <li class="dropdown {{ (Request::route()->getName() == 'department.index' || Request::route()->getName() == 'designation.index' || Request::route()->getName() == 'document.index' || Request::route()->getName() == 'branch.index' || Request::route()->getName() == 'awardtype.index' || Request::route()->getName() == 'terminationtype.index' || Request::route()->getName() == 'paysliptype.index' || Request::route()->getName() == 'allowanceoption.index' || Request::route()->getName() ==
            'loanoption.index' || Request::route()->getName() == 'deductionoption.index' || Request::route()->getName() == 'expensetype.index' || Request::route()->getName() == 'incometype.index'|| Request::route()->getName() == 'paymenttype.index' || Request::route()->getName() == 'leavetype.index' || Request::route()->getName() == 'goaltype.index' || Request::route()->getName() == 'trainingtype.index' || Request::route()->getName() == 'trainingtype.index') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-external-link-alt"></i> <span>{{ __('Constant') }}</span></a>
                    <ul class="dropdown-menu">
                        @can('Manage Branch')
                            <li class="{{ request()->is('branch*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('branch.index') }}">{{ __('Branch') }}</a>
                            </li>
                        @endcan
                        @can('Manage Department')
                            <li class="{{ request()->is('department*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('department.index') }}">{{ __('Department') }}</a>
                            </li>
                        @endcan
                        @can('Manage Designation')
                            <li class="{{ request()->is('designation*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('designation.index') }}">{{ __('Designation') }}</a>
                            </li>
                        @endcan
                        @can('Manage Document Type')
                            <li class="{{ request()->is('document*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('document.index') }}">{{ __('Document Type') }}</a>
                            </li>
                        @endcan

                        @can('Manage Award Type')
                            <li class="{{ request()->is('awardtype*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('awardtype.index') }}">{{ __('Award Type') }}</a>
                            </li>
                        @endcan
                        @can('Manage Termination Types')
                            <li class="{{ request()->is('terminationtype*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('terminationtype.index') }}">{{ __('Termination Type') }}</a>
                            </li>
                        @endcan
                        @can('Manage Payslip Type')
                            <li class="{{ request()->is('paysliptype*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('paysliptype.index') }}">{{ __('Payslip Type') }}</a>
                            </li>
                        @endcan
                        @can('Manage Allowance Option')
                            <li class="{{ request()->is('allowanceoption*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('allowanceoption.index') }}">{{ __('Allowance Option') }}</a>
                            </li>
                        @endcan
                        @can('Manage Loan Option')
                            <li class="{{ request()->is('loanoption*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('loanoption.index') }}">{{ __('Loan Option') }}</a>
                            </li>
                        @endcan
                        @can('Manage Deduction Option')
                            <li class="{{ request()->is('deductionoption*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('deductionoption.index') }}">{{ __('Deduction Option') }}</a>
                            </li>
                        @endcan
                        @can('Manage Expense Type')
                            <li class="{{ request()->is('expensetype*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('expensetype.index') }}">{{ __('Expense Type') }}</a>
                            </li>
                        @endcan
                        @can('Manage Income Type')
                            <li class="{{ request()->is('incometype*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('incometype.index') }}">{{ __('Income Type') }}</a>
                            </li>
                        @endcan
                        @can('Manage Payment Type')
                            <li class="{{ request()->is('paymenttype*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('paymenttype.index') }}">{{ __('Payment Type') }}</a>
                            </li>
                        @endcan
                        @can('Manage Leave Type')
                            <li class="{{ request()->is('leavetype*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('leavetype.index') }}">{{ __('Leave Type') }}</a>
                            </li>
                        @endcan
                        @can('Manage Termination Type')
                            <li class="{{ request()->is('terminationtype*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('terminationtype.index') }}">{{ __('Termination Type') }}</a>
                            </li>
                        @endcan
                        @can('Manage Goal Type')
                            <li class="{{ request()->is('goaltype*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('goaltype.index') }}">{{ __('Goal Type') }}</a>
                            </li>
                        @endcan
                        @can('Manage Training Type')
                            <li class="{{ request()->is('trainingtype*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('trainingtype.index') }}">{{ __('Training Type') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif
            @if(Gate::check('Manage Company Settings') || Gate::check('Manage System Settings'))
                <li class="{{ request()->is('settings*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('settings.index')}}"><i class="fas fa-sliders-h"></i> <span>{{ __('System Setting') }}</span></a>
                </li>
            @endif
        </ul>
    </aside>
</div>
