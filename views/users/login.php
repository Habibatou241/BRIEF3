<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Login to your account</h2>
        </div>
        <form class="mt-8 space-y-6" action="<?php echo URLROOT; ?>/users/login" method="post">
            <div class="rounded-md shadow-sm -space-y-px">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" 
                        class="mt-1 appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm <?php echo (!empty($data['email_err'])) ? 'border-red-500' : ''; ?>" 
                        value="<?php echo $data['email']; ?>">
                    <?php if (!empty($data['email_err'])) : ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo $data['email_err']; ?></p>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" 
                        class="mt-1 appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm <?php echo (!empty($data['password_err'])) ? 'border-red-500' : ''; ?>" 
                        value="<?php echo $data['password']; ?>">
                    <?php if (!empty($data['password_err'])) : ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo $data['password_err']; ?></p>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700">Login As</label>
                    <select name="role" 
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="2">User</option>
                        <option value="1">Admin</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Login
                </button>
            </div>
            <div class="text-center">
                <a href="<?php echo URLROOT; ?>/users/register" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Don't have an account? Register
                </a>
            </div>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>