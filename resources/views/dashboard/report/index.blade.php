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


                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                                @if (auth()->user()->hasPermission('products-create'))
                                    <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                @else
                                    <a href="#" class="btn btn-primary disabled"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                @endif
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">




                        <table class="table table-light">
                            <tr>
                                <td>الاردر المفتوح</td>
                                @if(request()->date2 == null || request()->date1 == null)
                                <td>{{$report_aa}}</td>
                                @else
                                    <td>{{$report_a}}</td>
                                @endif
                            </tr>
                            <tr>
                                    <td>تقفيل الاردرات</td>
                                @if(request()->date2 == null || request()->date1 == null)
                                    <td>{{$report_dd}}</td>
                                @else
                                    <td>{{$report_d}}</td>
                                @endif
                            </tr>
                            <tr>
                                <th>اجمالي  الاردرات</th>

                                @if(request()->date2 == null || request()->date1 == null)
                                    <th>{{ $report_aa + $report_dd}}</th>
                                @else
                                    <th>{{ $report_a + $report_d}}</th>
                                @endif
                            </tr>
                            <tr>
                                <th>عدد  الاردرات</th>

                                @if(request()->date2 == null || request()->date1 == null)
                                    <th>{{ $count_order_a}}</th>
                                @else
                                    <th>{{ $count_order}}</th>
                                @endif
                            </tr>
                        </table><!-- end of table -->

                    @if(request()->date2 == null || request()->date1 == null)
                    <table class="table table-striped">
                        <tr>
                            <th>اسم الاردر</th>
                            <th>@lang('site.price')</th>
                            <th>@lang('site.created_at')</th>
                        </tr>

                        @foreach ($orders  as $order)

                            <tr>
                                <td>{{ $order->products[0]->name }}</td>
                                <td>{{ number_format($order->total_price, 2) }}</td>
                                <td>{{ $order->created_at }}</td>
                            </tr>

                        @endforeach



                    </table><!-- end of table -->
                    {{ $orders->appends(request()->query())->links() }}
                    @endif
                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
