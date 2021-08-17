<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="w-full bg-grey-500">
                        <div class="container mx-auto py-8">
                            <div class="w-96 mx-auto bg-white rounded shadow">
                
                                <div class="mx-16 py-4 px-8 text-black text-xl font-bold border-b border-grey-500">Create payment
                                </div>
                                
                                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                
                                <form action='{{ route('save-payment') }}' enctype='multipart/form-data' method="POST">
                                    @csrf
                                    <div class="py-4 px-8">
                                        
                                        <div class="mb-4">
                                            <label class="block text-grey-darker text-sm font-bold mb-2">Select account</label>
                                            <select name="account" id="" class="border rounded w-full py-2 px-3 text-grey-darker">
                                                @foreach ($accounts as $item)
                                                    <option value="{{ $item->id }}" > {{ $item->title }} </option>
                                                @endforeach
                                            </select>
                                            {{-- <input value="{{ old('title') }}" required class=" border rounded w-full py-2 px-3 text-grey-darker" type="text" name="title" placeholder="Enter Your Account Title"> --}}
                                        </div>
                
                                        <div class="mb-4">
                                            <label class="block text-grey-darker text-sm font-bold mb-2">Payee name</label>
                                            <input value="{{ old('payee_name') }}" required class=" border rounded w-full py-2 px-3 text-grey-darker" type="text" name="payee_name" placeholder="Enter Payee Name">
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-grey-darker text-sm font-bold mb-2">Amount</label>
                                            <input value="{{ old('amount') }}" required class=" border rounded w-full py-2 px-3 text-grey-darker" type="number" name="amount" placeholder="1234567890">
                                        </div>

                                        <div class="mb-4">
                                            <button
                                                class="mb-2 mx-16 rounded-full py-1 px-24 bg-gradient-to-r from-green-400 to-blue-500 ">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </form>
                
                            </div>
                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
