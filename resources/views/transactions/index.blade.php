
@extends('layouts.app')

@section('content')
<section class="container mx-auto mt-12 p-4 bg-white shadow-md border border-gray-200 rounded">
    <div class="flex items-center justify-between border-b border-gray-200 pb-4">
        <h4 class="font-medium">Transaction List</h4>
        <div class="flex space-x-4">
            <a href="{{ route('transactions.create') }}" class="flex items-center p-2 bg-sky-50 text-xs text-sky-900 hover:bg-sky-500 hover:text-white transition rounded">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                New Transaction
            </a>
        </div>
    </div>
    <!-- Search Form -->
    <form method="GET" class="mt-4 w-full">
        <div class="flex">
            <input value="{{ request('s') }}" name="s" type="text" class="w-full rounded-l-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Enter search term" />
            <button type="submit" class="rounded-r-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Search
            </button>
        </div>
    </form>
    <!-- Transaction List -->
    <table class="table-auto min-w-full divide-y divide-gray-300 mt-6">
        <thead class="bg-gray-50">
            <tr>
                <th class="p-4 text-left text-sm font-semibold text-gray-900">Description</th>
                <th class="p-4 text-left text-sm font-semibold text-gray-900">Amount</th>
                <th class="p-4 text-left text-sm font-semibold text-gray-900">Date</th>
                <th class="p-4 text-left text-sm font-semibold text-gray-900">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            @foreach ($transactions as $transaction)
            <tr>
                <td class="p-4 text-sm text-gray-600">{{ $transaction->description }}</td>
                <td class="p-4 text-sm text-gray-600">${{ number_format($transaction->amount, 2) }}</td>
                <td class="p-4 text-sm text-gray-600">{{ $transaction->date }}</td>
                <td class="p-4 text-sm text-gray-600 flex space-x-2">
                    <a href="{{ route('transactions.edit', $transaction->id) }}" class="p-2 bg-emerald-50 text-xs text-emerald-900 hover:bg-emerald-500 hover:text-white transition rounded">
                        Edit
                    </a>
                    <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 bg-red-50 text-xs text-red-900 hover:bg-red-500 hover:text-white transition rounded">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Pagination -->
    <div class="mt-6">
        {{ $transactions->links('pagination::bootstrap-5') }}
    </div>
</section>
@endsection
