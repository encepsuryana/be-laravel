<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {!! __('User &raquo; Create') !!}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                {{-- Error Handling --}}
                @if($errors->any())
                    <div class="mb-5" role='alert'>
                        <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                            There's something wrong
                        </div>
                        <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-2 text-red-700">
                            <p>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </p>
                        </div>
                    </div>
                @endif

                {{-- Form --}}
                <form action="{{ route('users.store') }}" class='w-full' method="POST" enctype="multipart/form-data">
                    @csrf                 
                    <div class="flex flex-wrap mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-4" for="grid-last-name">
                                Nama Lengkap
                            </label>
                            <input value="{{ old('name') }}" name="name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="John Doe">
                        </div>
                    </div>
                    <div class="flex flex-wrap mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                Email Address
                            </label>
                            <input value="{{ old('email') }}" name="email" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="email" placeholder="johndoe@mail.com">
                        </div>
                    </div>
                    <div class="flex flex-wrap mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                No. Telp
                            </label>
                            <input value="{{ old('phoneNumber') }}" name="phoneNumber" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="62821234xxx">
                        </div>
                    </div>
                    <div class="flex flex-wrap mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                Avatar
                            </label>
                            <input name="profile_photo_path" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="file" placeholder="User Image">
                        </div>
                    </div>
                    <div class="grid xl:grid-cols-2 xl:gap-6">
                        <div class="flex flex-wrap mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                    Password
                                </label>
                                <input value="{{ old('password') }}" name="password" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="password" min="8" placeholder="********">
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                    Password Confirmation
                                </label>
                                <input value="{{ old('password_confirmation') }}" name="password_confirmation" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="password" min="8" placeholder="********">
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                Alamat Lengkap
                            </label>
                            
                            <textarea name="address" rows="4" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Jln. Basuki rahmat no. ...">{{ old('address') }}</textarea>
                        </div>
                    </div>
                    <div class="grid xl:grid-cols-2 xl:gap-6">
                        <div class="flex flex-wrap mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                    No. Rumah
                                </label>
                                <input value="{{ old('houseNumber') }}" name="houseNumber" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="A8">
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                    Kota
                                </label>
                                <input value="{{ old('city') }}" name="city" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="Bandung">
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                Roles
                            </label>
                            <select name="roles" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name">
                                <option value="USER">User</option>
                                <option value="ADMIN">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-wrap mb-6">
                        <div class="w-full px-3 text-right">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Save User
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
