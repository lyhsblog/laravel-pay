@extends('adminlte::master')

@section('body')
    @inject(payService, 'Ybzc\Laravel\Pay\PayService')
    <div class="card min-vh-100">
        <!-- /.form group -->

        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                <tr>
                    <th>图标</th>
                    <th>组件</th>
                    <th>排序</th>
                    <th>代码</th>
                    <th class="text-right py-0 align-middle">管理操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($payService->payments() as $item)
                    <tr>
                        <td class="align-middle" style="width: 200px"><img class="img-thumbnail" src="{{$item->getIcon()}}" alt="{{$item->getName()}}"></td>
                        <td class="align-middle">{{$item->getName()}}</td>
                        <td class="align-middle">{{$item->getOrder()}}</td>
                        <td class="align-middle">{{$item->getCode()}}</td>
                        <td class="text-right py-0 align-middle">
                            <a href="{{route('pay.config', ['code' => $item->getCode()])}}" type="button" data-title="组件配置" data-id="#{{$item->getCode()}}" class="btn btn-sm btn-danger btn-ifrMenu">配置</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">暂无人物数据</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
@stop

@section('adminlte_js')
    <script>
        $('.btn-ifrMenu').click(function (e) {
            e.preventDefault();
            let Jq;
            if(top.location!==self.location){
                Jq = window.top.$;
            } else {
                Jq = $;
            }
            let id = $(this).attr('href');
            id = id.replace('./', '').replace(/["&'./:=?[\]]/gi, '-').replace(/(--)/gi, '');
            if (existed = Jq('.iframe-mode .navbar-nav').find('#tab-' + id).length > 0) {
                window.top.iFrameInstance.switchTab('#tab-'+id);
            } else {
                window.top.iFrameInstance.createTab($(this).data('title')+$(this).data('id'), $(this).attr('href'), id, true);
            }
        });
    </script>
@stop
