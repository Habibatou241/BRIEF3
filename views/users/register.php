<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Create an Account</h2>
        </div>
        <form class="mt-8 space-y-6" action="<?php echo URLROOT; ?>/users/register" method="post">
            <div class="rounded-md shadow-sm -space-y-px">
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" 
                        class="mt-1 appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm <?php echo (!empty($data['username_err'])) ? 'border-red-500' : ''; ?>" 
                        value="<?php echo $data['username']; ?>">
                    <?php if (!empty($data['username_err'])) : ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo $data['username_err']; ?></p>
                    <?php endif; ?>
                </div>

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
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="confirm_password" 
                        class="mt-1 appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm <?php echo (!empty($data['confirm_password_err'])) ? 'border-red-500' : ''; ?>" 
                        value="<?php echo $data['confirm_password']; ?>">
                    <?php if (!empty($data['confirm_password_err'])) : ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo $data['confirm_password_err']; ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Register
                </button>
            </div>
            <div class="text-center">
                <a href="<?php echo URLROOT; ?>/users/register" class="font-medium text-indigo-600 hover:text-indigo-500">
                Have an account? Login
                </a>
            </div>

            


           
        </form>
    </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>