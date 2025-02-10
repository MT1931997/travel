<?php

namespace App\Http\Controllers\Accounting;
use App\Http\Controllers\Controller;

use App\Models\Branch;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JournalController extends Controller
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
        $this->index_var = "Accounting-journal-table";
        $this->create_var = "Accounting-journal-add";
        $this->edit_var = "Accounting-journal-edit";
        $this->delete_var = "Accounting-journal-delete";

        $this->columnsIndex = ['id','Number', 'Name'];
        $this->columns_view =
        [

            __('messages.Number'),
            __('messages.Name'),
            __('messages.Foreign_name'),
            __('messages.next_number'),
            __('messages.code'),
            __('messages.cost_center_status'),
            __('messages.check_status'),
            __('messages.journal_types'),
            __('messages.numbering_type'),
            __('messages.type'),
            __('messages.branch'),
        ];
        $this->columns_table_name = [
            'number', 'name', 'foreign_name',
            'next_number',
            'code',
            'cost_center_status',
            'check_status',
            'journal_types',
            'numbering_type',
            'type',
            'branch_id',
        ];
        $this->inputTypes = ['text', 'text','text','text','text','options','options','options','options','options','select_another_table'];
        $this->required = ['required', 'required',null,null,null,'required', 'required','required', 'required','required', 'required'];
        $this->options = [
            ['1' => 'Active', '2' => 'Inactive'],
            ['1' => 'Active', '2' => 'Inactive'],
            ['1' => 'مبيعات', '2' => 'مشتريات','3' => 'كاش', '4' => 'بنك'],
            ['1' => 'تسلسلي', '2' => 'شهري','3' => 'سنوي'],
            ['1' => 'قيد', '2' => 'قيد اقفال','3' => 'سند قبض', '4' => 'سند صرف','5' => 'قيد افتتاحي', '6' => 'فاتورة مبيعات','7' => 'فاتورة مردود مبيعات', '8' => 'فاتورة مشتريات','9' => 'فاتورة مردود مشتريات'],
        ];
        $this->routeName = 'journals'; // Change to your route name
        $this->modelName = Journal::class; // Change to your model name
        $this->model_name_for_another_table_select = Branch::class; // Change to  model name
        $this->currentApplicationName = "Accounting";
        $this->var_releation_radio_tree = null; // هون بنحط اسم الكولومن الموجود في الداتابيس تاع هاد الموديل
        $this->is_there_radio_tree_self = false;
        $this->is_there_radio_tree = false;
        $this->model_search_select = null; // model::class if there is model
        $this->another_table_for_radio = null; // keep it null . if there is another model change it

    //    // Self Class
    //    if ($this->is_there_radio_tree_self) {
    //    // $this->existing_classes = $this->modelName::with('children')->whereNull('parent_id')->get();
    //     } else {
    //         $this->existing_classes = [];
    //     }

    //     // Another Class and model
    //     if ($this->is_there_radio_tree) {
    //       //  $this->existing_classes = $this->another_table_for_radio::with('children')->whereNull('parent_id')->get();
    //     } else {
    //         $this->existing_classes = [];
    //     }

        // Another Class and model for Select only

        $this->optionsFromTable = $this->model_name_for_another_table_select::get();
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
            return view('crud.create', [
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
                'model_search_select' => $this->model_search_select,
                'model_name_for_another_table_select' => $this->model_name_for_another_table_select,
                'optionsFromTable' => $this->optionsFromTable,
            ]);

        }else
        {
            return "not auth";
        }
    }

    public function store(Request $request)
    {
        // Validation here
        $data = $request->only($this->columns_table_name);

        if($request->input('selected_class_id')){
             $selected_class_id = $request->input('selected_class_id');
             $data[$this->var_releation_radio_tree]= $selected_class_id;
        }

            // Handle file upload
        if ($request->has('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store($this->routeName, 'public'); // Save in the 'photos' directory within the 'public' disk
            $data['photo'] = $photoPath;
        }

        $this->modelName::create($data);
        return redirect()->route($this->routeName . '.index')->with('success', $this->routeName .' created successfully.');
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
