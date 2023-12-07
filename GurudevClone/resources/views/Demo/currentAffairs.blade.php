@extends('layout.userMain')

@section("content")
    <!-- Main content -->
    @php($backUrl='dashboard')
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title">Current Affairs</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i
                                            class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Current Affair</li>

                        </ol>
                    </nav>

                </div>
            </div>
            <div class="float-right mr-10">
                <div class="input-group input-search">
                    <div class="input-group-append">
                        <button id="datepicker" class="btn btn-date bg-white" type="submit" id="button-addon3"><i class="ti-calendar"></i></button>

                    </div>
                    <input class="form-control"  id="search-input" placeholder="Search">
                    <div class="input-group-append">

                        <a href="{{url('/currentAffairs')}}" class="btn btn-search bg-primary-light" type="submit" id="button-addon3"><i class="ti-search"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <section class="content">

        <div class="row">
            <?php $badges = ["badge-info", "badge-danger-light", "badge-info-light", "badge-warning-light", "badge-primary", "badge-success", "badge-danger"];?>
            @for($i=1;$i<7;$i++)
                <div class="col-md-12 col-lg-4">
                    <div class="card">
                        <img class="card-img-top" src="{{asset('images/gallery/landscape'.$i.'.jpg')}}"
                             alt="Card image cap">

                        <div class="card-footer d-flex justify-content-between bt-0 pb-0">
                            <span class="text-muted">10-05-2021 10:30 AM</span>

                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <a href="#" class="text-info"><i class="fa fa-bookmark-o"></i></a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <h4 class="card-title">Multiple footers</h4>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                                additional content. This content is a little bit longer. <a
                                        href="{{url('currentAffairs/naturals')}}" class="text-danger">Read More</a></p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="#" class="text-default"><span class="badge badge-pill {{$badges[$i]}}">International</span></a>
                            <span class="text-muted"><b>Source :</b><span class="text-danger">The Hindu</span> </span>
                        </div>
                    </div>
                </div>
            @endfor


        </div>
        <!-- /.row -->


    </section>


@endsection