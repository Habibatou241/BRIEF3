<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">Connection Logs</h1>

        <!-- Filter by User -->
        <div class="mt-8">
            <form class="flex gap-4 items-end">
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700">Filter by User</label>
                    <select name="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">All Users</option>
                        <?php foreach($data['users'] as $user): ?>
                            <option value="<?php echo $user->id; ?>" <?php echo $data['selectedUser'] == $user->id ? 'selected' : ''; ?>>
                                <?php echo $user->username; ?> (<?php echo $user->email; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Filter
                </button>
            </form>
        </div>

        <!-- Logs Table -->
        <div class="mt-8">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Login Time</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Logout Time</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php foreach($data['logs'] as $log): ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900"><?php echo $log->username; ?></div>
                                                <div class="text-sm text-gray-500"><?php echo $log->email; ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php echo date('Y-m-d H:i:s', strtotime($log->login_time)); ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php echo $log->logout_time ? date('Y-m-d H:i:s', strtotime($log->logout_time)) : 'Active Session'; ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php
                                                if($log->logout_time) {
                                                    $login = new DateTime($log->login_time);
                                                    $logout = new DateTime($log->logout_time);
                                                    $duration = $logout->diff($login);
                                                    echo $duration->format('%H:%I:%S');
                                                } else {
                                                    echo 'Active';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>