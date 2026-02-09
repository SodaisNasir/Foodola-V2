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
            'current_stock' => 'required|numeric|min:0',
        ]);

        $input = $request->all();


        $qrCodeData = $request->sku;
        $qrcode = QrCode::size(300)->generate($qrCodeData);
        $fileName = $request->sku . '.svg';
        Storage::disk('public')->put($fileName, $qrcode);
        $qrCodeUrl = Storage::url($fileName);


        $input['qr_code'] = 'http://127.0.0.1:8000/storage/' . $fileName;
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

        $success['status'] = 200;
        $success['message'] = "Purchase order created successfully";
        $success['data'] = $purchase_order;

        return response()->json(['success' => $success]);
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

    // QR Code Scanning
    public function scan_qr_code(Request $request)
    {

        $request->validate([
            'raw_product_id' => 'required|exists:raw_products,id',
            'quantity' => 'required|numeric|min:1',
        ]);

        $qrScanLog = QrScanLog::create([
            'raw_product_id' => $request->raw_product_id,
            'quantity' => $request->quantity,
        ]);
        $rawProduct = RawProduct::find($request->raw_product_id);

        $rawProduct->current_stock -= $request->quantity;
        $rawProduct->save();

        $success['status'] = 200;
        $success['message'] = "QR code scanned and stock updated successfully";
        $success['data'] = $qrScanLog;

        return response()->json(['success' => $success]);
    }
}
