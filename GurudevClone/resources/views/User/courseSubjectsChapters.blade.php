@extends('layout.userMain')
@section('title','Chapters')
@section("content")
    <style>

        .chapter_box {
            position: relative;
            overflow: hidden;
            background: #fff;
            text-decoration: none !important;
            display: block;
            padding-left: 56px;
            padding-right: 20px;
            border-radius: 10px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            min-height: 75px;
        }
        .chapter_box .chapter-complete {
            background: #e7fff4;
            color: #4caf50;
        }
        .chapter_details h6{
            margin-left: 45px;
            font-size: 15px;
            color: #343a40 !important;
        }
        .badge{
            margin-left: 45px;
        }

        .chapter_box .chapter_count {
            width: 40px;
            height: 40px;
            position: absolute;
            top: 12px;
            left: 12px;
            background: #fff5e7;
            border-radius: 10px;
            font-size: 1.2rem;
            text-align: center;
            line-height: 40px;
            font-weight: 600;
            color: #FF5722;
        }
        .chapter_box .right_icon_wrapper {
            position: absolute;
            right: 15px;
            font-size: 20px;
            top: 16px;
            color: #013788;
        }

    </style>
    @php($backUrl='course/'.$data[0]->course->slug)
    <!-- Main content -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title">Chapter </h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i  class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{url('/course')}}">Course</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{url($backUrl)}}">Subject</a></li>
                            <li class="breadcrumb-item" aria-current="page">Chapter</li>

                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>
    <section class="content">

        <div class="row match-height">

            @php($imgCount=1)
            @foreach($data as $list)
                @php($sideBadge="side-badge-free")
                <?php $readChapter = 'bg-danger-light';$url = 'javascript:void(0)';
                if ($list->type == 'Free') {
                    $chapterLock = 'icon-Arrow-right';
                    $freeChapter = "badge-success-light";
                    $url = url('/course/subject/chapter/' . $list->slug);
                    $chapterText = "Free Chapter";
                } else {
                    $chapterLock = 'icon-Lock';
                    $freeChapter = "badge-danger-light";

                    $chapterText = "Paid Chapter";
                    if ($list->course->payment!=null) {
                        $chapterText = 'Purchased';
                        $freeChapter = "badge-info-light";
                        $chapterLock = 'fa fa-unlock';
                        $url = url('/course/subject/chapter/' . $list->slug);
                    }
                }
                //dd($list);
                if ($list->user_chapter->viewed) {
                    $readChapter = 'bg-success-light';
                }
                ?>

                <div class="col-lg-4 col-12">
                    <a href="{{$url}}" class=" column chapter_box border-info p-15 pull-up" chapterId="{{$list->id}}" chapterName="{{$list->chapter}}"chapterAmount="{{$list->amount}}">

                        <div class="chapter_count chapter-complete">{{$loop->iteration}}</div>
                        <div class="chapter_details">
                            <h6 >{{$list->chapter}} ( <span class="font-size-12"> {{$list->date}}</span> )</h6>
                        </div>
                        <div class="badge {{$freeChapter}}"><span>{{$chapterText}}</span></div>

                        <div class="right_icon_wrapper mt-3">
                                        <span class="{{$chapterLock}} not-purchase font-size-24"><span
                                                    class="path1"></span><span class="path2"></span></span>
                        </div>

                    </a>
                </div>
            @endforeach
        </div>
    </section>
@endsection
