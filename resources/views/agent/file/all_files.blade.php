@extends('agent.agent_dashboard')
@section('agent')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">All Files</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>User</th>
                                        <th>File Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($files as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->User->name ?? '' }}</td>
                                            <td>{{ $item->file_name ?? '' }}</td>
                                            <td>
                                                @if($item->status == 0)
                                                <span class="badge rounded-pill bg-warning">Processing</span>
                                                @elseif($item->status == 1)
                                                <span class="badge rounded-pill bg-success">Completed</span>
                                                @else
                                                <span class="badge rounded-pill bg-danger">Invalid File</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->status == 1 ||  $item->status == 2 )
                                                <a href="{{ route('agent.files.edit',['id'=>$item->id]) }}" class="btn btn-sm btn-inverse-info disabled"> Update </a>
                                                @else
                                                <a href="{{ route('agent.files.edit',['id'=>$item->id]) }}" class="btn btn-sm btn-inverse-info"> Update </a>
                                                @endif
                                                <a href="{{ route('agent.files.download',['id'=>$item->file_name]) }}" class="btn btn-sm btn-inverse-success"> Download </a>
                                                <a href="{{ route('agent.files.delete',['id'=>$item->id]) }}" id="delete" class="btn btn-sm btn-inverse-danger"> Delete </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
