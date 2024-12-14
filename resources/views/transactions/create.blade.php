@extends('layouts.app')

@section('content')
<section class="max-w-2xl mx-auto mt-12 p-4 bg-white shadow-md border border-gray-200 rounded">
    <form method="POST" action="{{ route('transactions.store') }}" class="grid grid-cols-1 gap-6">
        @csrf
        <label class="block">
            <span class="text-gray-700">Description</span>
            <input value="{{ old('description') }}" name="description" type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
            @error('description')
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    {{ $message }}
                </div>
            @enderror
        </label>
        
        <label class="block">
            <span class="text-gray-700">Amount</span>
            <input value="{{ old('amount') }}" name="amount" type="number" step="0.01"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
            @error('amount')
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    {{ $message }}
                </div>
            @enderror
        </label>
        
        <label class="block">
            <span class="text-gray-700">Date</span>
            <input value="{{ old('date') }}" name="date" type="date"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
            @error('date')
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    {{ $message }}
                </div>
            @enderror
        </label>
        
        <label class="block">
            <span class="text-gray-700">Receipt File (Image or PDF)</span>
            <input name="receipt" type="file"
                class="block w-full text-sm text-slate-500 mt-4 file:mr-4 file:py-2 file:px-8 file:border-0 file:text-sm file:font-semibold file:bg-violet-100 file:text-violet-700 hover:file:bg-violet-200" />
            @error('receipt')
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    {{ $message }}
                </div>
            @enderror
        </label>
        
        <button type="submit" class="block w-full py-2 bg-indigo-600 text-white rounded">
            Submit
        </button>
    </form>
</section>
@endsection
