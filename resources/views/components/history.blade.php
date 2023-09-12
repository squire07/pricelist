<div class="card">
    <div class="card-header text-bold">History</div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped" width="100%">
            <thead>
                <tr>
                    <th class="text-center">Event</th>
                    <th class="text-center">Remarks</th>
                    <th class="text-center">Created By</th>
                    <th class="text-center">Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($histories as $history)
                    <tr>
                        <td>{{ $history->event_name }}</td>
                        <td>{{ $history->remarks }}</td>
                        <td class="text-center">{{ $history->created_by }}</td>
                        <td class="text-center">{{ $history->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>