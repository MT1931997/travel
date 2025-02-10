<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Branch;
use App\Models\Currency;
use App\Models\MainAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BranchController extends Controller
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
        $this->index_var = "Settings-branch-table";
        $this->create_var = "Settings-branch-add";
        $this->edit_var = "Settings-branch-edit";
        $this->delete_var = "Settings-branch-delete";

        $this->columnsIndex = ['id','Number', 'Name'];
        $this->columns_view =
        [

            __('messages.main_acoount_expenses'),
            __('messages.main_acoount_income'),
            __('messages.main_acoount_purchase'),
            __('messages.main_acoount_employee'),
            __('messages.main_acoount_customer'),
            __('messages.main_acoount_suplier'),

            __('messages.Number'),
            __('messages.Name'),
            __('messages.Foreign_name'),
            __('messages.Email'),
            __('messages.Phone'),
            __('messages.fax'),
            __('messages.address'),
            __('messages.tax_number'),
            __('messages.numbers_after_coma'),
            __('messages.tax_status'),
            __('messages.inventory_type'),
            __('messages.is_e_invoice'),
            __('messages.can_sell_in_minus'),
            __('messages.report_header'),
            __('messages.report_footer'),
            __('messages.reciept_header'),
            __('messages.reciept_footer'),
            __('messages.photo'),
            __('messages.currency_id'),

            __('messages.sales_tax_account'),
            __('messages.discount_allowed_account'),
            __('messages.discount_received_account'),
            __('messages.salary_expenses_account'),
            __('messages.salary_debit_account'),
            __('messages.invoCost_of_goods_sold_account'),
            __('messages.goods_beginning_of_period_account'),
            __('messages.debits_account'),
            __('messages.credits_account'),
            __('messages.social_security_secretariats_account'),
            __('messages.company_contribution_to_social_security_account'),
            __('messages.receipt_account'),
        ];
        $this->columns_table_name = [
            'main_acoount_expenses_id',
            'main_acoount_income_id',
            'main_acoount_purchase_id',
            'main_acoount_employee_id',
            'main_acoount_customer_id',
            'main_acoount_suplier_id',
            'number',
            'name',
            'foreign_name',
            'email',
            'phone',
            'fax',
            'address',
            'tax_number',
            'numbers_after_coma',
            'tax_status',
            'inventory_type',
            'is_e_invoice',
            'can_sell_in_minus',
            'report_header',
            'report_footer',
            'reciept_header',
            'reciept_footer',
            'photo',
            'currency_id',
            'sales_tax_account_id',
            'discount_allowed_account_id',
            'discount_received_account_id',
            'salary_expenses_account_id',
            'salary_debit_account_id',
            'invoCost_of_goods_sold_account_id',
            'goods_beginning_of_period_account_id',
            'debits_account_id',
            'credits_account_id',
            'social_security_secretariats_account_id',
            'company_contribution_social_account_id',
            'receipt_account_id',

        ];
        $this->inputTypes = [
            'search_select',
            'search_select',
            'search_select',
            'search_select',
            'search_select',
            'search_select',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'options',
            'options',
            'options',
            'options',
            'text_area',
            'text_area',
            'text_area',
            'text_area',
            'photo',
            'select_another_table',
            'search_select2',
            'search_select2',
            'search_select2',
            'search_select2',
            'search_select2',
            'search_select2',
            'search_select2',
            'search_select2',
            'search_select2',
            'search_select2',
            'search_select2',
            'search_select2',

        ];
        $this->required = [
            null,
            null,
            null,
            null,
            null,
            null,
            'required',
             'required',
             null,
             null,
             null,
             null,
             null,
             null,
             'required',
             'required',
             'required',
             'required',
             'required',
             null,
             null,
             null,
             null,
             'required',
             'required',
             null,
             null,
             null,
             null,
             null,
             null,
             null,
             null,
             null,
             null,
             null,
             null,
            ];
            $this->options = [
                ['1' => 'Taxable', '2' => 'Non Taxable', '3' => 'Zero Tax', '4' => 'Trans', '5' => 'Not Registered'],
                ['1' => 'Periodic Inventory', '2' => 'Continues Inventory'],
                ['1' => 'Active', '2' => 'Inactive'],
                ['1' => 'Active', '2' => 'Inactive']
            ];

        $this->routeName = 'branches'; // Change to your route name
        $this->modelName = Branch::class; // Change to your model name
        $this->model_name_for_another_table_select = Currency::class; // Change to  model name
        $this->currentApplicationName = "Settings";
        $this->var_releation_radio_tree = null; // هون بنحط اسم الكولومن الموجود في الداتابيس تاع هاد الموديل
        $this->is_there_radio_tree_self = false;
        $this->is_there_radio_tree = false;
        $this->model_search_select = MainAccount::class; // model::class if there is model
        $this->model_search_select2 = Account::class; // model::class if there is model
        $this->another_table_for_radio = null; // keep it null . if there is another model change it

       // Self Class
       if ($this->is_there_radio_tree_self) {
        //$this->existing_classes = $this->modelName::with('children')->whereNull('parent_id')->get();
        } else {
            $this->existing_classes = [];
        }

        // Another Class and model
        if ($this->is_there_radio_tree) {
         //   $this->existing_classes = $this->another_table_for_radio::with('children')->whereNull('parent_id')->get();
        } else {
            $this->existing_classes = [];
        }

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
                'model_search_select2' => $this->model_search_select2,
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

         // Handle file upload
        if ($request->has('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store($this->routeName, 'public'); // Save in the 'photos' directory within the 'public' disk
            $data['photo'] = $photoPath;
        }

        if($request->input('selected_class_id')){
             $selected_class_id = $request->input('selected_class_id');
             $data[$this->var_releation_radio_tree]= $selected_class_id;
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
            'model_search_select' => $this->model_search_select,
            'model_search_select2' => $this->model_search_select2,
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

        if($request->input('selected_class_id')){
            $selected_class_id = $request->input('selected_class_id');
            $data[$this->var_releation_radio_tree]= $selected_class_id;
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
