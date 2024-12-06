<div>
    <div
        class="relative flex flex-col w-full h-full text-gray-700 bg-white shadow-md bg-clip-border rounded-xl mt-4 overflow-auto">
        <table class="w-full text-left table-auto min-w-max dark:border-gray-700/60">
            <thead>
                <tr class="border-b border-blue-gray-100 bg-blue-gray-50">
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            ID</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Nombre</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Correo</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">

                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="even:bg-blue-gray-50/50">
                        <td class="p-4">{{ $user->id }}</td>
                        <td class="p-4">{{ $user->name }}</td>
                        <td class="p-4">{{ $user->email }}</td>
                        <td class="p-4">
                            <a class="font-bold rounded-lg text-base  w-24 h-8 bg-[#0d4dff] text-[#ffffff] justify-center p-3" href="{{ route('admin.users.edit',$user)}}" > Editar
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
