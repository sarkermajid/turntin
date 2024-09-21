@extends('agent.agent_dashboard')
@section('agent')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Welcome to {{ auth()->user()->name }}</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
                <span class="input-group-text input-group-addon bg-transparent border-primary"
                    data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                <input type="text" class="form-control bg-transparent border-primary"
                    placeholder="Select date" data-input>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="d-none d-md-block col-md-12 col-xl-12 left-wrapper">
            <div class="card rounded">
                <div class="card-body">
                    <div class="mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Name: {{ auth()->user()->name }}</label>
                    </div>
                    <div class="mt-2">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Email: {{ auth()->user()->email }}</label>
                    </div>
                    <div class="mt-2">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Status: {{ auth()->user()->status  }}</label>
                    </div>
                    <div class="mt-2">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Total Check: {{ auth()->user()->check_count ?? 0}}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
