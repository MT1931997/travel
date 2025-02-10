<?php

namespace App\Http\Controllers\Accounting;
use App\Http\Controllers\Controller;

use App\Models\Account;
use App\Models\Branch;
use App\Models\Currency;
use App\Models\JournalEntry;
use App\Models\PayReceive;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PayReceiveController extends Controller
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
        $this->index_var = "Accounting-payReceive-table";
        $this->create_var = "Accounting-payReceive-add";
        $this->edit_var = "Accounting-payReceive-edit";
        $this->delete_var = "Accounting-payReceive-delete";

        $this->columnsIndex = ['id','Number',];
        $this->columns_view =
        [

            __('messages.type'),
            __('messages.Number'),
            __('messages.date_pay_receive'),
            __('messages.amount'),
            __('messages.note'),
            __('messages.in_date_currency_rate'),
            __('messages.currency_id'),
            __('messages.journal_id'),
            __('messages.branch_id'),
            __('messages.account_id'),
            __('messages.user_id'),
        ];
        $this->columns_table_name = ['number', 'name', 'foreign_name'];
        $this->inputTypes = ['text', 'text','text',];
        $this->required = ['required', 'required',null];
        $this->options = ['male','female'];
        $this->routeName = 'payReceives'; // Change to your route name
        $this->modelName = PayReceive::class; // Change to your model name
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
            $branches = Branch::get();
            $currencies = Currency::get();
            return view('custom_pages.payReceives.create',compact('branches','currencies'))->with(['currentApplicationName' => $this->currentApplicationName,'model_search_select' => $this->model_search_select,'model_search_select2'=>$this->model_search_select2]);

        }else
        {
            return "not auth";
        }
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'date_pay_receive' => 'required|date',
            'number' => 'required|integer',
            'amount' => 'required|numeric',
            'currency' => 'required|exists:currencies,id',
            'branch' => 'required|exists:branches,id',
            'user' => 'required|exists:users,id',
            'account' => 'required|exists:accounts,id',
            'in_date_currency_rate' => 'nullable|numeric',
            'note' => 'nullable|string',
            'journal_id' => 'required|integer',
            'type' => 'required|integer',
        ]);

        // Create a new PayReceive record
        $payReceive = new PayReceive();
        $payReceive->date_pay_receive = $request->input('date_pay_receive');
        $payReceive->number = $request->input('number');
        $payReceive->amount = $request->input('amount');
        $payReceive->currency_id = $request->input('currency');
        $payReceive->branch_id = $request->input('branch');
        $payReceive->user_id = $request->input('user');
        $payReceive->account_id = $request->input('account');
        $payReceive->in_date_currency_rate = $request->input('in_date_currency_rate');
        $payReceive->note = $request->input('note');
        $payReceive->journal_id = $request->input('journal_id');
        $payReceive->type = $request->input('type');

        // Save the PayReceive record to the database
        $payReceive->save();

           // Create JournalEntry
           $journalEntry = new JournalEntry();
           $journalEntry->date_journal = $request->date_pay_receive;
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

           $branchAcoountForReceive= Branch::select('receipt_account_id')->first()->receipt_account_id; //   في جدول الفروع اسم الحساب
           $creditAccount = Account::find($request->account); // (الصندوق)

           $userId = $request->user;
           $customer = User::find($userId);

           $idAccountOfUserDepit = null;
           $idAccountOfUserDepit = Branch::select('debits_account_id')->first()->debits_account_id; // ذمم مدينة
           $idAccountOfUserCredit = Branch::select('credits_account_id')->first()->credits_account_id; // ذمم دائنة

           if($request->type == 1)
           {
            // صرف
            $accounts = [];
            // Create Journal Entry Details
            if ( $branchAcoountForReceive && $creditAccount) {
                // ذمم مدينة
                $accounts[] = [
                    'account_id' => $idAccountOfUserDepit,
                    'depit' => $request->amount,
                    'credit' => 0,
                    'note' => $request->note,
                    'cost_center_id' => $request->cost_center_id ?? null,
                    'updated_by' => Auth::id(),
                    'updated_at' => now(),
                ];

                // الصندوق
                $accounts[] = [
                    'account_id' => $creditAccount->id,
                    'depit' => 0,
                    'credit' => $request->amount,
                    'note' => $request->note,
                    'cost_center_id' => $request->cost_center_id ?? null,
                    'updated_by' => Auth::id(),
                    'updated_at' => now(),
                ];
            } else {
                Log::error('Accounts not found', ['branchAcoountForReceive' => $branchAcoountForReceive, 'creditAccount' => $creditAccount]);
            }

            // Sync accounts to the journal entry
            if (!empty($accounts)) {
                $journalEntry->journalAccounts()->sync($accounts);
                Log::info('JournalEntry accounts synced successfully', ['accounts' => $accounts]);
            } else {
                Log::error('No accounts to sync', ['accounts' => $accounts]);
            }

           }else
           {
            //قبض
            $accounts = [];
            // Create Journal Entry Details
            if ( $branchAcoountForReceive && $creditAccount) {
                //
                $accounts[] = [
                    'account_id' => $branchAcoountForReceive,
                    'depit' => $request->amount,
                    'credit' => 0,
                    'note' => $request->note,
                    'cost_center_id' => $request->cost_center_id ?? null,
                    'updated_by' => Auth::id(),
                    'updated_at' => now(),
                ];

                //
                $accounts[] = [
                    'account_id' => $idAccountOfUserCredit,
                    'depit' =>0,
                    'credit' => $request->amount,
                    'note' => $request->note,
                    'cost_center_id' => $request->cost_center_id ?? null,
                    'updated_by' => Auth::id(),
                    'updated_at' => now(),
                ];
            } else {
                Log::error('Accounts not found', ['branchAcoountForReceive' => $branchAcoountForReceive, 'creditAccount' => $creditAccount]);
            }

            // Sync accounts to the journal entry
            if (!empty($accounts)) {
                $journalEntry->journalAccounts()->sync($accounts);
                Log::info('JournalEntry accounts synced successfully', ['accounts' => $accounts]);
            } else {
                Log::error('No accounts to sync', ['accounts' => $accounts]);
            }

           }


        // Redirect based on the redirect_to value
        if ($request->input('redirect_to') == 'show') {
            return redirect()->route('payReceives.show', $payReceive->id)->with('success', 'Created successfully!');
        } else {
            return redirect()->route('payReceives.index')->with('success', 'Created successfully!');
        }
    }

    public function show($id)
    {
        $payReceives = PayReceive::with([
            'branch',
            'user',
            'journal',
        ])->findOrFail($id);

        return view('custom_pages.payReceives.show', compact('payReceives'))->with(['currentApplicationName' => $this->currentApplicationName,]);
    }

    public function edit($id)
    {
        $data = $this->modelName::findOrFail($id);
        return view('crud.edit', [
            'data' => $data,
            'columns_view' => $this->columns_view,
            'columns_table_name' => $this->columns_table_name,
            'inputTypes' => $this->inputTypes,
            'required' => $this->required,
            'options' => $this->options,
            'is_there_radio_tree_self' => $this->is_there_radio_tree_self,
            'routeName' => $this->routeName,
            'currentApplicationName' => $this->currentApplicationName,
            'existing_classes' => $this->existing_classes,
            'is_there_radio_tree' => $this->is_there_radio_tree,
            'another_table_for_radio' => $this->another_table_for_radio,
            'optionsFromTable' => $this->optionsFromTable,

        ]);
    }

    public function update(Request $request, $id)
    {
        // Validation here
        $data = $request->only($this->columns_table_name);
        $updated_data = $this->modelName::findOrFail($id);

        if($request->input('selected_class_id')){
            $selected_class_id = $request->input('selected_class_id');
            $data[$this->var_releation_radio_tree]= $selected_class_id;
        }

        // Handle file upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            // Store the new photo in the 'photos' directory within the 'public' disk
            $photoPath = $photo->store($this->routeName, 'public');
            $data['photo'] = $photoPath;

            // Delete the old photo if exists
            if ($updated_data->photo) {
                Storage::disk('public')->delete($updated_data->photo);
            }
        }
        $updated_data->update($data);
        return redirect()->route($this->routeName . '.index')->with('success', $this->routeName .' updated successfully.');
    }

    public function destroy($id)
    {
        $deleted_data = $this->modelName::findOrFail($id);
        $deleted_data->delete();
        return redirect()->route($this->routeName . '.index')->with('success', $this->routeName .' deleted successfully.');
    }
}
