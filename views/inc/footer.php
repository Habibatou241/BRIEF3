</div>
    <footer class="bg-gray-800 mt-auto">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-white text-lg font-semibold mb-4">About Us</h3>
                    <p class="text-gray-400">User Management System providing secure and efficient user administration solutions.</p>
                </div>
                <div>
                    <h3 class="text-white text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="<?php echo URLROOT; ?>" class="text-gray-400 hover:text-white">Home</a></li>
                        <?php if(isset($_SESSION['user_id'])) : ?>
                            <li><a href="<?php echo URLROOT; ?>/users/profile" class="text-gray-400 hover:text-white">Profile</a></li>
                            <?php if($_SESSION['user_role'] == 1) : ?>
                                <li><a href="<?php echo URLROOT; ?>/admin/dashboard" class="text-gray-400 hover:text-white">Dashboard</a></li>
                            <?php endif; ?>
                        <?php else : ?>
                            <li><a href="<?php echo URLROOT; ?>/users/login" class="text-gray-400 hover:text-white">Login</a></li>
                            <li><a href="<?php echo URLROOT; ?>/users/register" class="text-gray-400 hover:text-white">Register</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li>Email: contact@example.com</li>
                        <li>Phone: (123) 456-7890</li>
                        <li>Address: 123 Street Name, City</li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-700 pt-8">
                <p class="text-center text-gray-400">&copy; <?php echo date('Y'); ?> <?php echo SITENAME; ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>