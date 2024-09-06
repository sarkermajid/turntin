@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <div class="page-content">
        <div class="row profile-body">
            <div class="col-md-12 col-xl-12 middle-wrapper">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Edit User</h6>
                            <form method="POST" action="{{ route('update.user',['id'=>$user->id]) }}" class="forms-sample" id="myForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" value="{{ $user->name }}" name="name" class="form-control" id="name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" value="{{ $user->username }}" name="username" class="form-control" id="username">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" value="{{ $user->email }}" class="form-control" id="email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="icon" class="form-label">Role</label>
                                            <select name="role" class="form-select" id="role">
                                                <option selected disabled>Select Role</option>
                                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="agent" {{ $user->role == 'agent' ? 'selected' : '' }}>Agent</option>
                                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="slot" class="form-label">Slot</label>
                                            <input type="text" name="slot" value="{{ $user->slot }}" class="form-control" id="slot">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="datepicker" class="form-label">Expire At</label>
                                            <input type="text" value="{{ $user->expire_date }}" placeholder="YYYY-MM-DD" name="expire_date" class="form-control" id="datepicker" autocomplete="off" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="page_id" class="form-label">Page</label>
                                            <select name="page_id" class="form-select" id="page_id">
                                                <option selected disabled>Select Page</option>
                                                @foreach ($pages as $page)
                                                <option value="{{ $page->id }}" {{ $user->page_id == $page->id ? 'selected' : ''}}>{{ $page->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="icon" class="form-label">Status</label>
                                            <select name="status" class="form-select" id="status">
                                                <option selected disabled>Select status</option>
                                                <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- js validation error show --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    username: {
                        required: true,
                    },
                    role: {
                        required: true,
                    },
                    status: {
                        required: true,
                    },
                    slot: {
                        required: true,
                    },
                    expire_date: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Please Enter Name',
                    },
                    username: {
                        required: 'Please Enter Username',
                    },
                    role: {
                        required: 'Please Select Role',
                    },
                    slot: {
                        required: 'Please Select Slots',
                    },
                    expire_date: {
                        required: 'Please Select Expire date',
                    },
                    status: {
                        required: 'Please Select Status',
                    },

                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>
@endsection
