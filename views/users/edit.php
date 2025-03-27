<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Profile</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Update your personal information</p>
            </div>

            <div class="border-t border-gray-200">
                <form action="<?php echo URLROOT; ?>/users/edit/<?php echo $data['id']; ?>" method="post" class="space-y-6 p-6">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" name="username" id="username" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm <?php echo (!empty($data['username_err'])) ? 'border-red-500' : ''; ?>"
                            value="<?php echo $data['username']; ?>">
                        <?php if (!empty($data['username_err'])) : ?>
                            <p class="mt-1 text-sm text-red-500"><?php echo $data['username_err']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm <?php echo (!empty($data['email_err'])) ? 'border-red-500' : ''; ?>"
                            value="<?php echo $data['email']; ?>">
                        <?php if (!empty($data['email_err'])) : ?>
                            <p class="mt-1 text-sm text-red-500"><?php echo $data['email_err']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Change Password (optional)</h4>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                <input type="password" name="current_password" id="current_password" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm <?php echo (!empty($data['current_password_err'])) ? 'border-red-500' : ''; ?>">
                                <?php if (!empty($data['current_password_err'])) : ?>
                                    <p class="mt-1 text-sm text-red-500"><?php echo $data['current_password_err']; ?></p>
                                <?php endif; ?>
                            </div>

                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                                <input type="password" name="new_password" id="new_password" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm <?php echo (!empty($data['new_password_err'])) ? 'border-red-500' : ''; ?>">
                                <?php if (!empty($data['new_password_err'])) : ?>
                                    <p class="mt-1 text-sm text-red-500"><?php echo $data['new_password_err']; ?></p>
                                <?php endif; ?>
                            </div>

                            <div>
                                <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm <?php echo (!empty($data['confirm_password_err'])) ? 'border-red-500' : ''; ?>">
                                <?php if (!empty($data['confirm_password_err'])) : ?>
                                    <p class="mt-1 text-sm text-red-500"><?php echo $data['confirm_password_err']; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="<?php echo URLROOT; ?>/users/profile" 
                           class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>