@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.products')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.products')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.products') <small></small></h3>

                    <form action="{{ route('dashboard.report') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="date" name="date1"  class="form-control" style="speak-date: ymd" placeholder="@lang('site.search')"
                                       value="{{ request()->date1 }}">
                            </div>

                            <div class="col-md-4">
                                <input type="date" name="date2"  style="speak-date: ymd"class="form-control" placeholder="@lang('site.search')"
                                       value="{{request()->date2 }}">
                            </div>


                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">




                    <table class="table table-light">
                        <tr>
                            <th>اسم الاردر</th>
                            <th>@lang('site.price')</th>
                            <th>@lang('site.created_at')</th>
                        </tr>

                        @foreach ($orders as $order)

                            <tr>
                                <td>{{ $order->client->name }}</td>
                                <td>{{ number_format($order->total_price, 2) }}</td>
                                <td>{{ $order->created_at->toFormattedDateString() }}</td>


                            </tr>

                        @endforeach



                    </table><!-- end of table -->



                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
