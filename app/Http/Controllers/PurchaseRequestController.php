<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CommandNumGen;
use App\Models\PurchaseRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\PurchaseRequest\StorePurchaseRequestService;
use App\Services\PurchaseRequest\UpdatePurchaseRequestService;
use App\Http\Requests\PurchaseRequest\StorePurchaseOrderRequest;
use App\Http\Requests\PurchaseRequest\UpdatePurchaseOrderRequest;
use App\Models\Product;
use App\Models\Supplier;

class PurchaseRequestController extends Controller
{
    use CommandNumGen;

    protected $storePurchaseRequestService;
    protected $updatePurchaseRequestService;

    public function __construct(
        StorePurchaseRequestService $storePurchaseRequestService,
        UpdatePurchaseRequestService $updatePurchaseRequestService
    ) {
        $this->storePurchaseRequestService = $storePurchaseRequestService;
        $this->updatePurchaseRequestService = $updatePurchaseRequestService;
    }

    public function index(Request $request)
    {
        $orders = PurchaseRequest::select('id', 'number', 'date', 'reference', 'responsible')->get();
        return view('purchase_requests.index', compact('orders'));
    }

    public function create()
    {
        $number = $this->generatePurchaseRequestNumber();
        $products = Product::select('id', 'code', 'name')->get();
        $suppliers = Supplier::select('id', 'trade_name')->get();

        return view('purchase_requests.create', \compact('number', 'products', 'suppliers'));
    }

    public function store(StorePurchaseOrderRequest $request)
    {
        try {
            $data = $request->validated();
            $this->storePurchaseRequestService->store($data);
            return response()->json([
                'message' => 'تم إضافة الطلب بنجاح.',
                'redirect' => route('purchase_requests.index')
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'حدث خطأ أثناء إضافة الطلب:',
                'redirect' => route('purchase_requests.index')
            ]);
        }
    }

    public function edit($id)
    {
        $row = DB::table('purchase_requests')
            ->select(
                'purchase_requests.id',
                'purchase_requests.number',
                'purchase_requests.date',
                'purchase_requests.reference',
                'purchase_requests.responsible',
                'purchase_requests.purchase_justifications',
                'purchase_requests.notes',
                'purchase_requests.total',
            )
            ->where('purchase_requests.id', $id)
            ->first();

        $products = DB::table('purchase_request_product')
            ->select(
                'purchase_request_product.id',
                'purchase_request_product.request_id',
                'purchase_request_product.required_parts',
                'purchase_request_product.quantity',
                'purchase_request_product.price',
                'purchase_request_product.total_price',
                'purchase_request_product.description',
                'purchase_request_product.product_responsible',
                'purchase_request_product.created_at',
                'purchase_request_product.updated_at'
            )
            ->where('purchase_request_product.request_id', $id)
            ->get();

        return response()->json([
            'html' => view(
                'purchase_requests.edit',
                [
                    'row' => $row,
                    'products' => $products,
                ]
            )->render(),
        ]);
    }


    public function update(UpdatePurchaseOrderRequest $request, $id)
    {
        Log::info(['request', $request->all()]);
        Log::info(['validated request', $request->validated()]);
        try {
            $this->updatePurchaseRequestService->update($request->all(), $id);
            return response()->json([
                'message' => 'تم تعديل الطلب بنجاح.',
                'redirect' => route('purchase_requests.index')
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'حدث خطأ أثناء تعديل الطلب',
                'redirect' => route('purchase_requests.index')
            ]);
        }
    }

    public function destroy($id)
    {
        try {

            PurchaseRequest::where('id', $id)->delete();
            DB::table('purchase_request_product')->where('request_id', $id)->delete();

            return response()->json([
                'message' => 'تم حذف الطلب بنجاح',
                'redirect' => route('purchase_requests.index')
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'حدث خطأ أثناء حذف الطلب',
                'redirect' => route('purchase_requests.index')
            ]);
        }
    }

    public function MultiDelete(Request $request)
    {

        try {

            DB::table('purchase_request_product')->whereIn('request_id', (array) $request['ids'])->delete();
            PurchaseRequest::whereIn('id', (array) $request['ids'])->delete();
            return response()
                ->json(['message' => 'تم حذف الطلبات بنجاح', 'redirect' => route('purchase_requests.index')]);
        } catch (\Exception $e) {
            Log::error('Error during multi-delete: ' . $e->getMessage(), ['exception' => $e]);

            return response()->json([
                'message' => 'حدث خطأ أثناء حذف الطلبات',
                // 'redirect' => route('purchase_requests.index')
            ]);
        }
    }
}
