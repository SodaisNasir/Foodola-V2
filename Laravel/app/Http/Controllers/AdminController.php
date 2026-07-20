<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Account;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AdminController extends Controller
{
    public function accounts(Request $request){
        
        
        $request->validate([
            'company_email' => 'required',
            'password' => 'required'
            ]);
            
            
            
        $account = Account::where('company_email',$request->company_email)->where('password', $request->password)->first();
        
        if($account){
            
            $success['status'] = 200;
            $success['message'] = "Data found successfully";
            $success['data'] = $account;
            
            return response()->json(['success' => $success]);
        }else{
            
            $error['status'] = 400;
            $error['message'] = "Invalid Data";
            
            return response()->json(['error' => $error]);
        }
    }
    
    
    
    
    public function import_excel(Request $request)
    {
        // 1. Validation
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls'
        ]);

        $file = $request->file('excel_file');

        try {
            // 2. Load Excel File
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheetNames = $spreadsheet->getSheetNames();

            // Transaction start: data safe rakhne ke liye
            DB::beginTransaction();

            // -------------------------------------------------------------------------
            // WORKBOOK 1: Main Categories (Index 0)
            // -------------------------------------------------------------------------
            if (isset($sheetNames[0])) {
                $data = $spreadsheet->getSheet(0)->toArray(null, true, true, true);
                array_shift($data); // Header skip kiya

                foreach ($data as $row) {
                    $cat_name = trim($row['B'] ?? '');
                    if (!empty($cat_name)) {
                        DB::table('categories')->insertOrIgnore(['name' => $cat_name]);
                    }
                }
            }

            // -------------------------------------------------------------------------
            // WORKBOOK 2: Sub Categories (Index 1)
            // -------------------------------------------------------------------------
            if (isset($sheetNames[1])) {
                $data = $spreadsheet->getSheet(1)->toArray(null, true, true, true);
                array_shift($data);

                foreach ($data as $row) {
                    $main_cat_id = (int)($row['B'] ?? 0);
                    $sub_cat_name = trim($row['C'] ?? '');

                    if (!empty($sub_cat_name) && $main_cat_id > 0) {
                        DB::table('sub_categories')->insertOrIgnore([
                            'category_id' => $main_cat_id,
                            'name' => $sub_cat_name
                        ]);
                    }
                }
            }

            // -------------------------------------------------------------------------
            // WORKBOOK 3: Addons (Index 2)
            // -------------------------------------------------------------------------
            if (isset($sheetNames[2])) {
                $data = $spreadsheet->getSheet(2)->toArray(null, true, true, true);
                array_shift($data);

                $addonTitles = [];
                foreach ($data as $row) {
                    $ao_title = trim($row['B'] ?? '');
                    $as_name = trim($row['C'] ?? '');
                    $as_price = str_replace(',', '.', trim($row['D'] ?? '0'));
                    $isFreeInDeal = filter_var(trim($row['E'] ?? 'false'), FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

                    if (empty($ao_title)) continue;

                    if (!isset($addonTitles[$ao_title])) {
                        $addon = DB::table('addon_list')->where('ao_title', $ao_title)->first();
                        if ($addon) {
                            $addon_id = $addon->ao_id;
                        } else {
                            $addon_id = DB::table('addon_list')->insertGetId(['ao_title' => $ao_title]);
                        }
                        $addonTitles[$ao_title] = $addon_id;
                    } else {
                        $addon_id = $addonTitles[$ao_title];
                    }

                    DB::table('addon_sublist')->insert([
                        'ao_id' => $addon_id,
                        'ao_title' => $ao_title,
                        'as_name' => $as_name,
                        'as_price' => $as_price,
                        'isFreeInDeal' => $isFreeInDeal
                    ]);
                }
            }

            // -------------------------------------------------------------------------
            // WORKBOOK 4: Types (Index 3)
            // -------------------------------------------------------------------------
            if (isset($sheetNames[3])) {
                $data = $spreadsheet->getSheet(3)->toArray(null, true, true, true);
                array_shift($data);

                foreach ($data as $row) {
                    $type_title = trim($row['B'] ?? '');
                    $type_title_user = trim($row['C'] ?? '');
                    $ts_name = trim($row['D'] ?? '');
                    $price = trim($row['E'] ?? '0');

                    if (empty($type_title)) continue;

                    $type = DB::table('types_list')
                        ->where('type_title', $type_title)
                        ->where('type_title_user', $type_title_user)
                        ->first();

                    $type_id = $type ? $type->type_id : DB::table('types_list')->insertGetId([
                        'type_title' => $type_title,
                        'type_title_user' => $type_title_user
                    ]);

                    $subExists = DB::table('types_sublist')
                        ->where('type_id', $type_id)
                        ->where('ts_name', $ts_name)
                        ->exists();

                    if (!$subExists) {
                        DB::table('types_sublist')->insert([
                            'type_id' => $type_id,
                            'type_title' => $type_title,
                            'type_title_user' => $type_title_user,
                            'ts_name' => $ts_name,
                            'price' => $price
                        ]);
                    }
                }
            }

            // -------------------------------------------------------------------------
            // WORKBOOK 5: Dressing (Index 4)
            // -------------------------------------------------------------------------
            if (isset($sheetNames[4])) {
                $data = $spreadsheet->getSheet(4)->toArray(null, true, true, true);
                array_shift($data);

                foreach ($data as $row) {
                    $dressing_title = trim($row['B'] ?? '');
                    $dressing_title_user = trim($row['C'] ?? '');
                    $dressing_name = trim($row['D'] ?? '');
                    $price = trim($row['E'] ?? '0');

                    if (empty($dressing_title)) continue;

                    $dressing = DB::table('dressing_list')
                        ->where('dressing_title', $dressing_title)
                        ->where('dressing_title_user', $dressing_title_user)
                        ->first();

                    $dressing_id = $dressing ? $dressing->dressing_id : DB::table('dressing_list')->insertGetId([
                        'dressing_title' => $dressing_title,
                        'dressing_title_user' => $dressing_title_user
                    ]);

                    $subExists = DB::table('dressing_sublist')
                        ->where('dressing_id', $dressing_id)
                        ->where('dressing_name', $dressing_name)
                        ->exists();

                    if (!$subExists) {
                        DB::table('dressing_sublist')->insert([
                            'dressing_id' => $dressing_id,
                            'dressing_title' => $dressing_title,
                            'dressing_title_user' => $dressing_title_user,
                            'dressing_name' => $dressing_name,
                            'price' => $price
                        ]);
                    }
                }
            }

            // -------------------------------------------------------------------------
            // WORKBOOK 6: Products (Index 5)
            // -------------------------------------------------------------------------
            $insertedProducts = 0;
            if (isset($sheetNames[5])) {
                $data = $spreadsheet->getSheet(5)->toArray(null, true, true, true);
                array_shift($data);

                foreach ($data as $row) {
                    $name = trim($row['B'] ?? '');
                    if (empty($name)) continue;

                    DB::table('products')->insert([
                        'name'            => $name,
                        'description'     => trim($row['C'] ?? ''),
                        'price'           => trim($row['D'] ?? '0'),
                        'cost'            => trim($row['E'] ?? '0'),
                        'sub_category_id' => trim($row['F'] ?? null),
                        'img'             => trim($row['G'] ?? ''),
                        'qty'             => trim($row['H'] ?? 0),
                        'addon_id'        => trim($row['I'] ?? null),
                        'type_id'         => trim($row['J'] ?? null),
                        'dressing_id'     => trim($row['K'] ?? null),
                        'sku_id'          => trim($row['L'] ?? ''),
                        'discount'        => trim($row['M'] ?? 0),
                        'tax'             => trim($row['N'] ?? 0),
                        'features'        => trim($row['O'] ?? ''),
                    ]);
                    $insertedProducts++;
                }
            }

            // Sab theek raha tou commit karein
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'All 6 sheets imported successfully!',
                'products_count' => $insertedProducts
            ], 200);

        } catch (\Exception $e) {
            // Error ki soorat me sab rollback hojayega
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Import failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
