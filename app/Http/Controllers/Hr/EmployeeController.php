<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\EmployeeGroup;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\Models\Setting;
use App\Models\EmployeeAttendance;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;





class EmployeeController extends Controller
{
   protected $columnsIndex;
    protected $columns_view;
    protected $inputTypes;
    protected $required;
    protected $options;
    protected $optionsFromTable;
    protected $optionsFromTable2;
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
    protected $model_name_for_another_table_select2;
    protected $columns_table_name;
    protected $index_var;
    protected $create_var;
    protected $edit_var;
    protected $delete_var;
    public function __construct()
    {
        $this->index_var = "School-employee-table";
        $this->create_var = "School-employee-add";
        $this->edit_var = "School-employee-edit";
        $this->delete_var = "School-employee-delete";

        $this->columnsIndex = ['id','Number', 'Name'];
        $this->columns_view =
        [
            __('messages.Number'),
            __('messages.Name'),
            __('messages.Foreign_name'),
            __('messages.Password'),
            __('messages.name_of_job'),
            __('messages.Phone'),
            __('messages.number_of_identity'),
            __('messages.Email'),
            __('messages.address'),
            __('messages.basic_salary'),
            __('messages.social_salary'),
            __('messages.start_date_according_to_social_salary'),
            __('messages.date_of_birth'),
            __('messages.percent_of_employee_from_social_salary'),
            __('messages.percent_of_company_from_social_salary'),
            __('messages.percent_of_monthly_advance_from_salary'),
            __('messages.date_of_start'),
            __('messages.date_of_end'),
            __('messages.number_in_social'),
            __('messages.education'),
            __('messages.number_of_hourly_work_in_day'),
            __('messages.last_permit_calc_date'),
            __('messages.annual_permit'),
            __('messages.ill_permit'),
            __('messages.status'),
            __('messages.marital_status'),
            __('messages.country_of_nationality'),
            __('messages.salary_calculation_method'),
            __('messages.photo'),
            __('messages.note'),
            __('messages.Role'),
            __('messages.Branch'),
        ];
        $this->columns_table_name = ['number', 'name', 'foreign_name','password','name_of_job','phone','number_of_identity','email','address',
         'basic_salary','social_salary','start_date_according_to_social_salary','date_of_birth','percent_of_employee_from_social_salary',
         'percent_of_company_from_social_salary','percent_of_monthly_advance_from_salary','date_of_start','date_of_end',
         'number_in_social','education','number_of_hourly_work_in_day','last_permit_calc_date','annual_permit','ill_permit',
         'status','marital_status','country_of_nationality','salary_calculation_method','photo','note','role_id','branch_id',

        ];
        $this->inputTypes = [
            'text', 'text','text','text','text','text','text','text',
            'text', 'text','text','date','date','text','text','text',
            'date', 'date','text','text','text','date','text','text',
            'options','options','options','options','photo','text_area',
            'select_another_table','select_another_table_two'

         ];
        $this->required = [
            'required', 'required',null,'required'
            ,null,null,null,null,null,null,null,null
            ,null,null,null,null,null,null,null,null
            ,null,null,null,
            'required', 'required',null,'required'
            ,null,null,null, 'required','required'
         ];
         $this->options = [
            ['1' => 'Active', '2' => 'Inactive'],
            ['1' => 'Single', '2' => 'Maried'],
            ['1' => 'Jordan', '2' => 'Palestine','3'=>'Egypt'],
            ['1' => 'According to the fingerprint', '2' => 'Without fingerprint']
        ];

        $this->routeName = 'employees'; // Change to your route name
        $this->modelName = Employee::class; // Change to your model name
        $this->model_name_for_another_table_select = Role::class; // Change to  model name
        $this->model_name_for_another_table_select2 = Branch::class; // Change to  model name
        $this->currentApplicationName = "School";
        $this->var_releation_radio_tree = 'employee_group_id'; // هون بنحط اسم الكولومن الموجود في الداتابيس تاع هاد الموديل
        $this->is_there_radio_tree_self = false;
        $this->is_there_radio_tree = true;
        $this->model_search_select = null; // model::class if there is model
        $this->another_table_for_radio = EmployeeGroup::class; // keep it null . if there is another model change it

       // Self Class
      // if ($this->is_there_radio_tree_self) {
       // $this->existing_classes = $this->modelName::with('children')->whereNull('parent_id')->get();
       // } else {
      //      $this->existing_classes = [];
       // }

        // Another Class and model
        if ($this->is_there_radio_tree) {
           $this->existing_classes = $this->another_table_for_radio::with('children')->whereNull('parent_id')->get();
        } else {
            $this->existing_classes = [];
        }

        // Another Class and model for Select only
        $this->optionsFromTable = $this->model_name_for_another_table_select::get();
        $this->optionsFromTable2 = $this->model_name_for_another_table_select2::get();
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
                'model_name_for_another_table_select2' => $this->model_name_for_another_table_select2,
                'optionsFromTable' => $this->optionsFromTable,
                'optionsFromTable2' => $this->optionsFromTable2,
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

          // Add user_id to the data array
          $admin = new Admin();
          $admin->name = $request->name;
          $admin->username = $request->name;
          $admin->email = $request->email;
          $admin->password = Hash::make($request->password);
          $admin->is_super = 0;
          //$user->user_type = 2;
          //$user->role_id = $request->role_id;
          $admin->save();
          $data['admin_id'] = $admin->id;


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
            'optionsFromTable2' => $this->optionsFromTable2,            

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

           // Update admin information
           $admin = Admin::whereId($updated_data->admin_id)->first();
           $admin->name = $request->name;
           $admin->username = $request->name;
           $admin->email = $request->email;

           if (isset($request->password)) {

             $admin->password = Hash::make($request->password);

            }           
           $admin->save();


        $updated_data->update($data);
        return redirect()->route($this->routeName . '.index')->with('success', $this->routeName .' updated successfully.');
    }

    public function destroy($id)
    {
        $deleted_data = $this->modelName::findOrFail($id);
        $deleted_data->delete();
        return redirect()->route($this->routeName . '.index')->with('success', $this->routeName .' deleted successfully.');
    }

    public function fingerprint(){

        return view('admin.employee.fingerprint');
    
    }


    public function getMyLocationToFingerPrint(Request $request)
    {   

        $validator = Validator::make($request->all(), [
            'lat' => 'required|numeric|between:-90,90',  // Latitude must be valid
            'lng' => 'required|numeric|between:-180,180', // Longitude must be valid
        ]);
 
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ]);
        }

        $company_setting = Setting::first();
        $employee_id = Employee::where('admin_id',auth()->user()->id)->select('id')->first()->id;
        $employee_lat = $request->lat;
        $employee_lng = $request->lng;

        if (isset($company_setting) && $company_setting->lat != NULL && $company_setting->lng != NULL ) {

            $company_lat = $company_setting->lat;
            $company_lng = $company_setting->lng;

            $earthRadius = 6371000; // Radius of Earth in meters

            // Convert degrees to radians
            $company_lat = deg2rad($company_lat);
            $company_lng = deg2rad($company_lng);
            $employee_lat = deg2rad($employee_lat);
            $employee_lng = deg2rad($employee_lng);

            // Haversine formula
            $dLat = $employee_lat - $company_lat;
            $dLng = $employee_lng - $company_lng;

            $a = sin($dLat / 2) * sin($dLat / 2) +
                cos($company_lat) * cos($employee_lat) *
                sin($dLng / 2) * sin($dLng / 2);

            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

            $distance = round($earthRadius * $c , 2);

            if ($distance > 5) {
                    
                return response()->json([
                    'status' => 'error',
                    'message' => 'You are out of range',
                ]);

            }else{

                // Get today's date
                $today = Carbon::today()->toDateString();
                $currentTime = Carbon::now();

                // Check if the employee already has an attendance record for today
                $attendance = EmployeeAttendance::where('employee_id', $employee_id)
                    ->whereDate('date_attendance', $today)
                    ->first();

                if (!$attendance) {
                    // First check-in (morning start)
                    EmployeeAttendance::create([
                        'in_date_time' => $currentTime,
                        'date_attendance' => $today,
                        'employee_id' => $employee_id,
                        'note' => 'Checked in via fingerprint',
                    ]);

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Check-in recorded successfully',
                    ]);

                } elseif ($attendance->in_date_time && !$attendance->out_date_time) {
                    // Check-out (leaving work)
                    $attendance->update([
                        'out_date_time' => $currentTime,
                        'note' => 'Checked out via fingerprint',
                    ]);

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Check-out recorded successfully',
                    ]);

                } elseif ($attendance->in_date_time && $attendance->out_date_time && !$attendance->leave_start_time) {
                    // Leave start (break time)
                    $attendance->update([
                        'leave_start_time' => $currentTime,
                        'note' => 'Leave started via fingerprint',
                    ]);

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Leave start recorded successfully',
                    ]);

                } elseif ($attendance->leave_start_time && !$attendance->leave_back_time) {
                    // Leave back (returning from break)
                    $attendance->update([
                        'leave_back_time' => $currentTime,
                        'note' => 'Leave ended via fingerprint',
                    ]);

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Leave back recorded successfully',
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Attendance already fully recorded for today',
                    ]);
                }



            }


        }else{

            return response()->json([
                'status' => 'error',
                'message' => 'Company range not found',
            ]);

        } 

    }

  
    }
