<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Accounts') }}
        </h2>
    </x-slot>
<style>
    .btn{
        border:1px solid black;
        padding:10px;
        margin:30px;
        background-color:black;
        color:white;
        border-radius:10px;
        box-shadow:-3px 3px gray;
    }

    .btn:hover{
        transform: translate(-3px,3px);
        box-shadow:-3px 3px white;

    }
</style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('create-account') }}" class="btn" > Create account </a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <br>
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                          <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                              <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                  <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IBAN</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bank name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial start</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial end</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cheque image</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Signature image</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created at</th>
                                  </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($accounts as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->iban }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{$item->bank_name}}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{$item->serial_start}}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{$item->serial_end}}</td>
                                        <td class="px-6 py-4 whitespace-nowrap"> <a href="{{$item->cheque_image}}" target="_blank"> cheque image</a> </td>
                                        <td class="px-6 py-4 whitespace-nowrap"> <a href="{{$item->signature_image}}" target="_blank"> sign. image</a> </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{$item->created_at}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
