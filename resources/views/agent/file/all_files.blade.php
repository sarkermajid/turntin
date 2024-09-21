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
                                        <th>Working On</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th>File Uploaded</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($files as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->User->name ?? '' }}</td>
                                            <td>{{ $item->file_name ?? '' }}</td>
                                            @if($item->working_on == null)
                                            <td> <a href="{{ route('agent.files.working',['id'=>$item->id]) }}" class="btn btn-sm btn-inverse-warning"> Start Work </a></td>
                                            @elseif($item->working_on != null)
                                            <td> <a href="#" class="btn btn-sm btn-inverse-success"> {{ $item->workingOn->name }} </a></td>
                                            @endif
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
                                            <td><span class="time-elapsed" data-created-at="{{ $item->created_at }}"></span></td>
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


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Convert UTC date to Dhaka time
        function convertToDhakaTime(utcDate) {
            // Create a new Date object from the UTC date
            const dateUtc = new Date(utcDate);

            // Get Dhaka timezone offset in minutes (UTC+6)
            const dhakaOffset = 6 * 60; // 6 hours in minutes

            // Convert UTC time to Dhaka time by adding the offset
            const localDhakaTime = new Date(dateUtc.getTime() + (dhakaOffset * 60 * 1000));
            return localDhakaTime;
        }

        // Function to calculate and display the elapsed time
        function updateElapsedTime() {
            const timeElements = document.querySelectorAll(".time-elapsed");

            timeElements.forEach(function (element) {
                const createdAtUtc = element.getAttribute("data-created-at");
                const createdAtDhaka = convertToDhakaTime(createdAtUtc); // Convert to Dhaka time

                const now = new Date(); // Current time (client time)
                const timeDiff = Math.abs(now - createdAtDhaka);

                const hours = Math.floor(timeDiff / (1000 * 60 * 60));
                const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);

                let timeString = '';
                if (hours > 0) {
                    timeString += hours + ' hour' + (hours > 1 ? 's' : '') + ' ';
                }
                timeString += minutes + ' min' + (minutes > 1 ? 's' : '') + ' ';
                timeString += seconds + ' sec' + (seconds > 1 ? 's' : '');

                element.textContent = timeString + " ago";
            });
        }

        // Initial update and then repeat every 1 second
        updateElapsedTime();
        setInterval(updateElapsedTime, 1000);
    });
</script>
