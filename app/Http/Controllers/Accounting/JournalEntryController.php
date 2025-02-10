<?php

namespace App\Http\Controllers\Accounting;
use App\Http\Controllers\Controller;

use App\Models\Account;
use App\Models\Branch;
use App\Models\CostCenter;
use App\Models\Currency;
use App\Models\Journal;
use App\Models\JournalEntry;
use App\Models\JournalEntryAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class JournalEntryController extends Controller
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
    protected $another_table_for_radio;
    protected $model_name_for_another_table_select;
    protected $columns_table_name;
    protected $index_var;
    protected $create_var;
    protected $edit_var;
    protected $delete_var;
    public function __construct()
    {
        $this->index_var = "Accounting-journalEntrie-table";
        $this->create_var = "Accounting-journalEntrie-add";
        $this->edit_var = "Accounting-journalEntrie-edit";
        $this->delete_var = "Accounting-journalEntrie-delete";

        $this->columnsIndex = ['id','Number',];
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
        $this->routeName = 'journalEntries'; // Change to your route name
        $this->modelName = JournalEntry::class; // Change to your model name
        $this->model_name_for_another_table_select = null; // Change to  model name
        $this->currentApplicationName = "Accounting";
        $this->var_releation_radio_tree = null; // هون بنحط اسم الكولومن الموجود في الداتابيس تاع هاد الموديل
        $this->is_there_radio_tree_self = false;
        $this->is_there_radio_tree = false;
        $this->model_search_select = null; // model::class if there is model
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

    public function create()
    {
        if (auth()->user()->can($this->create_var))
        {
            $branches = Branch::get();
            $cost_centers = CostCenter::get();
            $currencies = Currency::get();
            $journals = Journal::get();
            return view('custom_pages.journal_entries.create',compact('cost_centers','currencies','journals','branches',))->with(['currentApplicationName' => $this->currentApplicationName]);

        }else
        {
            return "not auth";
        }
    }

    public function store(Request $request)
    {
        // Validate the request
         $validatedData = $request->validate([
             'date_journal' => 'required',
             'number' => 'required|integer',
             'journal' => 'required|exists:journals,id',
             'currency' => 'required|exists:currencies,id',
             'branch' => 'required|exists:branches,id',
             'in_date_currency_rate' => 'nullable|numeric',
             'note' => 'nullable|string',
         ]);

          // Custom validation to check if total credit equals total debit
        $totalDebit = 0;
        $totalCredit = 0;

        foreach ($request->accounts as $account) {
            $totalDebit += $account['depit'];
            $totalCredit += $account['credit'];
        }

        if ($totalDebit !== $totalCredit) {
            return back()->withInput()->with('error', 'Total debit must equal total credit.');
        }

        // Create a new Journal Entry
        DB::beginTransaction();

        try {
            $journalEntry = new JournalEntry();
            $journalEntry->date_journal = $validatedData['date_journal'];
            $journalEntry->number = $validatedData['number'];
            $journalEntry->journal_id = $validatedData['journal'];
            $journalEntry->currency_id = $validatedData['currency'];
            $journalEntry->branch_id = $validatedData['branch'];
            $journalEntry->in_date_currency_rate = $validatedData['in_date_currency_rate'];
            $journalEntry->note = $validatedData['note'];

            if ($request->has('photo')) {
                $photo = $request->file('photo');
                $photoPath = $photo->store($this->routeName, 'public'); // Save in the 'photos' directory within the 'public' disk
                $journalEntry['photo'] = $photoPath;
            }
            $journalEntry->save();

            $accounts = [];
            // Create Journal Entry Details
            foreach ($request->accounts as $accountData) {
                $acc = Account::where('name', $accountData['name'])->first();
                if ($acc) {
                    $accounts[$acc->id] = [
                        'depit' => $accountData['depit'],
                        'credit' => $accountData['credit'],
                        'note' => $accountData['note'],
                        'cost_center_id' => $accountData['cost_center'],
                        'updated_by' => Auth::id(),
                        'updated_at' => now(),
                    ];
                }
            }

              // Sync products to the invoice
              $journalEntry->journalAccounts()->sync($accounts);

            DB::commit();

            // Redirect based on the redirect_to field
            if ($request->redirect_to == 'index') {
                return redirect()->route('journalEntries.index')->with('success', 'Journal entry created successfully.');
            } else {
                return redirect()->route('journalEntries.show', $journalEntry->id)->with('success', 'Journal entry created successfully.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'An error occurred while creating the journal entry.']);
        }
    }

    public function show($id)
    {
        $data = $this->modelName::findOrFail($id);
        return view('crud.show', ['data' => $data, 'columns_table_name' => $this->columns_table_name, 'columns_view' => $this->columns_view, 'routeName' => $this->routeName,'currentApplicationName' => $this->currentApplicationName]);
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
