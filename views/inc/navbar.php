<nav class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <a href="<?php echo URLROOT; ?>" class="text-white font-bold text-xl"><?php echo SITENAME; ?></a>
            </div>
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-4">
                    <a href="<?php echo URLROOT; ?>" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Home</a>
                    
                    <?php if(isset($_SESSION['user_id'])) : ?>
                        <?php if($_SESSION['user_role'] == 1) : ?>
                            <a href="<?php echo URLROOT; ?>/admin/dashboard" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                        <?php endif; ?>
                        <a href="<?php echo URLROOT; ?>/users/profile" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Profile</a>
                        <a href="<?php echo URLROOT; ?>/users/logout" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Logout</a>
                    <?php else : ?>
                        <a href="<?php echo URLROOT; ?>/users/register" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Register</a>
                        <a href="<?php echo URLROOT; ?>/users/login" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</nav>