<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">User Dashboard</h1>
        
        <?php flash('user_message'); ?>

        <!-- User Stats -->
        <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Recent Logins</dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900"><?php echo count($data['loginHistory']); ?></dd>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Account Status</dt>
                    <dd class="mt-1">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $data['user']->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                            <?php echo ucfirst($data['user']->status); ?>
                        </span>
                    </dd>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="mt-8">
            <h2 class="text-lg font-medium text-gray-900">Recent Activity</h2>
            <div class="mt-4 bg-white shadow overflow-hidden sm:rounded-lg">
                <ul class="divide-y divide-gray-200">
                    <?php foreach($data['loginHistory'] as $session) : ?>
                        <li class="px-4 py-4">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-900">
                                    Login: <?php echo date('Y-m-d H:i:s', strtotime($session->login_time)); ?>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <?php echo $session->logout_time ? 'Logout: ' . date('Y-m-d H:i:s', strtotime($session->logout_time)) : 'Active Session'; ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>