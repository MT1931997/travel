<?php

namespace App\Http\Controllers\Accounting;
use App\Http\Controllers\Controller;

use App\Models\Account;
use App\Models\Branch;
use App\Models\CheckPortfolio;
use App\Models\CostCenter;
use App\Models\Currency;
use App\Models\JournalEntryCheque;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JournalEntryChequeController extends Controller
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
        $this->index_var = "ReceivePay-journalEntryCheque-table";
        $this->create_var = "ReceivePay-journalEntryCheque-add";
        $this->edit_var = "ReceivePay-journalEntryCheque-edit";
        $this->delete_var = "ReceivePay-journalEntryCheque-delete";

        $this->columnsIndex = ['id','Number', 'Name'];
        $this->columns_view =
        [
            __('messages.Number'),
            __('messages.Name'),
            __('messages.Foreign_name'),
        ];
        $this->columns_table_name = ['number', 'name', 'foreign_name'];
        $this->inputTypes = ['text', 'text','text',];
        $this->required = ['required', 'required',null];
        $this->options = ['male','female'];
        $this->routeName = 'journalEntryCheques'; // Change to your route name
        $this->modelName = JournalEntryCheque::class; // Change to your model name
        $this->model_name_for_another_table_select = null; // Change to  model name
        $this->currentApplicationName = "ReceivePay";
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
            $checkPortfolios = CheckPortfolio::get();
            $costCenters = CostCenter::get();
            return view('custom_pages.journalEntryCheques.create',compact('currencies','branches','checkPortfolios','costCenters'))->with(['currentApplicationName' => $this->currentApplicationName,'model_search_select' => $this->model_search_select,'model_search_select2' => $this->model_search_select2]);

        }else
        {
            return "not auth";
        }
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'date_journal_entry_cheque' => 'required|date',
            'number' => 'required|integer',
            'currency' => 'required|integer',
            'branch' => 'required|integer',
        ]);

        // Create the journal entry cheque
        $journalEntryCheque = new JournalEntryCheque();
        $journalEntryCheque->date_journal_entry_cheque = $request->date_journal_entry_cheque;
        $journalEntryCheque->journal_entry_type = $request->journal_entry_type;
        $journalEntryCheque->number = $request->number;
        $journalEntryCheque->cheque_collection_type = $request->cheque_collection_type;
        $journalEntryCheque->currency_id = $request->currency;
        $journalEntryCheque->branch_id = $request->branch;
        $journalEntryCheque->checkPortfolio_id = $request->checkPortfolio;
        $journalEntryCheque->cash_check_account_id = $request->cash_check_account;
        $journalEntryCheque->user_id = $request->user;
        $journalEntryCheque->created_by = Auth::id(); // Assuming you have authentication
        $journalEntryCheque->save();

        // Save the cheque details
        foreach ($request->cheques as $cheque) {
            $journalEntryCheque->cheques()->create([
                'number' => $cheque['number'],
                'amount' => $cheque['amount'],
                'date_collection' => $cheque['date_collection'],
                'cheque_collection_type' => $cheque['cheque_collection_type'],
                'journalEntryCheque_id' =>$journalEntryCheque->id,
                'bank_name' => $cheque['bank_name'],
                'bank_branch' => $cheque['bank_branch'],
                'costCenter_id' => $cheque['costCenter'],
                'note' => $cheque['note'] ?? null,
            ]);
        }

        // Redirect based on the redirect_to input
        if ($request->input('redirect_to') == 'show') {
            return redirect()->route('journalEntryCheques.show', $journalEntryCheque->id)->with('success', 'Cheque created successfully!');
        } else {
            return redirect()->route('journalEntryCheques.index')->with('success', 'Cheque created successfully!');
        }
    }


    public function show($id)
    {
        $journalEntryCheque = JournalEntryCheque::with([
            'branch',
            'user',
            'cheques',
        ])->findOrFail($id);

        return view('custom_pages.journalEntryCheques.show', compact('journalEntryCheque'))->with(['currentApplicationName' => $this->currentApplicationName,]);
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
