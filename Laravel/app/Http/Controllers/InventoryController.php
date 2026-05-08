<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\QrScanLog;
use App\Models\RawProduct;
use App\Models\Unit;
use App\Models\Vendor;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{

    // Units

    public function store_unit(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:units,name'
        ]);


        $input = $request->all();
        $unit  = Unit::create($input);

        $success['status'] = 200;
        $success['message'] = "Unit created successfully";
        $success['data'] = $unit;

        return response()->json(['success' => $success], 200);
    }
    public function units()
    {

        $units = Unit::all();

        if ($units->count() > 0) {

            $success['status'] = 200;
            $success['message'] = "Units retrieved successfully";
            $success['data'] = $units;

            return response()->json(['success' => $success], 200);
        } else {

            $error['status'] = 400;
            $error['message'] = "No units found";

            return response()->json(['error' => $error], 400);
        }
    }
    public function update_unit(Request $request, $id)
    {

        $unit = Unit::find($id);
        if ($unit) {

            if ($request->name) {
                $unit->name = $request->name;
            }

            $unit->save();


            $success['status'] = 200;
            $success['message'] = "Unit updated successfully";
            $success['data'] = $unit;

            return response()->json(['success' => $success], 200);
        } else {

            $error['status'] = 400;
            $error['message'] = "Unit not found";

            return response()->json(['error' => $error], 400);
        }
    }
    public function delete_unit($id)
    {

        $unit = Unit::find($id);

        $unit->delete();

        $success['status'] = 200;
        $success['message'] = "Unit deleted successfully";

        return response()->json(['success' => $success], 200);
    }

    // Raw Products

    public function store_raw_products(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
            'sku' => 'required|string|unique:raw_products,sku',
            'current_stock' => 'nullable|numeric|min:0',
            'vendor_id' => 'nullable'
        ]);

        $input = $request->all();


        $qrCodeData = $request->sku;
        $qrcode = QrCode::size(300)->generate($qrCodeData);
        $fileName = $request->sku . '.svg';
        // store in storage/app/public
        Storage::disk('public')->put($fileName, $qrcode);

        // ✅ Get APP_URL from env dynamically
        $input['qr_code'] = url('storage/app/public/' . $fileName);

        $product = RawProduct::create($input);

        return response()->json([
            'success' => [
                'status' => 200,
                'message' => 'Raw product created successfully',
                'data' => $product
            ]
        ], 200);
    }
    public function raw_products()
    {


        $products  = RawProduct::with('unit')->get();
        if ($products->count() > 0) {

            $success['status'] = 200;
            $success['message'] = "Products found successfully";
            $success['data'] = $products;

            return response()->json(['success' => $success]);
        } else {

            $error['status'] = 400;
            $error['message'] = "No products found";

            return response()->json(['error' => $error]);
        }
    }
    public function update_raw_product(Request $request, $id)
    {


        $product = RawProduct::find($id);

        if ($product) {

            if ($request->name) {
                $product->name = $request->name;
            }

            if ($request->unit_id) {

                $product->unit_id = $request->unit_id;
            }

            if ($request->sku) {
                $product->sku = $request->sku;
            }

            if ($request->qr_code) {
                $product->qr_code = $request->qr_code;
            }

            if ($request->current_stock) {
                $product->current_stock = $request->current_stock;
            }

            $product->save();

            $success['status'] = 200;
            $success['message'] = "Product updated successfully";
            $success['data'] = $product;


            return response()->json(['success' => $success]);
        } else {

            $error['status'] = 400;
            $error['message'] = "No product found";

            return response()->json(['error' => $error]);
        }
    }
    public function delete_raw_product($id)
    {

        $product = RawProduct::find($id);

        $product->delete();

        $success['status'] = 200;
        $success['message'] = "product deleted successfully";
        $success['data'] = $product;

        return response()->json(['success' => $success]);
    }

    // Vendors
    public function store_vendor(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'company_name' => 'required',
            'email'  => 'required',
            'phone' => 'required',
        ]);


        $input = $request->all();

        $vendor = Vendor::create($input);

        $success['status'] = 200;
        $success['message'] = "vendor store succcessfully";
        $success['data'] = $vendor;

        return response()->json(['success' => $success]);
    }
    public function vendors()
    {

        $vendors = Vendor::all();

        if ($vendors->count() > 0) {
            $success['status'] = 200;
            $success['message'] = "vendors found successfully";
            $success['data'] = $vendors;

            return response()->json(['success' => $success]);
        } else {

            $error['status'] = 400;
            $error['message'] = "No vendors found";

            return response()->json(['error' => $error]);
        }
    }
    public function update_vendor(Request $request, $id)
    {

        $vendor  = Vendor::find($id);

        if ($vendor) {

            if ($request->name) {
                $vendor->name = $request->name;
            }

            if ($request->company_name) {
                $vendor->company_name = $request->company_name;
            }

            if ($request->email) {
                $vendor->email = $request->email;
            }

            if ($request->phone) {
                $vendor->phone = $request->phone;
            }

            $vendor->save();

            $success['status'] = 200;
            $success['message'] = "Vendor updated successfully";
            $success['data'] = $vendor;

            return response()->json(['success' => $success]);
        } else {

            $error['status'] = 400;
            $error['message'] = 'User not found';

            return response()->json(['error' => $error]);
        }
    }
    public function delete_vendor($id)
    {

        $vendor = Vendor::find($id);
        $vendor->delete();


        $success['status'] = 200;
        $success['message'] = "Vendor deleted successfully";
        $success['data'] = $vendor;


        return response()->json(['success' => $success]);
    }


    // Purchase Orders
    // public function store_purchase_order(Request $request)
    // {

    //     $request->validate([
    //         'purchase_order_number' => 'required|unique:purchase_orders,purchase_order_number',
    //         'vendor_id' => 'required|exists:vendors,id',
    //         'purchase_date' => 'required|date',
    //         'raw_products' => 'required',
    //     ]);


    //     $input = $request->all();
    //     $purchase_order = PurchaseOrder::create($input);

    //     $purchase_order_items = [];


    //     foreach (json_decode($request->raw_products) as $raw_product) {
    //         $purchase_order_items[] = [
    //             'purchase_order_id' => $purchase_order->id,
    //             'raw_product_id' => $raw_product->id,
    //             'quantity' => $raw_product->quantity,
    //             'cost' => $raw_product->cost,
    //             'total' => $raw_product->quantity * $raw_product->cost,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ];
    //     }

    //     PurchaseOrderItem::insert($purchase_order_items);

    //     $success['status'] = 200;
    //     $success['message'] = "Purchase order created successfully";
    //     $success['data'] = $purchase_order;

    //     return response()->json(['success' => $success]);
    // }
    
    public function store_purchase_order(Request $request)
{
    $request->validate([
        'purchase_order_number' => 'required|unique:purchase_orders,purchase_order_number',
        'vendor_id' => 'required|exists:vendors,id',
        'purchase_date' => 'required|date',
        'raw_products' => 'required',
    ]);

    $input = $request->all();
    $purchase_order = PurchaseOrder::create($input);

    $purchase_order_items = [];

    foreach (json_decode($request->raw_products) as $raw_product) {

        // Get product
        $product = RawProduct::find($raw_product->id);
        if (!$product) continue;

        // Safe values
        $newQty  = (float) $raw_product->quantity;
        $newCost = (float) $raw_product->cost;

        $oldQty  = (float) ($product->current_stock ?? 0);
        $oldCost = (float) ($product->cost ?? 0);

        // Clean cost_type
        $costType = strtolower(trim($raw_product->cost_type ?? 'average'));

        /* =============================
           COST LOGIC START
        ============================= */

        if ($costType === 'average') {

            // OLD VALUE
            $oldTotal = $oldQty * $oldCost;

            // NEW VALUE
            $newTotal = $newQty * $newCost;

            // TOTAL
            $totalQty = $oldQty + $newQty;

            // AVERAGE CALCULATION
            if ($totalQty > 0) {
                $avgCost = ($oldTotal + $newTotal) / $totalQty;
            } else {
                $avgCost = $newCost;
            }

            // SAVE
            // $product->current_stock = $totalQty;
            $product->cost = round($avgCost, 2);

        } elseif ($costType === 'latest') {

            // Latest purchase cost override
            // $product->current_stock = $oldQty + $newQty;
            $product->cost = $newCost;

        } elseif ($costType === 'old') {

            // Keep old cost, only update stock
            $product->current_stock = $oldQty + $newQty;
            // cost remains unchanged

        } else {

            // fallback (safe)
            // $product->current_stock = $oldQty + $newQty;
            $product->cost = $newCost;
        }

        $product->save();

        /* =============================
           INSERT PURCHASE ITEM
        ============================= */

        $purchase_order_items[] = [
            'purchase_order_id' => $purchase_order->id,
            'raw_product_id'    => $raw_product->id,
            'quantity'          => $newQty,
            'cost'              => $newCost,
            'total'             => $newQty * $newCost,
            'created_at'        => now(),
            'updated_at'        => now(),
        ];
    }

    PurchaseOrderItem::insert($purchase_order_items);

    return response()->json([
        'success' => [
            'status' => 200,
            'message' => "Purchase order created successfully",
            'data' => $purchase_order
        ]
    ]);
}
    
    public function purchase_orders()
    {

        $purchase_orders = PurchaseOrder::with('vendor', 'items')->get();

        if ($purchase_orders->count() > 0) {

            $success['status']  = 200;
            $success['message'] = "Purchase orders retrieved successfully";
            $success['data']    = $purchase_orders;


            return response()->json(['success' => $success]);
        } else {

            $error['status'] = 400;
            $error['message'] = "No purchase orders found";

            return response()->json(['error' => $error]);
        }
    }
    public function update_purchase_order(Request $request, $id)
    {
        $purchase_order = PurchaseOrder::find($id);

        if ($purchase_order) {

            if ($request->purchase_order_number) {
                $purchase_order->purchase_order_number = $request->purchase_order_number;
            }

            if ($request->vendor_id) {
                $purchase_order->vendor_id = $request->vendor_id;
            }

            if ($request->purchase_date) {
                $purchase_order->purchase_date = $request->purchase_date;
            }

            if ($request->status) {
                $purchase_order->status = $request->status;

                if ($request->status == 'received') {
                    foreach ($purchase_order->items as $item) {
                        $raw_product = RawProduct::find($item->raw_product_id);
                        $raw_product->current_stock += $item->quantity;
                        $raw_product->save();
                        
                        QrScanLog::create([
                            'raw_product_id' => $raw_product->id,
                            'quantity'       => $item->quantity,
                            'action'         => 'add',
                        ]);
    
                    }
                }
            }
            $purchase_order->save();


            if ($request->raw_products) {
                PurchaseOrderItem::where('purchase_order_id', $purchase_order->id)->delete();
                $purchase_order_items = [];


                foreach (json_decode($request->raw_products) as $raw_product) {
                    $purchase_order_items[] = [
                        'purchase_order_id' => $purchase_order->id,
                        'raw_product_id' => $raw_product->id,
                        'quantity' => $raw_product->quantity,
                        'cost' => $raw_product->cost,
                        'total' => $raw_product->quantity * $raw_product->cost,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                PurchaseOrderItem::insert($purchase_order_items);
            }


            $success['status'] = 200;
            $success['message'] = "Purchase order updated successfully";
            $success['data'] = $purchase_order;


            return response()->json(['success' => $success]);
        } else {

            $error['status'] = 400;
            $error['message'] = "Purchase order not found";

            return response()->json(['error' => $error]);
        }
    }
    
    
    public function raw_product(Request $request){
        
        $request->validate([
            'sku' => 'required'
            ]);
        
        $raw_pro = RawProduct::where('sku', $request->sku)->with('unit')->first();
        if($raw_pro){
            
            $success['status'] = 200;
            $success['message'] = "Raw products found successfully";
            $success['data'] = $raw_pro;
            
            return response()->json(['success' => $success]);
        }else{
            
            $error['status'] = 400;
            $error['message'] = "No product found";
            
            return response()->json(['error' => $error]);
            
        }
    }
    
    
    public function delete_purchase_order($id)
    {

        $purchase_order = PurchaseOrder::find($id);
        $purchase_order->delete();

        $success['status'] = 200;
        $success['message'] = "Purchase order deleted successfully";
        $success['data'] = $purchase_order;


        return response()->json(['success' => $success]);
    }
    public function purchase_order($id)
    {

        $purchase_order  = PurchaseOrder::with('vendor', 'items')->find($id);

        if ($purchase_order) {

            $success['status'] = 200;
            $success['message'] = "Purchase order retrieved successfully";
            $success['data'] = $purchase_order;

            return response()->json(['success' => $success]);
        } else {

            $error['status'] = 400;
            $error['message'] = "Purchase order not found";

            return response()->json(['error' => $error]);
        }
    }


    public function get_purchase_order_items($id)
{
    // Validate that the purchase order exists
    $purchaseOrder = PurchaseOrder::find($id);
    if (!$purchaseOrder) {

        $error['status'] = 400;
        $error['message'] = "Purchase order not found";

        return response()->json(['error' => $error]);
    }

    // Join raw_products table to get product name
    $items = PurchaseOrderItem::where('purchase_order_items.purchase_order_id', $id)
        ->leftJoin('raw_products', 'purchase_order_items.raw_product_id', '=', 'raw_products.id')
        ->select(
            'purchase_order_items.id',
            'purchase_order_items.raw_product_id',
            'raw_products.name as raw_product_name',
            'purchase_order_items.quantity',
            'purchase_order_items.cost',
            'purchase_order_items.total',
            'purchase_order_items.created_at'
        )
        ->get();

    $success['status'] = 200;
    $success['message'] = "Items found successfully";
    $success['data'] = $items;

    return response()->json(['success' => $success]);
}
    // QR Code Scanning
    // public function scan_qr_code(Request $request)
    // {

    //     $request->validate([
    //         'raw_product_id' => 'required|exists:raw_products,id',
    //         'quantity' => 'required|numeric|min:1',
    //     ]);

    //     $qrScanLog = QrScanLog::create([
    //         'raw_product_id' => $request->raw_product_id,
    //         'quantity' => $request->quantity,
    //     ]);
    //     $rawProduct = RawProduct::find($request->raw_product_id);

    //     $rawProduct->current_stock -= $request->quantity;
    //     $rawProduct->save();

    //     $success['status'] = 200;
    //     $success['message'] = "QR code scanned and stock updated successfully";
    //     $success['data'] = $qrScanLog;

    //     return response()->json(['success' => $success]);
    // }



    public function scan_qr_code(Request $request)
    {
        $request->validate([
            'sku_id' => 'required',
            'quantity'       => 'required|numeric|min:1',
            'action'         => 'required|in:add,minus',
        ]);

        $rawProduct = RawProduct::where('sku', $request->sku_id)->first();

        // Update stock based on action
        if ($request->action === 'add') {

            $rawProduct->current_stock += $request->quantity;
        } else {

            // Prevent negative stock
            if ($rawProduct->current_stock < $request->quantity) {

                $error['status'] = 400;
                $error['message'] = "Insufficient stock";

                return response()->json(['error' => $error]);
            }

            $rawProduct->current_stock -= $request->quantity;
        }

        $rawProduct->save();

        // Log scan
        $qrScanLog = QrScanLog::create([
            'raw_product_id' => $rawProduct->id,
            'quantity'       => $request->quantity,
            'action'         => $request->action,
        ]);

        $success['status'] = 200;
        $success['message'] = "Stock updated successfully";
        $success['data'] = $rawProduct;

        return response()->json(['success' => $success]);
    }
    
    

    public function scan_products(Request $request)
    {
            $request->validate([
                'products' => 'required',
                'products.*.product_id' => 'required|exists:raw_products,id',
                'products.*.quantity' => 'required|numeric|min:1',
            ]);
    
            $updatedProducts = [];
    
            foreach (json_decode($request->products) as $item) {
                
    
                $rawProduct = RawProduct::find($item->product_id);
                $quantity   = $item->quantity;
    
                if ($rawProduct->current_stock < $quantity) {
    
                    return response()->json([
                        'status' => 400,
                        'message' => "Insufficient stock for product ID: " . $rawProduct->id
                    ]);
                }
    
                $rawProduct->current_stock -= $quantity;
                $rawProduct->save();
    
                QrScanLog::create([
                    'raw_product_id' => $rawProduct->id,
                    'quantity'       => $quantity,
                    'action'         => 'minus',
                ]);
    
                $updatedProducts[] = $rawProduct;
            }
         
            $success['status'] = 200;
            $success['message'] = "Bulk stock deducted successfully";
            $success['data'] = $updatedProducts;
            
            return response()->json(['success' => $success]);
    
    
    }
    
    
    
    
    
public function get_products_logs(Request $request, $id)
{
    $query = QrScanLog::where('raw_product_id', $id)
        ->orderBy('id', 'desc');

    // Date filter
    if ($request->from_date) {
        $query->whereDate('created_at', '>=', $request->from_date);
    }

    if ($request->to_date) {
        $query->whereDate('created_at', '<=', $request->to_date);
    }

    // ✅ Pagination (10 per page)
    $logs = $query->paginate(5);

    // Attach product manually
    foreach ($logs as $log) {
        $product = RawProduct::find($log->raw_product_id);
        $log->product = $product;
    }

    return response()->json([
        'success' => [
            'status' => 200,
            'message' => $logs->count() > 0 
                ? "Logs found successfully"
                : "No logs found",
            'data' => $logs->items(),          // only records
            'current_page' => $logs->currentPage(),
            'last_page' => $logs->lastPage(),
            'total' => $logs->total()
        ]
    ]);
}
}
