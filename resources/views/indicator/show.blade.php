<div class="row">
    <div class="col-md-12 ">
        <div class="info">
            <strong>{{__('Branch')}} : </strong>
            <span>{{ !empty($indicator->branches)?$indicator->branches->name:''}}</span>
        </div>
    </div>
    <div class="col-md-6 mt-2">
        <div class="info font-style">
            <strong>{{__('Department')}} : </strong>
            <span>{{ !empty($indicator->departments)?$indicator->departments->name:'' }}</span>
        </div>
    </div>
    <div class="col-md-6 mt-3">
        <div class="info font-style">
            <strong>{{__('Designation')}} : </strong>
            <span>{{ !empty($indicator->designations)?$indicator->designations->name:'' }}</span>
        </div>
    </div>
    <div class="col-md-12">
        <hr>
        <h6>{{__('Technical Competencies')}}</h6>
    </div>
    <div class="col-md-6 mt-2">
        <div class="info font-style">
            <strong>{{__('Customer Experience')}} : </strong>
            <span>{{ __(\App\Indicator::$technical[$indicator->customer_experience]) }}</span>
        </div>
    </div>
    <div class="col-md-6 mt-2">
        <div class="info font-style">
            <strong>{{__('Marketing')}} : </strong>
            <span>{{ __(\App\Indicator::$technical[$indicator->marketing]) }}</span>
        </div>
    </div>
    <div class="col-md-6 mt-2">
        <div class="info font-style">
            <strong>{{__('Administration')}} : </strong>
            <span>{{ __(\App\Indicator::$technical[$indicator->administration]) }}</span>
        </div>
    </div>
    <div class="col-md-12">
        <hr>
        <h6>{{__('Organizational Competencies')}}</h6>
    </div>
    <div class="col-md-6 mt-2">
        <div class="info font-style">
            <strong>{{__('Professionalism')}} : </strong>
            <span>{{ __(\App\Indicator::$technical[$indicator->professionalism]) }}</span>
        </div>
    </div>
    <div class="col-md-6 mt-2">
        <div class="info font-style">
            <strong>{{__('Integrity')}} : </strong>
            <span>{{ __(\App\Indicator::$technical[$indicator->integrity]) }}</span>
        </div>
    </div>
    <div class="col-md-6 mt-2">
        <div class="info font-style">
            <strong>{{__('Attendance')}} : </strong>
            <span>{{ __(\App\Indicator::$technical[$indicator->attendance]) }}</span>
        </div>
    </div>
</div>

