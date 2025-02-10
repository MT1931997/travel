@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">📊 Accounting Dashboard</h2>
    <div class="row">
        @php
            $routes = [
                ['name' => 'Main Accounts', 'route' => 'mainAccounts.index', 'icon' => 'fa-solid fa-chart-line'],
                ['name' => 'Journals', 'route' => 'journals.index', 'icon' => 'fa-solid fa-book'],
                ['name' => 'Cost Centers', 'route' => 'costCenters.index', 'icon' => 'fa-solid fa-money-bill-wave'],
                ['name' => 'Accounts', 'route' => 'accounts.index', 'icon' => 'fa-solid fa-user-tie'],
                ['name' => 'Invoice Types', 'route' => 'invoiceTypes.index', 'icon' => 'fa-solid fa-file-invoice'],
                ['name' => 'Payment Terms', 'route' => 'paymentTerms.index', 'icon' => 'fa-solid fa-credit-card'],
                ['name' => 'Assets', 'route' => 'assets.index', 'icon' => 'fa-solid fa-coins'],
                ['name' => 'Credit Cards', 'route' => 'creditCards.index', 'icon' => 'fa-solid fa-university'],
                ['name' => 'Account Settings', 'route' => 'accountSettings.index', 'icon' => 'fa-solid fa-cogs'],
                ['name' => 'Supplier Categories', 'route' => 'suplierCategories.index', 'icon' => 'fa-solid fa-boxes'],
                ['name' => 'Suppliers', 'route' => 'supliers.index', 'icon' => 'fa-solid fa-truck'],
                ['name' => 'Invoices', 'route' => 'invoices.index', 'icon' => 'fa-solid fa-receipt'],
                ['name' => 'Journal Entries', 'route' => 'journalEntries.index', 'icon' => 'fa-solid fa-book-open'],
                ['name' => 'Pay/Receive', 'route' => 'payReceives.index', 'icon' => 'fa-solid fa-wallet'],
                ['name' => 'Check Portfolios', 'route' => 'checkPortfolios.index', 'icon' => 'fa-solid fa-check-double'],
                ['name' => 'Journal Entry Cheques', 'route' => 'journalEntryCheques.index', 'icon' => 'fa-solid fa-money-check-alt'],
            ];
        @endphp

        @foreach($routes as $route)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm border-0 bg-light">
                    <div class="card-body text-center">
                        <div class="icon-container mb-3">
                            <i class="{{ $route['icon'] }} fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title fw-bold">{{ $route['name'] }}</h5>
                        <a href="{{ route($route['route']) }}" class="btn btn-outline-primary mt-2">
                            <i class="fa-solid fa-arrow-right"></i> Open
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .icon-container {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #f6fbff, #4c80b8);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        transition: 0.3s ease-in-out;
    }
    .card:hover .icon-container {
        transform: scale(1.1);
    }
    .card {
        transition: 0.3s;
        border-radius: 15px;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection
