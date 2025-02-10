<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Subsucription;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use App\Models\Tenant;
use Stancl\Tenancy\Database\Models\Domain; // Import Domain model
use Carbon\Carbon;

class ClientController extends Controller
{
    public function subscriptions($id)
    {
        $client = Client::findOrFail($id);
        $subscriptions = Subsucription::where('client_id', $id)->get();
        $latestSubscription = $subscriptions->last();

        return view('superAdmin.clients.subscriptions', compact('client', 'subscriptions', 'latestSubscription'));
    }

    public function storeSubscription(Request $request, $clientId)
    {
        $validatedData = $request->validate([
            'from_date' => 'required|date|after:today',
            'to_date' => 'required|date|after:from_date',
            'price_of_subscription' => 'required|numeric',
        ]);

        // Ensure the previous subscription is expired
        $latestSubscription = Subsucription::where('client_id', $clientId)
            ->orderBy('to_date', 'desc')
            ->first();

        if ($latestSubscription && $latestSubscription->to_date > now()) {
            return redirect()->back()->with('error', 'The current subscription is still active.');
        }

        Subsucription::create([
            'from_date' => $validatedData['from_date'],
            'to_date' => $validatedData['to_date'],
            'price_of_subscription' => $validatedData['price_of_subscription'],
            'client_id' => $clientId,
        ]);

        return redirect()->back()->with('success', 'New subscription added successfully!');
    }

    public function endSubscription()
        {
            // Get subscriptions that will expire in the next 7 days
            $subsucriptions = Subsucription::with('client')
                ->whereBetween('to_date', [Carbon::now()->toDateString(), Carbon::now()->addWeek()->toDateString()])
                ->get();

            return view('superAdmin.clients.endSubscriptions', compact('subsucriptions'));
        }

    public function index()
    {
        // Fetch all clients with pagination
        $data = Client::paginate(10);

        // Pass the list of clients to the view
        return view('superAdmin.clients.index', compact('data'));
    }

    public function create()
    {
        return view('superAdmin.clients.create');
    }

    /**
     * Store a newly created client in the database and create the corresponding admin.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'price_of_subscription' => 'required|numeric',
            'subdomain' => 'required|string|max:255|unique:clients,subdomain',
            'email' => 'required|email|unique:clients,email|unique:admins,email', // Ensure email is unique across clients and admins
            'password' => 'required|string|min:2',
        ]);

        // Create the client (tenant)
        $client = Client::create([
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'subdomain' => $validatedData['subdomain'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // Hash the password for the client admin
        ]);

         // Create the tenant using the Tenant model (for multi-tenancy)
         $tenant = Tenant::create([
            'id' => $client->subdomain,  // The tenant ID (subdomain)
            'data' => [
                'name' => $client->name,
                'email' => $client->email,
            ]
        ]);

        // Create a domain record for the tenant
        Domain::create([
            'domain' => $client->subdomain . '.travel.net', // Your desired subdomain format
            'tenant_id' => $tenant->id, // Link the domain to the tenant
        ]);


        // Create the corresponding admin for this client (tenant)
        Admin::create([
            'name' => $client->name,
            'email' => $client->email,
            'username' => $client->name, // Use the subdomain as the username
            'password' => $client->password, // Already hashed above
            'tenant_id' => $tenant->id, // Link the admin to the tenant
        ]);

         Subsucription::create([
        'from_date' => $validatedData['from_date'],
        'to_date' => $validatedData['to_date'],
        'price_of_subscription' => $validatedData['price_of_subscription'],
        'client_id' => $client->id,
        ]);


        // Redirect back to the dashboard with a success message
        return redirect()->route('clients.index')->with('success', 'client and admin created successfully!');
    }

    public function edit($id)
    {
        // Find the client by its ID
        $client = Client::findOrFail($id);
        // Pass the client data to the edit view
        return view('superAdmin.clients.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        // Find the client by its ID
        $client = Client::findOrFail($id);

        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'password' => 'nullable|string|min:2', // Password can be updated but isn't required
        ]);

        // Update the client's details
        $client->name = $validatedData['name'];
        $client->phone = $validatedData['phone'];
        $client->email = $validatedData['email'];

        // Update the password only if provided
        if ($request->filled('password')) {
            $client->password = Hash::make($validatedData['password']);
        }
        // Save the changes
        $client->save();


        // Redirect back with success message
        return redirect()->route('clients.index')->with('success', 'client updated successfully!');
    }



}
