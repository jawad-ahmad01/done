<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management CRUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-4 md:p-10">

    <div class="max-w-6xl mx-auto">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex justify-between">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="font-bold">&times;</button>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 h-fit">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Add New User</h2>
                <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-600">Full Name</label>
                        <input type="text" name="name" required class="w-full mt-1 p-2.5 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600">Email Address</label>
                        <input type="email" name="email" required class="w-full mt-1 p-2.5 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600">Password</label>
                        <input type="password" name="password" required class="w-full mt-1 p-2.5 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none border-gray-300">
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 text-white font-medium py-2.5 rounded-lg hover:bg-indigo-700 transition shadow-sm">
                        Register User
                    </button>
                </form>
            </div>

            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">User Details</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date Joined</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                                <div class="text-gray-500">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right space-x-3">
                                <button 
                                    onclick="openEditModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}')"
                                    class="text-indigo-600 font-medium hover:text-indigo-900">Edit</button>
                                
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 font-medium hover:text-red-700" onclick="return confirm('Archive this user?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4 bg-gray-50 border-t">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 overflow-hidden">
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Edit User Information</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>
            <form id="editForm" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-semibold text-gray-600">Full Name</label>
                    <input type="text" id="edit_name" name="name" required class="w-full mt-1 p-2.5 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-600">Email Address</label>
                    <input type="email" id="edit_email" name="email" required class="w-full mt-1 p-2.5 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none border-gray-300">
                </div>
                <div class="flex space-x-3 pt-2">
                    <button type="button" onclick="closeEditModal()" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Update User</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, name, email) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            
            // Set values in the modal inputs
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            
            // Set the dynamic action URL for the form
            form.action = `/users/${id}`;
            
            // Show the modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    </script>

</body>
</html>