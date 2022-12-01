@extends('adminlte::master')

@section('body')
    @inject(request, 'Illuminate\Http\Request')
    @inject(payService,'Ybzc\Laravel\Pay\PayService')
    @php
        $where = [];
        $start_date = $request->input("start_date");
        $end_date = $request->input("end_date");
        $no = $request->input('no');
        $date = [];
        if($start_date != null) {
            $date['start_date'] = \Illuminate\Support\Carbon::createFromDate($start_date, DateTimeZone::ASIA)->format('Y-m-d H:i:s');
            $where[] = ['created_at', '>=', $date['start_date']];
        }
        if($end_date != null) {
            $date['end_date'] = \Illuminate\Support\Carbon::createFromDate($end_date, DateTimeZone::ASIA)->format('Y-m-d H:i:s');
            $where[] = ['created_at', '<=', $date['end_date']];
        }
        if($no) {
            $where[] = ['no', '=' , $no];
        }
        $pays = $payService->page($where)
    @endphp

    <div class="card min-vh-100">
        <!-- /.form group -->
        <div class="card-header">
            Records: {{$pays->total()}}
            <div class="card-tools d-flex">
                <form action="{{route('people.export')}}">
                    <div class="d-flex mr-1">
                        <div class="form-group form-group-sm">
                            <input type="hidden" id="export_start" name="export_start">
                            <input type="hidden" id="export_end" name="export_end">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                  </span>
                                </div>
                                <input type="text"
                                       class="form-control float-right @error('export_start') is-invalid @enderror"
                                       placeholder="根据时间导出" id="export">
                                <!-- /.input group -->
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fa fa-download"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Date range -->
                <form action="{{route('people.index')}}">
                    <div class="d-flex">
                        <div class="form-group form-group-sm mr-1">
                            @if(count($date) > 0)
                                <input type="hidden" id="start_date" value="{{$date['start_date']}}" name="start_date">
                                <input type="hidden" id="end_date" value="{{$date['end_date']}}" name="end_date">
                            @else
                                <input type="hidden" id="start_date" name="start_date">
                                <input type="hidden" id="end_date" name="end_date">
                            @endif
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                  </span>
                                </div>
                                <input type="text" class="form-control float-right" placeholder="选择时间段"
                                       id="reservation">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group form-group-sm">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="no" class="form-control float-right"
                                       placeholder="输入身份证查询">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>代码</th>
                    <th>金额</th>
                    <th>日期</th>
                    <th class="text-right py-0 align-middle">管理操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($pays as $pay)
                    <tr>
                        <td>{{$pay->id}}.</td>
                        <td>{{$pay->no}}.</td>
                        <td>{{$pay->amount}}</td>
                        <td>{{$pay->created_at}}</td>
                        <td class="text-right py-0 align-middle">
                            <a href="{{route('pay.show', ['id' => $pay->id])}}" type="button" data-title="支付详情"
                               data-id="#{{$pay->id}}" class="btn btn-sm btn-danger btn-ifrMenu">详情</a>
                            <a href="{{route('pay.edit', ['id' => $pay->id])}}" type="button" data-title="编辑支付"
                               data-id="#{{$pay->id}}" class="btn btn-sm btn-danger btn-ifrMenu">编辑</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">暂无支付数据</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            {{$pays->onEachSide(5)->links()}}
        </div>
    </div>
@stop

@section('adminlte_js')
    <script>
        $('.btn-ifrMenu').click(function (e) {
            e.preventDefault();
            let Jq;
            if (top.location !== self.location) {
                Jq = window.top.$;
            } else {
                Jq = $;
            }
            let id = $(this).attr('href');
            id = id.replace('./', '').replace(/["&'./:=?[\]]/gi, '-').replace(/(--)/gi, '');
            if (existed = Jq('.iframe-mode .navbar-nav').find('#tab-' + id).length > 0) {
                window.top.iFrameInstance.switchTab('#tab-' + id);
            } else {
                window.top.iFrameInstance.createTab($(this).data('title') + $(this).data('id'), $(this).attr('href'), id, true);
            }
        });
    </script>
@stop
