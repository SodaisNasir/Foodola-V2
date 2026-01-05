<?php

namespace App\Http\Controllers;

use App\Models\Order_Details_Zee;
use App\Models\Orders_Zee;
use App\Models\Rider_Order;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Deal_Items;
use App\Models\Deals;
use App\Models\User;
use App\Models\Products;
use App\Models\Sub_Categories;
use App\Models\Addon_list;
use App\Models\Addon_sublist;
use App\Models\Area;
use App\Models\Dressing_list;
use App\Models\Dressing_sublist;
use App\Models\Types_list;
use App\Models\Type_sublist;
use League\Csv\Reader;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    private $token = '9H$7sT#kP&5A@N*3L6X8Y2Z1W!V0UQJRB';
    public $successStatus = 200;

    public function show_orders(Request $request)
    {
        $token = $request->header('Authorization');

        if ($token == 'Bearer ' . $this->token) {

            if ($request->ETA) {
                $success['ETA'] = $request->ETA;
            }
            $data = [];
            // foreach($order as $o){
            //     $order_details=Order_Details_Zee::where('order_id','=',$o->id)->first();
            //     if($order_details->product_id!=null){
            //         $order_details['product_details']=Products::find($order_details->product_id);
            //     }

            //     if($order_details->deal_id!=null && $order_details->deal_id!='0'){
            //         $order_details['deal_details']=Deals::where('deal_id','=',$order_details->deal_id)->first();
            //     }
            //     if($order_details->deal_item_id!=null && $order_details->deal_item_id!='0'){
            //         $order_details['deal_item_details']=Deal_Items::where('di_id','=',$order_details->deal_item_id)->first();
            //     }
            //     $o['order_details']=$order_details;
            //     $data[]=$o;
            // }
            //      if($request->status==='pending'){
            // $order=Orders_Zee::where('status','=','pending')->get();
            // if($order->count()>0){
            //      foreach($order as $o){
            //         $order_details=Order_Details_Zee::where('order_id','=',$o->id)->get();
            //       $data_o=[];
            //         foreach($order_details as $od){


            //             if($od->deal_id===null || $od->deal_id=='0'){

            //                 if($od->product_id!=null){
            //           $od['product_details']=Products::find($od->product_id);
            //         }
            //          if($od->deal_id!=null && $od->deal_id!='0'){
            //             $od['deal_details']=Deals::where('deal_id','=',$od->deal_id)->first();
            //         }
            //         if($od->deal_item_id!=null && $od->deal_item_id!='0'){
            //             $od['deal_item_details']=Deal_Items::where('di_id','=',$od->deal_item_id)->first();
            //         }

            //           $data_o['product']=$od;
            //             }else if($od->deal_id!=null && $od->deal_id!='0'){
            //                  if($od->product_id!=null){
            //           $od['product_details']=Products::find($od->product_id);
            //         }
            //          if($od->deal_id!=null && $od->deal_id!='0'){
            //             $od['deal_details']=Deals::where('deal_id','=',$od->deal_id)->first();
            //         }
            //         if($od->deal_item_id!=null && $od->deal_item_id!='0'){
            //             $od['deal_item_details']=Deal_Items::where('di_id','=',$od->deal_item_id)->first();
            //         }

            //           $data_o['deals']=$od;
            //             }

            //         }
            //     $o['order_details']= $data_o;

            //         $data[]=$o;
            //     }
            //     $success['user']=$data;
            //     $success['status']=200;
            //     $success['message']='Pending Orders found Successfully';
            //     return response()->json(['success' => $success], $this->successStatus);
            if ($request->status === 'neworder') {
                
                $order = Orders_Zee::where('status', '=', 'neworder')->orderBy('id', 'DESC')->get();
                if ($order->count() > 0) {
                    $data = [];

                    foreach ($order as $o) {

                        $order_details = Order_Details_Zee::where('order_id', $o->id)->get();
                        $dealsByDealId = ['product' => [], 'deals' => []];

                        foreach ($order_details as $od) {
                            if ($od->deal_id === null || $od->deal_id == '0') {
                                // Handle products not associated with a deal
                                if ($od->product_id != null) {
                                    
                                    
                                            $product = Products::find($od->product_id);
                                        
                                            if ($product) {
                                        
                                                $dept = DB::table('departments')
                                                    ->whereJsonContains('sub_category_ids', (int) $product->sub_category_id)
                                                    ->select('id', 'department_name')
                                                    ->first();
                                        
                                                // Merge department into product object
                                                if ($dept) {
                                                    $product->department_id   = $dept->id;
                                                    $product->department_name = $dept->department_name;
                                                } else {
                                                    $product->department_id   = null;
                                                    $product->department_name = null;
                                                }
                                            }
                                    
                                        $od['product_details'] = $product;
                                    
                                    
                                }
                                $dealsByDealId['product'][] = $od; // Store products directly
                            } else {
                                // Handle deals and associated products
                                $dealKey = $od->deal_id;
                                if (!isset($dealsByDealId['deals'][$dealKey])) {
                                    // Initialize a new deal entry
                                    $dealsByDealId['deals'][$dealKey] = [
                                        'deal_details' => Deals::where('deal_id', $dealKey)->first(),
                                        'deal_product' => [] // Initialize an array to store product details
                                    ];
                                }

                                if ($od->product_id != null) {
                                       $product = Products::find($od->product_id);

                                        if ($product) {
                                    
                                            $dept = DB::table('departments')
                                                ->whereJsonContains('sub_category_ids', (int) $product->sub_category_id)
                                                ->select('id', 'department_name')
                                                ->first();
                                    
                                            if ($dept) {
                                                $product->department_id   = $dept->id;
                                                $product->department_name = $dept->department_name;
                                            } else {
                                                $product->department_id   = null;
                                                $product->department_name = null;
                                            }
                                        }
                                    
                                        $od['product_details'] = $product;
                                    
                                    
                                    
                                    
                                    
                                    
                                    if ($od->deal_item_id != null && $od->deal_item_id != '0') {
                                        $od['deal_item_details'] = Deal_Items::where('di_id', $od->deal_item_id)->first();
                                    }
                                    if (isset($od->addons)) {
                                        $od['addons'] = json_decode($od->addons);
                                    }
                                    $dealsByDealId['deals'][$dealKey]['deal_product'][] = $od; // Store product details within the deal
                                }
                            }
                        }

                        // Convert deals array structure to indexed array
                        $dealsArray = [];
                        foreach ($dealsByDealId['deals'] as $dealKey => $deal) {
                            $dealsArray[] = $deal;
                        }

                        $dealsByDealId['deals'] = $dealsArray;
                        $o['userDetails'] = User::where('id', $o->user_id)->first();
                        $o['order_details'] = $dealsByDealId;
                        
                
                        $o['qr_code'] = "base64_image_" . $o->id . ".svg";
                        
                        
                            $department_list = [];
                            $addedDepartments = [];
                            
                            foreach ($order_details as $od) {
                                    $product = DB::table('products')->where('id', $od->product_id)->first();
                                         if ($product) {
                                    
                                        $subCategoryId = (int) $product->sub_category_id;
                                    
                                        $departments = DB::table('departments')->whereJsonContains('sub_category_ids', $subCategoryId)->select('id', 'department_name')->get();
                                    
                                        foreach ($departments as $dep) {
                                    
                                            if (in_array($dep->id, $addedDepartments)) {
                                                continue;
                                            }
                                    
                                            $department_list[] = [
                                                'department_id'   => $dep->id,
                                                'department_name' => $dep->department_name,
                                            ];
                                    
                                            $addedDepartments[] = $dep->id;
                                        }
                                    }
                            
                                
                            }
                            $o['departments'] = $department_list;
                        
                        $data[] = $o;
                    }

                    $success['user'] = $data;
                    $success['status'] = 200;
                    $success['message'] = 'Pending Orders found Successfully';
                    return response()->json(['success' => $success], $this->successStatus);
                } else {
                    $success['status'] = 400;
                    $success['message'] = 'No Orders found';
                    return response()->json(['error' => $success]);
                }
            } else if ($request->status === 'pending') {
                $order = Orders_Zee::where('status', ['pending', 'shipped'])->orderBy('id', 'DESC')->get();

                if ($order->count() > 0) {
                    $data = [];

                    foreach ($order as $o) {

                        $order_details = Order_Details_Zee::where('order_id', $o->id)->get();
                        $dealsByDealId = ['product' => [], 'deals' => []];

                        foreach ($order_details as $od) {
                            if ($od->deal_id === null || $od->deal_id == '0') {
                                // Handle products not associated with a deal
                                if ($od->product_id != null) {
                                    // $od['product_details'] = Products::find($od->product_id);
                                    
                                        $product = Products::find($od->product_id);
                                    
                                        if ($product) {
                                    
                                            $dept = DB::table('departments')
                                                ->whereJsonContains('sub_category_ids', (int) $product->sub_category_id)
                                                ->select('id', 'department_name')
                                                ->first();
                                    
                                            // Merge department into product object
                                            if ($dept) {
                                                $product->department_id   = $dept->id;
                                                $product->department_name = $dept->department_name;
                                            } else {
                                                $product->department_id   = null;
                                                $product->department_name = null;
                                            }
                                        }
                                    
                                        $od['product_details'] = $product;
                                }
                                $dealsByDealId['product'][] = $od; // Store products directly
                                
                                
                                
                                    $product = DB::table('products')->where('id', $od->product_id)->first();

                                    $department_list = [];
                                    $addedDepartments = [];
                                    
                                    if ($product) {
                                        $subCategoryId = (int) $product->sub_category_id;
                                        $departments = DB::table('departments')->whereJsonContains('sub_category_ids', $subCategoryId)->select('id', 'department_name')->get();
                                        foreach ($departments as $dep) {
                                    
                                            if (in_array($dep->id, $addedDepartments)) {
                                                continue;
                                            }
                                    
                                            $department_list[] = [
                                                'department_id'   => $dep->id,
                                                'department_name' => $dep->department_name,
                                            ];
                                    
                                            $addedDepartments[] = $dep->id;
                                        }
                                    }
                                    
                                    $o['departments'] = $department_list;
                                
                                
                            } else {
                                // Handle deals and associated products
                                $dealKey = $od->deal_id;
                                if (!isset($dealsByDealId['deals'][$dealKey])) {
                                    // Initialize a new deal entry
                                    $dealsByDealId['deals'][$dealKey] = [
                                        'deal_details' => Deals::where('deal_id', $dealKey)->first(),
                                        'deal_product' => [] // Initialize an array to store product details
                                    ];
                                }

                                if ($od->product_id != null) {
                                    // $od['product_details'] = Products::find($od->product_id);
                                    
                                        $product = Products::find($od->product_id);
                                    
                                        if ($product) {
                                    
                                            $dept = DB::table('departments')
                                                ->whereJsonContains('sub_category_ids', (int) $product->sub_category_id)
                                                ->select('id', 'department_name')
                                                ->first();
                                    
                                            // Merge department into product object
                                            if ($dept) {
                                                $product->department_id   = $dept->id;
                                                $product->department_name = $dept->department_name;
                                            } else {
                                                $product->department_id   = null;
                                                $product->department_name = null;
                                            }
                                        }
                                    
                                        $od['product_details'] = $product;
                                    if ($od->deal_item_id != null && $od->deal_item_id != '0') {
                                        $od['deal_item_details'] = Deal_Items::where('di_id', $od->deal_item_id)->first();
                                    }
                                    if (isset($od->addons)) {
                                        $od['addons'] = json_decode($od->addons);
                                    }
                                    $dealsByDealId['deals'][$dealKey]['deal_product'][] = $od; // Store product details within the deal
                                }
                            }
                        }

                        // Convert deals array structure to indexed array
                        $dealsArray = [];
                        foreach ($dealsByDealId['deals'] as $dealKey => $deal) {
                            $dealsArray[] = $deal;
                        }

                        $dealsByDealId['deals'] = $dealsArray;
                        $o['userDetails'] = User::where('id', $o->user_id)->first();
                        $o['order_details'] = $dealsByDealId;
                        $o['qr_code'] = "base64_image_" . $o->id . ".svg";
                        
                        
                        
                        
                      $department_list = [];
                            $addedDepartments = [];
                            
                            foreach ($order_details as $od) {
                                    $product = DB::table('products')->where('id', $od->product_id)->first();
                                         if ($product) {
                                    
                                        $subCategoryId = (int) $product->sub_category_id;
                                    
                                        $departments = DB::table('departments')->whereJsonContains('sub_category_ids', $subCategoryId)->select('id', 'department_name')->get();
                                    
                                        foreach ($departments as $dep) {
                                    
                                            if (in_array($dep->id, $addedDepartments)) {
                                                continue;
                                            }
                                    
                                            $department_list[] = [
                                                'department_id'   => $dep->id,
                                                'department_name' => $dep->department_name,
                                            ];
                                    
                                            $addedDepartments[] = $dep->id;
                                        }
                                    }
                            
                                
                            }
                            $o['departments'] = $department_list;
                        
                        
                        
                        $data[] = $o;
                    }

                    $success['user'] = $data;
                    $success['status'] = 200;
                    $success['message'] = 'Pending Orders found Successfully';
                    return response()->json(['success' => $success], $this->successStatus);
                } else {
                    $success['status'] = 400;
                    $success['message'] = 'No Orders found';
                    return response()->json(['error' => $success]);
                }
            } else if ($request->status === 'shipped') {
                $order = Orders_Zee::where('status', '=', 'shipped')->orderBy('id', 'DESC')->get();

                if ($order->count() > 0) {
                    $data = [];
                    foreach ($order as $o) {
                        $order_details = Order_Details_Zee::where('order_id', '=', $o->id)->get();
                        $data_o = [];
                        $dealsByDealId = [];
                        foreach ($order_details as $od) {
                            if ($od->deal_id === null || $od->deal_id == '0') {

                                if ($od->product_id != null) {
                                    // $od['product_details'] = Products::find($od->product_id);
                                    
                                    $product = Products::find($od->product_id);
                                
                                    if ($product) {
                                
                                        $dept = DB::table('departments')
                                            ->whereJsonContains('sub_category_ids', (int) $product->sub_category_id)
                                            ->select('id', 'department_name')
                                            ->first();
                                
                                        // Merge department into product object
                                        if ($dept) {
                                            $product->department_id   = $dept->id;
                                            $product->department_name = $dept->department_name;
                                        } else {
                                            $product->department_id   = null;
                                            $product->department_name = null;
                                        }
                                    }
                                
                                    $od['product_details'] = $product;
                                }

                                $dealsByDealId['product'][] = $od; // Store in an array since it can have multiple products
                            } else if ($od->deal_id != null && $od->deal_id != '0') {

                                if (!isset($dealsByDealId['deals'])) {
                                    // If not, initialize a new deal entry
                                    $dealsByDealId['deals'] = [
                                        'deal_details' => Deals::where('deal_id', '=', $od->deal_id)->first(),
                                        'deal_product' => [] // Initialize an array to store product details
                                    ];
                                }

                                // Check if product_id is not null
                                if ($od->product_id != null) {
                                    // Add product details to the corresponding deal entry
                                    // $product = Products::find($od->product_id);
                                    
                                        $product = Products::find($od->product_id);
                                    
                                        if ($product) {
                                    
                                            $dept = DB::table('departments')
                                                ->whereJsonContains('sub_category_ids', (int) $product->sub_category_id)
                                                ->select('id', 'department_name')
                                                ->first();
                                    
                                            // Merge department into product object
                                            if ($dept) {
                                                $product->department_id   = $dept->id;
                                                $product->department_name = $dept->department_name;
                                            } else {
                                                $product->department_id   = null;
                                                $product->department_name = null;
                                            }
                                        }
                                    
                                        $od['product_details'] = $product;
                                    
                                    
                                    $od['products_items'] = $product;
                                    if ($od->deal_item_id != null && $od->deal_item_id != '0') {
                                        // Add deal item details to the corresponding deal entry
                                        $od['deal_item_details'] = Deal_Items::where('di_id', '=', $od->deal_item_id)->first();
                                    }

                                    $dealsByDealId['deals']['deal_product']['details'][] = $od;
                                    // $dealsByDealId['deals']['deal_product']['product_items'][] = 
                                }

                                // $data_o['deals'][] = $od; // Store in an array since it can have multiple deals

                            }
                        }

                        $o['order_details'] = $dealsByDealId;
                        $o['qr_code'] = "base64_image_" . $o->id . ".svg";
                        
                        
                        
                                            $department_list = [];
                            $addedDepartments = [];
                            
                            foreach ($order_details as $od) {
                                    $product = DB::table('products')->where('id', $od->product_id)->first();
                                         if ($product) {
                                    
                                        $subCategoryId = (int) $product->sub_category_id;
                                    
                                        $departments = DB::table('departments')->whereJsonContains('sub_category_ids', $subCategoryId)->select('id', 'department_name')->get();
                                    
                                        foreach ($departments as $dep) {
                                    
                                            if (in_array($dep->id, $addedDepartments)) {
                                                continue;
                                            }
                                    
                                            $department_list[] = [
                                                'department_id'   => $dep->id,
                                                'department_name' => $dep->department_name,
                                            ];
                                    
                                            $addedDepartments[] = $dep->id;
                                        }
                                    }
                            
                                
                            }
                        $o['departments'] = $department_list;
                        $data[] = $o;
                    }

                    $success['user'] = $data;
                    $success['status'] = 200;
                    $success['message'] = 'Pending Orders found Successfully';
                    return response()->json(['success' => $success]);
                } else {
                    $success['status'] = 400;
                    $success['message'] = 'No Orders found';
                    return response()->json(['error' => $success]);
                }
            } else if ($request->status === 'delivered') {
                $order = Orders_Zee::where('status', '=', 'delivered')->orderBy('id', 'DESC')->get();

                if ($order->count() > 0) {
                    $data = [];
                    foreach ($order as $o) {
                        $order_details = Order_Details_Zee::where('order_id', '=', $o->id)->get();
                        $data_o = [];
                        $dealsByDealId = [];
                        foreach ($order_details as $od) {
                            if ($od->deal_id === null || $od->deal_id == '0') {

                                if ($od->product_id != null) {
                                    // $od['product_details'] = Products::find($od->product_id);
                                       $product = Products::find($od->product_id);

                                        if ($product) {
                                    
                                            $dept = DB::table('departments')
                                                ->whereJsonContains('sub_category_ids', (int) $product->sub_category_id)
                                                ->select('id', 'department_name')
                                                ->first();
                                    
                                            if ($dept) {
                                                $product->department_id   = $dept->id;
                                                $product->department_name = $dept->department_name;
                                            } else {
                                                $product->department_id   = null;
                                                $product->department_name = null;
                                            }
                                        }
                                    
                                        $od['product_details'] = $product;
                                }

                                $dealsByDealId['product'][] = $od; // Store in an array since it can have multiple products
                            } else if ($od->deal_id != null && $od->deal_id != '0') {

                                if (!isset($dealsByDealId['deals'])) {
                                    // If not, initialize a new deal entry
                                    $dealsByDealId['deals'] = [
                                        'deal_details' => Deals::where('deal_id', '=', $od->deal_id)->first(),
                                        'deal_product' => [] // Initialize an array to store product details
                                    ];
                                }

                                // Check if product_id is not null
                                if ($od->product_id != null) {
                                    // Add product details to the corresponding deal entry
                                    // $product = Products::find($od->product_id
                                       $product = Products::find($od->product_id);

                                    if ($product) {
                                
                                        $dept = DB::table('departments')
                                            ->whereJsonContains('sub_category_ids', (int) $product->sub_category_id)
                                            ->select('id', 'department_name')
                                            ->first();
                                
                                        if ($dept) {
                                            $product->department_id   = $dept->id;
                                            $product->department_name = $dept->department_name;
                                        } else {
                                            $product->department_id   = null;
                                            $product->department_name = null;
                                        }
                                    }
                                
                                    $od['product_details'] = $product;
                                    $od['products_items'] = $product;
                                    if ($od->deal_item_id != null && $od->deal_item_id != '0') {
                                        // Add deal item details to the corresponding deal entry
                                        $od['deal_item_details'] = Deal_Items::where('di_id', '=', $od->deal_item_id)->first();
                                    }

                                    $dealsByDealId['deals']['deal_product']['details'][] = $od;
                                    // $dealsByDealId['deals']['deal_product']['product_items'][] = 
                                }






                                // $data_o['deals'][] = $od; // Store in an array since it can have multiple deals

                            }
                        }

                        $o['order_details'] = $dealsByDealId;
                        $o['qr_code'] = "base64_image_" . $o->id . ".svg";
                         $product = DB::table('products')->where('id', $od->product_id)->first();

                $department_list = [];
                $addedDepartments = [];
                
                if ($product) {
                
                    $subCategoryId = (int) $product->sub_category_id;
                
                    $departments = DB::table('departments')
                        ->whereJsonContains('sub_category_ids', $subCategoryId)
                        ->select('id', 'department_name')
                        ->get();
                
                    foreach ($departments as $dep) {
                
                        if (in_array($dep->id, $addedDepartments)) {
                            continue;
                        }
                
                        $department_list[] = [
                            'department_id'   => $dep->id,
                            'department_name' => $dep->department_name,
                        ];
                
                        $addedDepartments[] = $dep->id;
                    }
                }
                
                $o['departments'] = $department_list;
                        $data[] = $o;
                    }

                    $success['user'] = $data;
                    $success['status'] = 200;
                    $success['message'] = 'Pending Orders found Successfully';
                    return response()->json(['success' => $success]);
                } else {
                    $success['status'] = 400;
                    $success['message'] = 'No Orders found';
                    return response()->json(['error' => $success]);
                }
            }
        } else {
            // Token is invalid; deny access.
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }


public function change_status(Request $request, $id)
{
    $token = $request->header('Authorization');
    if (strval($token) !== 'Bearer ' . $this->token) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $order = Orders_Zee::find($id);
    if (!$order) {
        return response()->json(['error' => ['status' => 400, 'message' => 'No Orders found']]);
    }

    $success = [];

    if ($request->status === 'pending') {
        $order->status = 'pending';
        $order->update();

        $userData = DB::table('users')->where('id', $order->user_id)->first();
        $totalCost = number_format((float)$order->order_total_price, 2, '.', '');

        if ($request->ETA) {
            $success['ETA'] = $request->ETA;
            $TimeSelected = (int) $request->ETA;
            $playerId = [$userData->notification_token];

            $content = [
                "en" => ' Ihre Bestellnummer: ' . $id . ' im Wert von ' . $totalCost . '€ wurde erfolgreich bestätigt und wird im nächsten ' . $TimeSelected . ' an ' . ($TimeSelected + 10) . ' versendet. In wenigen Minuten geliefert.'
            ];

            $this->sendNotification($playerId, $content);
        }

        $qrcode = QrCode::size(300)->generate($order->id);
        $filename = "base64_image_{$order->id}.svg";
        $imagePath = storage_path("app/public/{$filename}");
        file_put_contents($imagePath, base64_decode(base64_encode($qrcode)));

        $order['userDetails'] = $userData;
        $success['qr_code'] = $filename;
        $success['user'] = $order;
        $success['status'] = 200;
        $success['message'] = 'Successfully Order Inprogress';
        return response()->json(['success' => $success], $this->successStatus);

    } elseif ($request->status === 'delivered') {
        $order->delivered_at = Carbon::now()->timestamp;
        $order->status = 'delivered';
        $order->payment_status = 'paid';
        $order->update();

        // Cashback logic
        $cashbackAmount = 0;
        $cashbackStatusSet = false;

        $activeCashback = DB::table('cash_back')->where('status', 1)->first();
        // dd($activeCashback);
        if ($activeCashback && !$order->cashback_status) {
            $cashbackPercent = $activeCashback->cashback_percenatge;
            $cashbackAmount = round($order->order_total_price * ($cashbackPercent / 100), 2);

            DB::update("UPDATE users SET amount = amount + ? WHERE id = ?", [
                $cashbackAmount,
                $order->user_id,
            ]);

            DB::table('tbl_transaction')->insert([
                'user_id' => $order->user_id,
                'transaction_id' => rand(100000, 999999),
                'amount' => $cashbackAmount,
                'type' => 'credit',
                'message' => "{$cashbackAmount} Cashback erhalten für (Bestell-ID: {$id})",
                'english_message' => "{$cashbackAmount} Receive cashback for (order ID: {$id})",
            ]);

            DB::table('orders_zee')->where('id', $id)->update(['cashback_status' => 1]);
            $cashbackStatusSet = true;
        }

        $user = DB::table('users')->where('id', $order->user_id)->first();
        $playerIds = [$user->notification_token];

        $content = $this->getOrderContentMessage('delivered', $id, null, null);
        $this->sendNotification($playerIds, $content);

        DB::table('notification')->insert([
            'user_id' => $order->user_id,
            'content' => $content['en'],
            'german_content' => $content['de'],
            'purpose' => 'order',
        ]);

        $success['user'] = $order;
        $success['cashback'] = $cashbackStatusSet ? $cashbackAmount : 0;
        $success['status'] = 200;
        $success['message'] = 'Successfully Order delivered';
        return response()->json(['success' => $success], $this->successStatus);

    } elseif ($request->status === 'canceled') {
        $order->status = 'canceled';
        $order->update();

        $success['user'] = $order;
        $success['status'] = 200;
        $success['message'] = 'Successfully Order canceled';
        return response()->json(['success' => $success], $this->successStatus);
    }

    return response()->json(['error' => ['status' => 400, 'message' => 'Invalid Status']]);
}


private function sendNotification(array $playerIds, array $content)
{
    $fields = [
        'app_id' => "04869310-bf7c-4e9d-9ec9-faf58aac8168",
        'include_player_ids' => $playerIds,
        'data' => ["foo" => "NewMessage"],
        'large_icon' => "ic_launcher_round.png",
        'contents' => $content,
    ];

    $fieldsJson = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic os_v2_app_asdjgef7prhj3hwj7l2yvlebndv4tpuahlbusgva3p6eutn2x652nleaiuwtlm27le3ugia7aaeb3ikpob2alnlj2pqawjlsb7g2x3q'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsJson);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    curl_exec($ch);
    curl_close($ch);
}

private function getOrderContentMessage($status, $orderId, $deliveredAt = null, $riderName = '')
{
    if ($status === 'pending') {
        return [
            'en' => "Your order no: $orderId has been accepted. Expected delivery: $deliveredAt.",
            'de' => "Ihre Bestellung Nr: $orderId wurde angenommen. Voraussichtliche Lieferung: $deliveredAt."
        ];
    } elseif ($status === 'shipped') {
        return [
            'en' => "Your order no: $orderId has been shipped to rider $riderName.",
            'de' => "Ihre Bestellung Nr: $orderId wurde an Fahrer $riderName versendet."
        ];
    } else {
        return [
            'en' => "Your order no: $orderId has been $status.",
            'de' => "Ihre Bestellung Nr: $orderId wurde $status."
        ];
    }
}



    public function store_rider_order(Request $request, $rider_id, $order_id)
    {
        $token = $request->header('Authorization');

        if ($token === 'Bearer ' . $this->token) {

            $rider_order = Orders_Zee::where('rider_id', '=', NULL)
                ->where('id', '=', $order_id)
                ->first();

            if ($rider_order) {
                $userData = User::where('id', '=', $rider_order->user_id)->first();
                $order["userDetails"] = $userData;
                $playerId = [];
                $subject = '';
                array_push($playerId, $userData['notification_token']);
                $content = array(
                    "en" => 'Ihre Bestellnummer: ' . $order_id . ' wurde versendet'
                );

                $fields = array(
                    'app_id' => "04869310-bf7c-4e9d-9ec9-faf58aac8168",
                    'include_player_ids' => $playerId,
                    'data' => array("foo" => "NewMassage", "Id" => 0),
                    'large_icon' => "ic_launcher_round.png",
                    'contents' => $content
                );

                $fields = json_encode($fields);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json; charset=utf-8',
                    'Authorization: Basic os_v2_app_asdjgef7prhj3hwj7l2yvlebndv4tpuahlbusgva3p6eutn2x652nleaiuwtlm27le3ugia7aaeb3ikpob2alnlj2pqawjlsb7g2x3q'
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                $response = curl_exec($ch);
                curl_close($ch);
                $rider_order->rider_id = $rider_id;
                $rider_order->status = 'shipped'; // Update status to 'Shipped'
                $rider_order->save();

                $success['status'] = 200;
                $success['message'] = 'Rider assigned and order status updated to Shipped successfully';
                return response()->json(['success' => $success]);
            } else {
                $error['status'] = 400;
                $error['message'] = 'Order already taken';
                return response()->json(['error' => $error]);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }






    public function get_rider_orders(Request $request)
    {
        $token = $request->header('Authorization');

        if ($token === 'Bearer ' . $this->token) {
            $rider_id = $request->rider_id;
            $rider_order = Rider_Order::where('rider_id', '=', $rider_id)->where('status', '=', 'delivered')->get();
            $data = [];
            foreach ($rider_order as $r) {
                $order_zee = Orders_Zee::find($r->order_id);
                $order_details = Order_Details_Zee::where('order_id', '=', $order_zee->id)->get();
                $dealsByDealId = [];

                foreach ($order_details as $od) {
                    if ($od->deal_id === null || $od->deal_id == '0') {
                        if ($od->product_id != null) {
                            $od['product_details'] = Products::find($od->product_id);
                        }

                        $dealsByDealId['product'][] = $od; // Store in an array since it can have multiple products
                    } else if ($od->deal_id != null && $od->deal_id != '0') {
                        if (!isset($dealsByDealId['deals'])) {
                            // If not, initialize a new deal entry
                            $dealsByDealId['deals'] = [
                                'deal_details' => Deals::where('deal_id', '=', $od->deal_id)->first(),
                                'deal_product' => [] // Initialize an array to store product details
                            ];
                        }

                        // Check if product_id is not null
                        if ($od->product_id != null) {
                            // Add product details to the corresponding deal entry
                            $product = Products::find($od->product_id);
                            $od['products_items'] = $product;
                            if ($od->deal_item_id != null && $od->deal_item_id != '0') {
                                // Add deal item details to the corresponding deal entry
                                $od['deal_item_details'] = Deal_Items::where('di_id', '=', $od->deal_item_id)->first();
                            }

                            $dealsByDealId['deals']['deal_product']['details'][] = $od;
                        }
                    }
                }
                $order_zee['order_details'] = $dealsByDealId;

                $data[] = $order_zee;
            }
            $success['data'] =  $data;
            $success['status'] = 200;
            $success['message'] = 'Riders Delivered Order Found';
            return response()->json(['success' => $success], $this->successStatus);
        }

        // Token is invalid; deny access.
        return response()->json(['error' => 'Unauthorized'], 401);
    }


    //     public function get_rider_order(Request $request , $id){


    //         $token = $request->header('Authorization');

    //     if ($token === 'Bearer ' . $this->token) {

    //         $orders  = Orders_Zee::where('rider_id', '=', $id)->get();

    //         if($orders->count() > 0){

    //             $success['status'] = 200;
    //             $success['message'] = "orders found successfully";
    //             $success['data'] = $orders;

    //             return response()->json(['success' => $success]);
    //         }else{

    //             $success['status'] = 400;
    //             $success['message'] = 'rider id not found';

    //             return response()->json(['error' => $success ]);
    //         }

    //     }else{

    //             return response()->json(['error' => 'Unauthorized'], 401);


    //     }
    // }



    public function get_rider_order(Request $request)
    {
        $token = $request->header('Authorization');

        if ($token == 'Bearer ' . $this->token) {

            if ($request->ETA) {
                $success['ETA'] = $request->ETA;
            }
            $data = [];

            if ($request->status === 'neworder') {
                $order = Orders_Zee::where('status', '=', 'neworder')->where('rider_id', '=', $request->rider_id)->orderBy('id', 'DESC')->get();
                if ($order->count() > 0) {
                    $data = [];
                    foreach ($order as $o) {
                        $order_details = Order_Details_Zee::where('order_id', '=', $o->id)->get();
                        $data_o = [];
                        $dealsByDealId = [];
                        foreach ($order_details as $od) {
                            if ($od->deal_id === null || $od->deal_id == '0') {

                                if ($od->product_id != null) {
                                    $od['product_details'] = Products::find($od->product_id);
                                }

                                $dealsByDealId['product'][] = $od; // Store in an array since it can have multiple products
                            } else if ($od->deal_id != null && $od->deal_id != '0') {

                                if (!isset($dealsByDealId['deals'])) {
                                    // If not, initialize a new deal entry
                                    $dealsByDealId['deals'] = [
                                        'deal_details' => Deals::where('deal_id', '=', $od->deal_id)->first(),
                                        'deal_product' => [] // Initialize an array to store product details
                                    ];
                                }

                                // Check if product_id is not null
                                if ($od->product_id != null) {
                                    // Add product details to the corresponding deal entry
                                    $product = Products::find($od->product_id);
                                    $od['products_items'] = $product;
                                    if ($od->deal_item_id != null && $od->deal_item_id != '0') {
                                        // Add deal item details to the corresponding deal entry
                                        $od['deal_item_details'] = Deal_Items::where('di_id', '=', $od->deal_item_id)->first();
                                    }

                                    $dealsByDealId['deals']['deal_product']['details'][] = $od;
                                    // $dealsByDealId['deals']['deal_product']['product_items'][] = 
                                }






                                // $data_o['deals'][] = $od; // Store in an array since it can have multiple deals

                            }
                        }

                        $o['order_details'] = $dealsByDealId;
                        $o['qr_code'] = "base64_image_" . $o->id . ".svg";
                        $data[] = $o;
                    }

                    $success['user'] = $data;
                    $success['status'] = 200;
                    $success['message'] = 'Pending Orders found Successfully';
                    return response()->json(['success' => $success], $this->successStatus);
                } else {
                    $success['status'] = 400;
                    $success['message'] = 'No Orders found';
                    return response()->json(['error' => $success]);
                }
            } else if ($request->status === 'pending') {
                $order = Orders_Zee::where('status', '=', 'pending')->where('rider_id', '=', $request->rider_id)->orderBy('id', 'DESC')->get();

                if ($order->count() > 0) {
                    $data = [];
                    foreach ($order as $o) {
                        $order_details = Order_Details_Zee::where('order_id', '=', $o->id)->get();
                        $data_o = [];
                        $dealsByDealId = [];
                        foreach ($order_details as $od) {
                            if ($od->deal_id === null || $od->deal_id == '0') {

                                if ($od->product_id != null) {
                                    $od['product_details'] = Products::find($od->product_id);
                                }

                                $dealsByDealId['product'][] = $od; // Store in an array since it can have multiple products
                            } else if ($od->deal_id != null && $od->deal_id != '0') {

                                if (!isset($dealsByDealId['deals'])) {
                                    // If not, initialize a new deal entry
                                    $dealsByDealId['deals'] = [
                                        'deal_details' => Deals::where('deal_id', '=', $od->deal_id)->first(),
                                        'deal_product' => [] // Initialize an array to store product details
                                    ];
                                }

                                // Check if product_id is not null
                                if ($od->product_id != null) {
                                    // Add product details to the corresponding deal entry
                                    $product = Products::find($od->product_id);
                                    $od['products_items'] = $product;
                                    if ($od->deal_item_id != null && $od->deal_item_id != '0') {
                                        // Add deal item details to the corresponding deal entry
                                        $od['deal_item_details'] = Deal_Items::where('di_id', '=', $od->deal_item_id)->first();
                                    }

                                    $dealsByDealId['deals']['deal_product']['details'][] = $od;
                                    // $dealsByDealId['deals']['deal_product']['product_items'][] = 
                                }






                                // $data_o['deals'][] = $od; // Store in an array since it can have multiple deals

                            }
                        }

                        $o['order_details'] = $dealsByDealId;
                        $o['qr_code'] = "base64_image_" . $o->id . ".svg";
                        $data[] = $o;
                    }

                    $success['user'] = $data;
                    $success['status'] = 200;
                    $success['message'] = 'Pending Orders found Successfully';
                    return response()->json(['success' => $success], $this->successStatus);
                } else {
                    $success['status'] = 400;
                    $success['message'] = 'No Orders found';
                    return response()->json(['error' => $success]);
                }
            } else if ($request->status === 'shipped') {
                $order = Orders_Zee::where('status', '=', 'shipped')->where('rider_id', '=', $request->rider_id)->orderBy('id', 'DESC')->get();

                if ($order->count() > 0) {
                    $data = [];
                    foreach ($order as $o) {
                        $order_details = Order_Details_Zee::where('order_id', '=', $o->id)->get();
                        $data_o = [];
                        $dealsByDealId = [];
                        foreach ($order_details as $od) {
                            if ($od->deal_id === null || $od->deal_id == '0') {

                                if ($od->product_id != null) {
                                    $od['product_details'] = Products::find($od->product_id);
                                }

                                $dealsByDealId['product'][] = $od; // Store in an array since it can have multiple products
                            } else if ($od->deal_id != null && $od->deal_id != '0') {

                                if (!isset($dealsByDealId['deals'])) {
                                    // If not, initialize a new deal entry
                                    $dealsByDealId['deals'] = [
                                        'deal_details' => Deals::where('deal_id', '=', $od->deal_id)->first(),
                                        'deal_product' => [] // Initialize an array to store product details
                                    ];
                                }

                                // Check if product_id is not null
                                if ($od->product_id != null) {
                                    // Add product details to the corresponding deal entry
                                    $product = Products::find($od->product_id);
                                    $od['products_items'] = $product;
                                    if ($od->deal_item_id != null && $od->deal_item_id != '0') {
                                        // Add deal item details to the corresponding deal entry
                                        $od['deal_item_details'] = Deal_Items::where('di_id', '=', $od->deal_item_id)->first();
                                    }

                                    $dealsByDealId['deals']['deal_product']['details'][] = $od;
                                    // $dealsByDealId['deals']['deal_product']['product_items'][] = 
                                }






                                // $data_o['deals'][] = $od; // Store in an array since it can have multiple deals

                            }
                        }

                        $o['order_details'] = $dealsByDealId;
                        $o['qr_code'] = "base64_image_" . $o->id . ".svg";
                        $data[] = $o;
                    }

                    $success['user'] = $data;
                    $success['status'] = 200;
                    $success['message'] = 'Pending Orders found Successfully';
                    return response()->json(['success' => $success]);
                } else {
                    $success['status'] = 400;
                    $success['message'] = 'No Orders found';
                    return response()->json(['error' => $success]);
                }
            } else if ($request->status === 'delivered') {
                $order = Orders_Zee::where('status', '=', 'delivered')->where('rider_id', '=', $request->rider_id)->orderBy('id', 'DESC')->get();

                if ($order->count() > 0) {
                    $data = [];
                    foreach ($order as $o) {
                        $order_details = Order_Details_Zee::where('order_id', '=', $o->id)->get();
                        $data_o = [];
                        $dealsByDealId = [];
                        foreach ($order_details as $od) {
                            if ($od->deal_id === null || $od->deal_id == '0') {

                                if ($od->product_id != null) {
                                    $od['product_details'] = Products::find($od->product_id);
                                }

                                $dealsByDealId['product'][] = $od; // Store in an array since it can have multiple products
                            } else if ($od->deal_id != null && $od->deal_id != '0') {

                                if (!isset($dealsByDealId['deals'])) {
                                    // If not, initialize a new deal entry
                                    $dealsByDealId['deals'] = [
                                        'deal_details' => Deals::where('deal_id', '=', $od->deal_id)->first(),
                                        'deal_product' => [] // Initialize an array to store product details
                                    ];
                                }

                                // Check if product_id is not null
                                if ($od->product_id != null) {
                                    // Add product details to the corresponding deal entry
                                    $product = Products::find($od->product_id);
                                    $od['products_items'] = $product;
                                    if ($od->deal_item_id != null && $od->deal_item_id != '0') {
                                        // Add deal item details to the corresponding deal entry
                                        $od['deal_item_details'] = Deal_Items::where('di_id', '=', $od->deal_item_id)->first();
                                    }

                                    $dealsByDealId['deals']['deal_product']['details'][] = $od;
                                    // $dealsByDealId['deals']['deal_product']['product_items'][] = 
                                }
                            }
                        }

                        $o['order_details'] = $dealsByDealId;
                        $o['qr_code'] = "base64_image_" . $o->id . ".svg";
                        $data[] = $o;
                    }

                    $success['user'] = $data;
                    $success['status'] = 200;
                    $success['message'] = 'Pending Orders found Successfully';
                    return response()->json(['success' => $success]);
                } else {
                    $success['status'] = 400;
                    $success['message'] = 'No Orders found';
                    return response()->json(['error' => $success]);
                }
            }
        } else {
            // Token is invalid; deny access.
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

  public function store_product(Request $request)
{
    
    $request->validate([
        'csv_file' => 'required|file|mimes:csv,txt',
    ]);


    $csvFilePath = $request->file('csv_file')->getPathname();


    $csv = Reader::createFromPath($csvFilePath, 'r');
    $csv->setHeaderOffset(0);


    foreach ($csv as $record) {
        $typeId = $record['type_id'] ?? '-1';
        $dressing  = $record['dressing_id']?? '-1';
        $sku_id = $record['sku_id']??null;
        $discount  = $record['discount']??0;
        $addon_id = $record['addon_id']?? '-1';
$sub_category_id = $record['sub_category_id']?? null;
        Products::create([
            'addon_id' => $addon_id,
            'type_id' => $typeId,
            'dressing_id' => $dressing,
            'sub_category_id' =>$sub_category_id ,
            'name' => utf8_encode($record['name']),
            'sku_id' => $sku_id,
            'description' => utf8_encode($record['description']),
            'cost' => $record['cost'],
            'price' => $record['price'],
            'discount' => $discount,
            'qty' => $record['qty'],
            'img' => $record['img']
        ]);
    }

    return response()->json(['message' => 'Products imported successfully'], 201);
}
    
    
    
public function add_areas(Request $request)
{
    
    $request->validate([
        'csv_file' => 'required|file|mimes:csv,txt',
    ]);


    $csvFilePath = $request->file('csv_file')->getPathname();


    $csv = Reader::createFromPath($csvFilePath, 'r');
    $csv->setHeaderOffset(0);


    foreach ($csv as $record) {
        $area_name = $record['area_name'] ?? '';
        $min_order = $record['min_order_amount'] ?? 0 ;
        $branch_id  = $record['branch_id'] ?? 0 ;

        Area::create([
            'area_name' => $area_name,
            'min_order_amount' => $min_order,
            'branch_id' => $branch_id,
        ]);
    }

    return response()->json(['message' => 'Areas imported successfully'], 201);
}
        
    
    
    
    
    
    
    
    public function store_sub_categories(Request $request){
        
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
            ]);
            
        $csvFilePath = $request->file('csv_file')->getPathname();
        $csv = Reader::createFromPath($csvFilePath, 'r');
        $csv->setHeaderOffset(0);
            
            foreach ($csv as $record) {
            Sub_Categories::create([
                'category_id' => $record['category_id'],
                'name' =>$record['name'],   
                'img' => $record['img']
            ]);
            }

        return response()->json(['message' => 'Categories imported successfully'], 201);
            
    }
    


public function store_addon(Request $request)
{
    $request->validate([
        'csv_file' => 'required|file|mimes:csv,txt',
    ]);

    $csvFilePath = $request->file('csv_file')->getPathname();
    $csv = Reader::createFromPath($csvFilePath, 'r');
    $csv->setHeaderOffset(0);

    // Array to hold ao_title for which Addon_sublist records will be created
    $addonTitles = [];

    foreach ($csv as $record) {
        $aoTitle = utf8_encode($record['ao_title']); // Handle special characters

        // Check if an Addon_list already exists for the given ao_title
        if (!isset($addonTitles[$aoTitle])) {
            // Create Addon_list if not already created
            $addonList = Addon_list::firstOrCreate([
                'ao_title' => $aoTitle
            ]);
            $addonTitles[$aoTitle] = $addonList->id; // Store the ID for future reference
        } else {
            $addonListId = $addonTitles[$aoTitle]; // Use the stored ID
        }

        // Create the Addon_sublist entry
        Addon_sublist::create([
            'ao_id' => $addonTitles[$aoTitle],
            'ao_title' => $aoTitle, 
            'as_name' => utf8_encode($record['as_name']),
            'as_price' => str_replace(',', '.', $record['as_price']), 
            'isFreeInDeal' => filter_var($record['isFreeInDeal'], FILTER_VALIDATE_BOOLEAN)
        ]);
    }

    return response()->json(['message' => 'Add-ons imported successfully'], 201);
}
    
    
    
    
    public function store_dressing(Request $request){
        
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
            ]);
            
        $csvFilePath = $request->file('csv_file')->getPathname();
        $csv = Reader::createFromPath($csvFilePath, 'r');
        $csv->setHeaderOffset(0); 
        
        
        foreach($csv as $record){
            
            $dressinglist  = Dressing_list::create([
                'dressing_title' => $record['dressing_title'],
                'dressing_title_user' => $record['dressing_title_user']
                ]);
     
                
                if($dressinglist){
                    
                    Dressing_sublist::create([
                        'dressing_id' => $dressinglist->id,
                        'dressing_title' =>$dressinglist->dressing_title,
                        'dressing_title_user'=> $dressinglist->dressing_title_user,
                        'dressing_name' => $record['dressing_name']
                        ]);
                }
        }
        
          return response()->json(['message' => 'Dressing imported successfully'], 201);
        
    }
    

    public function store_types(Request $request){
        
        
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
            ]);
            
        $csvFilePath = $request->file('csv_file')->getPathname();
        $csv = Reader::createFromPath($csvFilePath, 'r');
        $csv->setHeaderOffset(0); 
        
        
        foreach($csv as $record){
            
            $type_list = Types_list::create([
                'type_title' => $record['type_title'],
                'type_title_user' => $record['type_title_user']
                ]);
                
            if($type_list){
                    
                    Type_sublist::create([
                        'type_id' =>$type_list->id,
                        'type_title' => $type_list->type_title,
                        'type_title_user'=>$record['type_title_user'],
                        'ts_name' => $record['ts_name']
                        ]);
            }
            
        }
             return response()->json(['message' => 'Types imported successfully'], 201);
    }
    
    
    
    
    
    public function departments(){
        
        $dept = DB::table('departments')->get();
        
        if($dept->count() > 0){
            
            $success['status'] = 200;
            $success['message'] = "Departments found successfully";
            $success['data'] = $dept;
            
            
            return response()->json(['success' => $success]);
        }else{
            
            $error['status'] = 400;
            $error['message'] = "No departments found";
            
            return response()->json(['error' => $error]);
        }
    }
    

}
