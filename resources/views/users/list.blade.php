@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
@endsection

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ trans('users.listing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-right mb-2">
                        <a href="{{ route('users.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">{{ trans('global.create') }}</a>
                    </div>
                    <table class="border-collapse table-auto w-full">
                        <thead>
                            <tr>
                                <th class="text-left">{{ trans('global.id') }}</th>
                                <th class="text-left">{{ trans('global.firstname') }}</th>
                                <th class="text-left">{{ trans('global.lastname') }}</th>
                                <th class="text-left">{{ trans('global.email') }}</th>
                                <th class="text-left">{{ trans('global.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-t-2">
                                    <td class="py-2">{{ $user->id }}</td>
                                    <td class="py-2">{{ $user->firstname }}</td>
                                    <td class="py-2">{{ $user->lastname }}</td>
                                    <td class="py-2">{{ $user->email }}</td>
                                    <td class="py-2">
                                        <div class="flex space-x-4">
                                            <a href="{{ route('users.edit', ['user' => $user]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                            <a href="javascript:void(0);"
                                               data-url="{{ route('users.destroy', ['user' => $user]) }}"
                                               class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded btn-delete">Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <form method="POST" action="" id="delete-form">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="delete-modal"></div>
</x-app-layout>
