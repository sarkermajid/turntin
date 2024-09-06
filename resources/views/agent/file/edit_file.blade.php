@extends('agent.agent_dashboard')
@section('agent')
    <div class="page-content">
        <div class="row profile-body">
            <div class="col-md-12 col-xl-12 middle-wrapper">
                @if($file->status == 1)
                <h3>Already checked this file.</h3>
                @else
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Update File</h6>
                            <form method="POST" action="{{ route('agent.files.update',['id'=>$file->id]) }}" class="forms-sample" id="myForm"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $file->User->id }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="name" class="form-label">File Name</label>
                                            <input type="text" value="{{ $file->file_name }}" readonly class="form-control" id="name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="username" class="form-label">User</label>
                                            <input type="text" value="{{ $file->User->name }}" readonly class="form-control" id="username">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="ai" class="form-label">AI</label>
                                            <input type="text" name="ai" value="{{ $file->ai }}" class="form-control" id="ai">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="similarity" class="form-label">Similarity</label>
                                            <input type="text" name="similarity" value="{{ $file->similarity }}" class="form-control" id="similarity">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="plagiarism_report" class="form-label">Plagiarism Report</label>
                                            <input type="file" name="plagiarism_report" class="form-control" id="plagiarism_report">
                                            <span>{{ $file->plagiarism_report ?? '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="ai_report" class="form-label">AI Report</label>
                                            <input type="file" name="ai_report" class="form-control" id="ai_report">
                                            <span>{{ $file->ai_report ?? '' }}</span>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="icon" class="form-label">Status</label>
                                            <select name="status" class="form-select" id="status">
                                                <option selected disabled>Select status</option>
                                                <option value="0" {{ $file->status == 0 ? 'selected' : '' }}>Processing</option>
                                                <option value="1" {{ $file->status == 1 ? 'selected' : '' }}>Completed</option>
                                                <option value="2" {{ $file->status == 2 ? 'selected' : '' }}>Invalid File</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="flags" class="form-label">Flags</label>
                                            <input type="text" name="flags" value="{{ $file->flags }}" class="form-control" id="flags">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

@endsection
