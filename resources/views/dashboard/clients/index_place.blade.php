@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.clients')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.clients')</li>
            </ol>
        </section>

        <section class="content">

            <div class="row">

                <!--button type="button" style="width: 100px ; height: 50px" class="btn btn-danger"></button-->

                @foreach($clients  as $client )
                    @if ($client->is_active == 1)
                        <a href="{{ route('dashboard.place.edit', $client->id) }}" style="width: 100px ; height: 50px" class="btn btn-danger">{{$client->id}}</a>
                    @elseif ($client->is_active == 0)
                        <a href="{{ route('dashboard.clients.orders.create', $client->id) }}" style="width: 100px ; height: 50px" class="btn btn-primary">{{$client->id}}</a>

                    @endif
                @endforeach

            </div><!-- end of row -->
        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
