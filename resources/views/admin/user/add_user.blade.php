@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <div class="page-content">
        <div class="row profile-body">
            <div class="col-md-12 col-xl-12 middle-wrapper">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Add User</h6>
                            <form method="POST" action="{{ route('store.user') }}" class="forms-sample" id="myForm"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control" id="name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" name="username" class="form-control" id="username">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="text" name="email" class="form-control" id="email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="icon" class="form-label">Role</label>
                                            <select name="role" class="form-select" id="role">
                                                <option selected disabled>Select Role</option>
                                                <option value="admin">Admin</option>
                                                <option value="agent">Agent</option>
                                                <option value="user">User</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="slot" class="form-label">Slot</label>
                                            <input type="text" name="slot" class="form-control" id="slot">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="datepicker" class="form-label">Expire At</label>
                                            <input type="text" placeholder="YYYY-MM-DD" name="expire_date" class="form-control" id="datepicker" autocomplete="off" value="">
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
                                                <option value="{{ $page->id }}">{{ $page->name }}</option>
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
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
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
                    password: {
                        required: true,
                    },
                    role: {
                        required: true,
                    },
                    status: {
                        required: true,
                    },
                    expire_date: {
                        required: true,
                    },
                    page_id: {
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
                    password: {
                        required: 'Please Enter Password',
                    },
                    role: {
                        required: 'Please Select Role',
                    },
                    expire_date: {
                        required: 'Please Select Expire date',
                    },
                    status: {
                        required: 'Please Select Status',
                    },
                    page_id: {
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

    <script>
        document.getElementById('role').addEventListener('change', function() {
            var role = this.value;
            var pageSelect = document.getElementById('page_id').parentElement.parentElement;

            if (role === 'agent') {
                pageSelect.style.display = 'none';
            } else {
                pageSelect.style.display = 'block';
            }
        });
    </script>
@endsection
