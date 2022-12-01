<?php

namespace Ybzc\Laravel\Pay;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Ybzc\Laravel\Base\IWebService;
use Ybzc\Laravel\Base\TCrudController;

class PayController extends Controller
{
    private PayService $payService;

    public function __construct(PayService $payService)
    {
        $this->payService = $payService;
    }

    /**
     * 支付组件列表
     * @return Factory|View|Application
     */
    public function components(): Factory|View|Application
    {
        return view($this->payService->tpl('components'));
    }

    /**
     * @param Request $request
     * @return Factory|View|Application
     */
    public function config(Request $request): Factory|View|Application
    {
        return view($this->payService->configTpl($request->input("code")));
    }

    public function updateConfig(Request $request): RedirectResponse
    {
        $this->payService->updateConfig($request);
        Session::flash('success_message', '更新成功');
        return Redirect::back();
    }

    use TCrudController;

    protected function webService(): IWebService
    {
        return $this->payService;
    }
}
