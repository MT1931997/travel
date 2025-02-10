<?php

namespace App\Http\Controllers\Accounting;
use App\Http\Controllers\Controller;

use App\Models\Account;
use App\Models\Branch;
use App\Models\CostCenter;
use App\Models\Currency;
use App\Models\Invoice;
use App\Models\InvoiceType;
use App\Models\JournalEntry;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
   protected $columnsIndex;
    protected $columns_view;
    protected $inputTypes;
    protected $required;
    protected $options;
    protected $optionsFromTable;
    protected $routeName;
    protected $modelName;
    protected $currentApplicationName;
    protected $var_releation_radio_tree;
    protected $is_there_radio_tree;
    protected $is_there_radio_tree_self;
    protected $existing_classes;
    protected $model_search_select;
    protected $model_search_select2;
    protected $another_table_for_radio;
    protected $model_name_for_another_table_select;
    protected $columns_table_name;
    protected $index_var;
    protected $create_var;
    protected $edit_var;
    protected $delete_var;
    public function __construct()
    {
        $this->index_var = "Accounting-invoice-table";
        $this->create_var = "Accounting-invoice-add";
        $this->edit_var = "Accounting-invoice-edit";
        $this->delete_var = "Accounting-invoice-delete";

        $this->columnsIndex = ['id','Number', 'date_invoice'];
        $this->columns_view =
        [


            __('messages.Number'),
            __('messages.date_invoice'),

        ];
        $this->columns_table_name = [
            'date_invoice',
            'number',



        ];
        $this->inputTypes = ['text', 'text'];
        $this->required = ['required', 'required'];
        $this->options = ['male','female'];
        $this->routeName = 'invoices'; // Change to your route name
        $this->modelName = Invoice::class; // Change to your model name
        $this->model_name_for_another_table_select = null; // Change to  model name
        $this->currentApplicationName = "Accounting";
        $this->var_releation_radio_tree = null; // هون بنحط اسم الكولومن الموجود في الداتابيس تاع هاد الموديل
        $this->is_there_radio_tree_self = false;
        $this->is_there_radio_tree = false;
        $this->model_search_select = User::class; // model::class if there is model
        $this->model_search_select2 = Account::class; // model::class if there is model
        $this->another_table_for_radio = null; // keep it null . if there is another model change it

       // Self Class
       if ($this->is_there_radio_tree_self) {
       // $this->existing_classes = $this->modelName::with('children')->whereNull('parent_id')->get();
        } else {
            $this->existing_classes = [];
        }

        // Another Class and model
        if ($this->is_there_radio_tree) {
          //  $this->existing_classes = $this->another_table_for_radio::with('children')->whereNull('parent_id')->get();
        } else {
            $this->existing_classes = [];
        }

        // Another Class and model for Select only

       // $this->optionsFromTable = $this->model_name_for_another_table_select::get();
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $data = $this->modelName::search($search)->select($this->columnsIndex)->paginate(PAGINATION_COUNT);
        return view('crud.index', compact('data'))->with(['index_var'=>$this->index_var,'edit_var'=>$this->edit_var,'delete_var'=>$this->delete_var,'columnsIndex' => $this->columnsIndex, 'routeName' => $this->routeName,'currentApplicationName'=>$this->currentApplicationName]);
    }

    public function create(Request $request)
    {
        if (auth()->user()->can($this->create_var))
        {
            $invoice_type_id = $request->query('id');
            $branches = Branch::get();
            $cost_centers = CostCenter::get();
            $currencies = Currency::get();
            $invoice_type = InvoiceType::findOrFail($invoice_type_id);
            return view('custom_pages.invoices.create',compact('cost_centers','currencies','invoice_type','branches','invoice_type_id'))->with(['currentApplicationName' => $this->currentApplicationName,'model_search_select' => $this->model_search_select,'model_search_select2'=>$this->model_search_select2]);

        }else
        {
            return "not auth";
        }
    }

    public function store(Request $request)
    {

        // Validate the request data
         $request->validate([
            'invoice_type_id' => 'required|integer',
            'date_invoice' => 'required|date',
            'number' => 'required|integer',
            'cost_center' => 'required|integer',
            'currency' => 'required|integer',
            'branch' => 'required|integer',
            'payment_type' => 'required|integer',
            'tax_status' => 'required|integer',
            'user' => 'required|integer',
            'account' => 'required|integer',
            'collected' => 'nullable|numeric',
            'in_date_currency_rate' => 'nullable|numeric',
            'note' => 'nullable|string',
            'products.*.name' => 'required|string',
            'products.*.unit' => 'required|integer',
            'products.*.quantity' => 'required|numeric',
            'products.*.selling_price_without_tax' => 'required|numeric',
            'products.*.selling_price_with_tax' => 'required|numeric',
            'products.*.tax' => 'required|numeric',
            'products.*.discount_fixed' => 'nullable|numeric',
            'products.*.discount_percentage' => 'nullable|numeric',
            'products.*.note' => 'nullable|string',
        ]);

        // Create the invoice
        $invoice = new Invoice();
        $invoice->invoice_type_id = $request->invoice_type_id;
        $invoice->date_invoice = $request->date_invoice;
        $invoice->number = $request->number;
        $invoice->cost_center_id = $request->cost_center;
        $invoice->currency_id = $request->currency;
        $invoice->branch_id = $request->branch;
        $invoice->payment_type = $request->payment_type;
        $invoice->tax_status = $request->tax_status;
        $invoice->user_id = $request->user;
        $invoice->account_id = $request->account;
        $invoice->collected = $request->collected;
        $invoice->in_date_currency_rate = $request->in_date_currency_rate;
        $invoice->note = $request->note;
        $invoice->created_by = Auth::id(); // Assuming you have authentication
        $invoice->save();

        // Prepare the products data for attaching to the invoice
        $products = [];
        $total_invoice = null;
        $total_invoice_before_tax = null;
        $total_tax = null;
        foreach ($request->products as $productData) {
            $product = Product::where('name', $productData['name'])->first();
            if ($product) {
                $products[$product->id] = [
                    'quantity' => $productData['quantity'],
                    'selling_price_without_tax' => $productData['selling_price_without_tax'],
                    'selling_price_with_tax' => $productData['selling_price_with_tax'],
                    'tax' => $productData['tax'],
                    'discount_fixed' => $productData['discount_fixed'],
                    'discount_percentage' => $productData['discount_percentage'],
                    'note' => $productData['note'],
                    'unit_id' => $productData['unit'],
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $total_invoice +=$productData['selling_price_with_tax'] * $productData['quantity'];
                $total_invoice_before_tax += $productData['selling_price_without_tax'] * $productData['quantity'];
                $total_tax += ($productData['selling_price_without_tax'] *$productData['tax'] /100 ) * $productData['quantity'];

            }
        }


        // Attach products to the invoice
        $invoice->invoiceProducts()->attach($products);

        // Create JournalEntry
        $journalEntry = new JournalEntry();
        $journalEntry->date_journal = $request->date_invoice;
        $journalEntry->number = $request->number;
        $journalEntry->journal_id = 1;
        $journalEntry->currency_id = $request->currency;
        $journalEntry->branch_id = $request->branch;
        $journalEntry->in_date_currency_rate = $request->in_date_currency_rate;
        $journalEntry->note = $request->note;

        if ($request->has('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store($this->routeName, 'public'); // Save in the 'photos' directory within the 'public' disk
            $journalEntry['photo'] = $photoPath;
        }

        if (!$journalEntry->save()) {
            Log::error('Failed to save JournalEntry', ['journalEntry' => $journalEntry]);
        } else {
            Log::info('JournalEntry saved successfully', ['journalEntry' => $journalEntry]);
        }

        $invoiceType = InvoiceType::find($request->invoice_type_id);
        $sales_account = Account::where('id', $invoiceType->sales_account_id)->first(); //   في جدول انواع الفواتير اسم الحساب
        $depitAccount = Account::find($request->account); // (الصندوق)

        $userId = $request->user;
        $customer = User::find($userId);

        $idAccountOfUserDepit = null;
        $idAccountOfUserCredit = null;
        $salesTaxAccount = null;

            $idAccountOfUserDepit = Branch::select('debits_account_id')->first()->debits_account_id; // ذمم مدينة
            $salesTaxAccount = Branch::select('sales_tax_account_id')->first()->sales_tax_account_id; //  امانات ضريبة المبيعات

            $idAccountOfUserCredit = Branch::select('credits_account_id')->first()->credits_account_id;  // ذمم دائنة



        // فاتورة بيع سند اخراج
        if($request->invoice_type_id == 1)
        {



            // اذا كانت الفاتورة كاش
            if($request->payment_type ==1){
                $accounts = [];
                // Create Journal Entry Details
                if ( $sales_account && $depitAccount) {
                    // ذمم مدينة
                    $accounts[] = [
                        'account_id' => $idAccountOfUserDepit,
                        'depit' => $total_invoice,
                        'credit' => 0,
                        'note' => $request->note,
                        'cost_center_id' => $request->cost_center_id ?? null,
                        'user_id' => $request->user ?? null,
                        'updated_by' => Auth::id(),
                        'updated_at' => now(),
                    ];
                    // مبيعات محلية
                    $accounts[] = [
                        'account_id' => $sales_account->id,
                        'depit' => 0,
                        'credit' => $total_invoice_before_tax ,
                        'note' => $request->note,
                        'cost_center_id' => $request->cost_center_id ?? null,
                        'updated_by' => Auth::id(),
                        'updated_at' => now(),
                    ];
                    // امانات ضريبى المبيعات
                    $accounts[] = [
                        'account_id' => $salesTaxAccount,
                        'depit' => 0,
                        'credit' => $total_tax,
                        'note' => $request->note,
                        'cost_center_id' => $request->cost_center_id ?? null,
                        'updated_by' => Auth::id(),
                        'updated_at' => now(),
                    ];
                    // الصندوق
                    $accounts[] = [
                        'account_id' => $depitAccount->id,
                        'depit' => $total_invoice,
                        'credit' => 0,
                        'note' => $request->note,
                        'cost_center_id' => $request->cost_center_id ?? null,
                        'updated_by' => Auth::id(),
                        'updated_at' => now(),
                    ];
                    // ذمم مدينة
                    $accounts[] = [
                        'account_id' => $idAccountOfUserDepit,
                        'depit' => 0,
                        'credit' => $total_invoice,
                        'note' => $request->note,
                        'cost_center_id' => $request->cost_center_id ?? null,
                        'user_id' => $request->user ?? null,
                        'updated_by' => Auth::id(),
                        'updated_at' => now(),
                    ];
                } else {
                    Log::error('Accounts not found', ['sales_account' => $sales_account, 'depitAccount' => $depitAccount]);
                }

                // Sync accounts to the journal entry
                if (!empty($accounts)) {
                    $journalEntry->journalAccounts()->sync($accounts);
                    Log::info('JournalEntry accounts synced successfully', ['accounts' => $accounts]);
                } else {
                    Log::error('No accounts to sync', ['accounts' => $accounts]);
                }
            }else{
                $accounts = [];
                // Create Journal Entry Details
                if ($sales_account && $depitAccount) {
                    $accounts[] = [
                        'account_id' => $idAccountOfUserDepit,
                        'depit' => $total_invoice,
                        'credit' => 0,
                        'note' => $request->note,
                        'cost_center_id' => $request->cost_center_id ?? null,
                        'user_id' => $request->user ?? null,
                        'updated_by' => Auth::id(),
                        'updated_at' => now(),
                    ];

                    $accounts[] = [
                        'account_id' => $sales_account->id,
                        'depit' => 0,
                        'credit' => $total_invoice,
                        'note' => $request->note,
                        'cost_center_id' => $request->cost_center_id ?? null,
                        'updated_by' => Auth::id(),
                        'updated_at' => now(),
                    ];
                } else {
                    Log::error('Accounts not found', ['sales_account' => $sales_account, 'depitAccount' => $depitAccount]);
                }

                // Sync accounts to the journal entry
                if (!empty($accounts)) {
                    $journalEntry->journalAccounts()->sync($accounts);
                    Log::info('JournalEntry accounts synced successfully', ['accounts' => $accounts]);
                } else {
                    Log::error('No accounts to sync', ['accounts' => $accounts]);
                }
            }



        }if($request->invoice_type_id == 2)
        {




            // اذا كانت مردودالفاتورة كاش
            if($request->payment_type ==1){
                $accounts = [];
                // Create Journal Entry Details
                if ($sales_account && $depitAccount) {
                    // مردود مبيعات
                    $accounts[] = [
                        'account_id' => $sales_account,
                        'depit' => $total_invoice_before_tax,
                        'credit' => 0,
                        'note' => $request->note,
                        'cost_center_id' => $request->cost_center_id ?? null,
                        'updated_by' => Auth::id(),
                        'updated_at' => now(),
                    ];
                    // مبيعات محلية
                    $accounts[] = [
                        'account_id' => $idAccountOfUserDepit,
                        'depit' => 0,
                        'credit' => $total_invoice,
                        'note' => $request->note,
                        'cost_center_id' => $request->cost_center_id ?? null,
                        'user_id' => $request->user ?? null,
                        'updated_by' => Auth::id(),
                        'updated_at' => now(),
                    ];
                    // امانات ضريبى المبيعات
                    $accounts[] = [
                        'account_id' => $salesTaxAccount,
                        'depit' => $total_tax,
                        'credit' => 0,
                        'note' => $request->note,
                        'cost_center_id' => $request->cost_center_id ?? null,
                        'updated_by' => Auth::id(),
                        'updated_at' => now(),
                    ];
                    // الصندوق
                    $accounts[] = [
                        'account_id' => $depitAccount->id,
                        'depit' => 0,
                        'credit' => $total_invoice,
                        'note' => $request->note,
                        'cost_center_id' => $request->cost_center_id ?? null,
                        'updated_by' => Auth::id(),
                        'updated_at' => now(),
                    ];
                    // ذمم مدينة
                    $accounts[] = [
                        'account_id' => $idAccountOfUserDepit,
                        'depit' => $total_invoice,
                        'credit' => 0,
                        'note' => $request->note,
                        'cost_center_id' => $request->cost_center_id ?? null,
                        'user_id' => $request->user ?? null,
                        'updated_by' => Auth::id(),
                        'updated_at' => now(),
                    ];
                } else {
                    Log::error('Accounts not found', ['sales_account' => $sales_account, 'depitAccount' => $depitAccount]);
                }

                // Sync accounts to the journal entry
                if (!empty($accounts)) {
                    $journalEntry->journalAccounts()->sync($accounts);
                    Log::info('JournalEntry accounts synced successfully', ['accounts' => $accounts]);
                } else {
                    Log::error('No accounts to sync', ['accounts' => $accounts]);
                }
            }else{
                $accounts = [];
                // Create Journal Entry Details
                if ($sales_account && $depitAccount) {
                    $accounts[] = [
                        'account_id' => $idAccountOfUserDepit,
                        'depit' => $total_invoice,
                        'credit' => 0,
                        'note' => $request->note,
                        'cost_center_id' => $request->cost_center_id ?? null,
                        'user_id' => $request->user ?? null,
                        'updated_by' => Auth::id(),
                        'updated_at' => now(),
                    ];

                    $accounts[] = [
                        'account_id' => $sales_account->id,
                        'depit' => 0,
                        'credit' => $total_invoice,
                        'note' => $request->note,
                        'cost_center_id' => $request->cost_center_id ?? null,
                        'updated_by' => Auth::id(),
                        'updated_at' => now(),
                    ];
                } else {
                    Log::error('Accounts not found', ['sales_account' => $sales_account, 'depitAccount' => $depitAccount]);
                }

                // Sync accounts to the journal entry
                if (!empty($accounts)) {
                    $journalEntry->journalAccounts()->sync($accounts);
                    Log::info('JournalEntry accounts synced successfully', ['accounts' => $accounts]);
                } else {
                    Log::error('No accounts to sync', ['accounts' => $accounts]);
                }
            }




        }if($request->invoice_type_id == 3)
        {

                // اذا كانت فاتورة المشتريات كاش
                if($request->payment_type ==1){
                    $accounts = [];
                    // Create Journal Entry Details
                    if ($sales_account && $depitAccount) {
                        //  مشتريات محلية
                        $accounts[] = [
                            'account_id' => $sales_account->id,
                            'depit' => $total_invoice_before_tax,
                            'credit' => 0,
                            'note' => $request->note,
                            'cost_center_id' => $request->cost_center_id ?? null,
                            'updated_by' => Auth::id(),
                            'updated_at' => now(),
                        ];
                        // ذمم دائنة
                        $accounts[] = [
                            'account_id' => $idAccountOfUserCredit,
                            'depit' => 0,
                            'credit' => $total_invoice,
                            'note' => $request->note,
                            'cost_center_id' => $request->cost_center_id ?? null,
                            'user_id' => $request->user ?? null,
                            'updated_by' => Auth::id(),
                            'updated_at' => now(),
                        ];
                        // امانات ضريبى المبيعات
                        $accounts[] = [
                            'account_id' => $salesTaxAccount,
                            'depit' => $total_tax,
                            'credit' => 0,
                            'note' => $request->note,
                            'cost_center_id' => $request->cost_center_id ?? null,
                            'updated_by' => Auth::id(),
                            'updated_at' => now(),
                        ];
                        // الصندوق
                        $accounts[] = [
                            'account_id' => $depitAccount->id,
                            'depit' => 0,
                            'credit' => $total_invoice,
                            'note' => $request->note,
                            'cost_center_id' => $request->cost_center_id ?? null,
                            'updated_by' => Auth::id(),
                            'updated_at' => now(),
                        ];
                        // ذمم دائنة
                        $accounts[] = [
                            'account_id' => $idAccountOfUserCredit,
                            'depit' => $total_invoice,
                            'credit' => 0,
                            'note' => $request->note,
                            'cost_center_id' => $request->cost_center_id ?? null,
                            'user_id' => $request->user ?? null,
                            'updated_by' => Auth::id(),
                            'updated_at' => now(),
                        ];
                    } else {
                        Log::error('Accounts not found', ['sales_account' => $sales_account, 'depitAccount' => $depitAccount]);
                    }

                    // Sync accounts to the journal entry
                    if (!empty($accounts)) {
                        $journalEntry->journalAccounts()->sync($accounts);
                        Log::info('JournalEntry accounts synced successfully', ['accounts' => $accounts]);
                    } else {
                        Log::error('No accounts to sync', ['accounts' => $accounts]);
                    }
                }else{
                    $accounts = [];
                    // Create Journal Entry Details
                    if ($sales_account && $depitAccount) {
                        $accounts[] = [
                            'account_id' => $idAccountOfUserDepit,
                            'depit' => $total_invoice,
                            'credit' => 0,
                            'note' => $request->note,
                            'cost_center_id' => $request->cost_center_id ?? null,
                            'user_id' => $request->user ?? null,
                            'updated_by' => Auth::id(),
                            'updated_at' => now(),
                        ];

                        $accounts[] = [
                            'account_id' => $sales_account->id,
                            'depit' => 0,
                            'credit' => $total_invoice,
                            'note' => $request->note,
                            'cost_center_id' => $request->cost_center_id ?? null,
                            'updated_by' => Auth::id(),
                            'updated_at' => now(),
                        ];
                    } else {
                        Log::error('Accounts not found', ['sales_account' => $sales_account, 'depitAccount' => $depitAccount]);
                    }

                    // Sync accounts to the journal entry
                    if (!empty($accounts)) {
                        $journalEntry->journalAccounts()->sync($accounts);
                        Log::info('JournalEntry accounts synced successfully', ['accounts' => $accounts]);
                    } else {
                        Log::error('No accounts to sync', ['accounts' => $accounts]);
                    }
                }

        }if($request->invoice_type_id == 4)
        {


                 // اذا كانت فاتورة مردود المشتريات كاش
                 if($request->payment_type ==1){
                    $accounts = [];
                    // Create Journal Entry Details
                    if ($sales_account && $depitAccount) {
                        //  مشتريات محلية
                        $accounts[] = [
                            'account_id' => $sales_account->id,
                            'depit' => $total_invoice_before_tax,
                            'credit' => 0,
                            'note' => $request->note,
                            'cost_center_id' => $request->cost_center_id ?? null,
                            'updated_by' => Auth::id(),
                            'updated_at' => now(),
                        ];
                        // ذمم دائنة
                        $accounts[] = [
                            'account_id' => $idAccountOfUserCredit,
                            'depit' => 0,
                            'credit' => $total_invoice,
                            'note' => $request->note,
                            'cost_center_id' => $request->cost_center_id ?? null,
                            'user_id' => $request->user ?? null,
                            'updated_by' => Auth::id(),
                            'updated_at' => now(),
                        ];
                        // امانات ضريبى المبيعات
                        $accounts[] = [
                            'account_id' => $salesTaxAccount,
                            'depit' => $total_tax,
                            'credit' => 0,
                            'note' => $request->note,
                            'cost_center_id' => $request->cost_center_id ?? null,
                            'updated_by' => Auth::id(),
                            'updated_at' => now(),
                        ];
                        // الصندوق
                        $accounts[] = [
                            'account_id' => $depitAccount->id,
                            'depit' => 0,
                            'credit' => $total_invoice,
                            'note' => $request->note,
                            'cost_center_id' => $request->cost_center_id ?? null,
                            'updated_by' => Auth::id(),
                            'updated_at' => now(),
                        ];
                        // ذمم دائنة
                        $accounts[] = [
                            'account_id' => $idAccountOfUserCredit,
                            'depit' => $total_invoice,
                            'credit' => 0,
                            'note' => $request->note,
                            'cost_center_id' => $request->cost_center_id ?? null,
                            'user_id' => $request->user ?? null,
                            'updated_by' => Auth::id(),
                            'updated_at' => now(),
                        ];
                    } else {
                        Log::error('Accounts not found', ['sales_account' => $sales_account, 'depitAccount' => $depitAccount]);
                    }

                    // Sync accounts to the journal entry
                    if (!empty($accounts)) {
                        $journalEntry->journalAccounts()->sync($accounts);
                        Log::info('JournalEntry accounts synced successfully', ['accounts' => $accounts]);
                    } else {
                        Log::error('No accounts to sync', ['accounts' => $accounts]);
                    }
                }else{
                    $accounts = [];
                    // Create Journal Entry Details
                    if ($sales_account && $depitAccount) {
                        $accounts[] = [
                            'account_id' => $idAccountOfUserDepit,
                            'depit' => $total_invoice,
                            'credit' => 0,
                            'note' => $request->note,
                            'cost_center_id' => $request->cost_center_id ?? null,
                            'user_id' => $request->user ?? null,
                            'updated_by' => Auth::id(),
                            'updated_at' => now(),
                        ];

                        $accounts[] = [
                            'account_id' => $sales_account->id,
                            'depit' => 0,
                            'credit' => $total_invoice,
                            'note' => $request->note,
                            'cost_center_id' => $request->cost_center_id ?? null,
                            'updated_by' => Auth::id(),
                            'updated_at' => now(),
                        ];
                    } else {
                        Log::error('Accounts not found', ['sales_account' => $sales_account, 'depitAccount' => $depitAccount]);
                    }

                    // Sync accounts to the journal entry
                    if (!empty($accounts)) {
                        $journalEntry->journalAccounts()->sync($accounts);
                        Log::info('JournalEntry accounts synced successfully', ['accounts' => $accounts]);
                    } else {
                        Log::error('No accounts to sync', ['accounts' => $accounts]);
                    }
                }


        }



        if ($request->input('redirect_to') == 'show') {
            return redirect()->route('invoices.show', $invoice->id)->with('success', 'Invoice created successfully!');
        } else {
            return redirect()->route('invoices.index')->with('success', 'Invoice created successfully!');
        }
    }

    public function show($id)
    {
        $invoice = Invoice::with([
            'branch',
            'user',
            'invoice_type' // Include the related invoiceType
        ])->findOrFail($id);

        return view('custom_pages.invoices.show', compact('invoice'))->with(['currentApplicationName' => $this->currentApplicationName,]);
    }

    public function edit($id)
    {
        if (auth()->user()->can($this->edit_var))
        {
            $invoice = Invoice::with('invoiceProducts')->findOrFail($id);
            $branches = Branch::get();
            $cost_centers = CostCenter::get();
            $currencies = Currency::get();
            $invoice_type_id = InvoiceType::findOrFail($invoice->invoice_type_id);

            return view('custom_pages.invoices.edit', compact('invoice', 'cost_centers', 'currencies', 'invoice_type_id', 'branches', ))->with(['currentApplicationName' => $this->currentApplicationName, 'model_search_select' => $this->model_search_select, 'model_search_select2' => $this->model_search_select2]);
        }
        else
        {
            return "not auth";
        }
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'invoice_type_id' => 'required|integer',
            'date_invoice' => 'required|date',
            'number' => 'required|integer',
            'cost_center' => 'required|integer',
            'currency' => 'required|integer',
            'branch' => 'required|integer',
            'payment_type' => 'required|integer',
            'tax_status' => 'required|integer',
            'user' => 'required|integer',
            'account' => 'required|integer',
            'collected' => 'nullable|numeric',
            'in_date_currency_rate' => 'nullable|numeric',
            'note' => 'nullable|string',
            'products.*.name' => 'required|string',
            'products.*.unit' => 'required|integer',
            'products.*.quantity' => 'required|numeric',
            'products.*.selling_price_without_tax' => 'required|numeric',
            'products.*.selling_price_with_tax' => 'required|numeric',
            'products.*.tax' => 'required|numeric',
            'products.*.discount_fixed' => 'nullable|numeric',
            'products.*.discount_percentage' => 'nullable|numeric',
            'products.*.note' => 'nullable|string',
        ]);

        // Find the invoice
        $invoice = Invoice::findOrFail($id);
        $invoice->invoice_type_id = $request->invoice_type_id;
        $invoice->date_invoice = $request->date_invoice;
        $invoice->number = $request->number;
        $invoice->cost_center_id = $request->cost_center;
        $invoice->currency_id = $request->currency;
        $invoice->branch_id = $request->branch;
        $invoice->payment_type = $request->payment_type;
        $invoice->tax_status = $request->tax_status;
        $invoice->user_id = $request->user;
        $invoice->account_id = $request->account;
        $invoice->collected = $request->collected;
        $invoice->in_date_currency_rate = $request->in_date_currency_rate;
        $invoice->note = $request->note;
        $invoice->updated_by = Auth::id(); // Assuming you have authentication
        $invoice->save();




        ////////////////////////////////////////////////////////////////////////////////////////


        if ($request->input('redirect_to') == 'show') {
            return redirect()->route('invoices.show', $invoice->id)->with('success', 'Invoice updated successfully!');
        } else {
            return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully!');
        }
    }


    public function destroy($id)
    {
        $deleted_data = $this->modelName::findOrFail($id);
        $deleted_data->delete();
        return redirect()->route($this->routeName . '.index')->with('success', $this->routeName .' deleted successfully.');
    }
}
