<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">

            <table  id="current_affairs" class="table table-striped table-bordered w-100">
                <thead class="bg-blue">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $array)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{$array['name']}}</td>
                        <td>{{$array['email']}}</td>
                        <td>{{$array['mobile']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>