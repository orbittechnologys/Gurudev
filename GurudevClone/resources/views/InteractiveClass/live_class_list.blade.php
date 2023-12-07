@extends('layouts.user_layout')
@section('content')
    <div class="row mt-30">
<style>
    table.dataTable td, table.dataTable th {
        border-bottom: 1px solid #f5eeee!important;
        border-top: 0;
    }
</style>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Live Classes</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive mt-1">
                        <table class="table zero-configuration dataTable table-hover-animation mb-0">
                            <thead class="text-nowrap">
                            <tr>
                                <th>#</th>

                                <th>Subject</th>
                                <th>Title</th>
                                <th>Class Timings</th>

                                <th >Duration</th>
                                <th>Description</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                           <tbody>
                           @foreach($class_list as $list)
                               <tr>
                                   <td>{{ $loop->iteration }}</td>

                                   <td >{{$list['subject']['subject']}}</td>
                                   <td >{{$list['title']}}</td>
                                   <td><?php echo date('d-M-Y h:i A',strtotime($list['class_date'].' '.$list['start_time'])); ?></td>
                                   <td >{{ $list['duration'] }}</td>

                                   <td >{{ $list['description'] }}</td>
                                   <td>
                                       <?php
                                           $start_time=date('H:i:s',strtotime($list['start_time']));
                                       $time = explode(':', date('H:i:s',strtotime($list['duration'])));
                                        $minutes= ($time[0]*60) + ($time[1]) + ($time[2]/60);

                                       $result= date('H:i:s',strtotime('+'.$minutes.' minutes',strtotime($start_time)));// $result = date("H:i:s",strtotime(date('H:i:s',strtotime($list['start_time'])))+$secs);
                                       $quiz_date = $list['publish_date'] . ' ' .$result;
                                       $start = date_create(date('Y-m-d H:i:s', strtotime($quiz_date)));
                                       $end = date_create(date('Y-m-d H:i:s'));
                                       $diff = date_diff($end, $start);
                                       if($diff->invert){ ?>
                                           <a  href="#" class="btn btn-outline-danger">Closed </a>
                                       <?php }else { ?>
                                           <a  href="{{ url('user/liveClass/goLive/'.$list['id']) }}" class="btn btn-outline-info">Join </a>
                                       <?php }?>
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

@endsection

@section('forms')
    @include('includes.CssJs.advancedForms')
@endsection


