<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Create New User</h1>
            <a href="<?php echo URLROOT; ?>/admin/users" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Back to Users
            </a>
        </div>

        <div class="mt-8">
            <form action="<?php echo URLROOT; ?>/admin/createUser" method="POST" class="space-y-6">
                <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" name="username" id="username" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm <?php echo (!empty($data['username_err'])) ? 'border-red-500' : ''; ?>"
                                   value="<?php echo $data['username']; ?>">
                            <span class="text-red-500 text-xs"><?php echo $data['username_err']; ?></span>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm <?php echo (!empty($data['email_err'])) ? 'border-red-500' : ''; ?>"
                                   value="<?php echo $data['email']; ?>">
                            <span class="text-red-500 text-xs"><?php echo $data['email_err']; ?></span>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm <?php echo (!empty($data['password_err'])) ? 'border-red-500' : ''; ?>"
                                   value="<?php echo $data['password']; ?>">
                            <span class="text-red-500 text-xs"><?php echo $data['password_err']; ?></span>
                        </div>

                        <div>
                            <label for="role_id" class="block text-sm font-medium text-gray-700">Role</label>
                            <select name="role_id" id="role_id" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm <?php echo (!empty($data['role_err'])) ? 'border-red-500' : ''; ?>">
                                <option value="">Select Role</option>
                                <?php foreach($data['roles'] as $role) : ?>
                                    <option value="<?php echo $role->id; ?>" <?php echo $data['role_id'] == $role->id ? 'selected' : ''; ?>>
                                        <?php echo $role->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="text-red-500 text-xs"><?php echo $data['role_err']; ?></span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>