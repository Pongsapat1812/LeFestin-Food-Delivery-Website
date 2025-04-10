<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS from CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="admin_panel.css" rel="stylesheet">
</head>

<body>
    <?php include 'fetch_data.php'; ?>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="content">
            <h2>Navigation</h2>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#usersTable">Users Information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#teamTable">Team Information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#loginAttemptsTable">Login Attempts</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container mt-5">
        <div class="content tab-content">
            <div id="usersTable" class="tab-pane fade show active">
                <h2>Users Information</h2>
                <!-- Search Form -->
                <form action="" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search Users" aria-label="Search Users" aria-describedby="button-search-users" name="search_users" value="<?php echo isset($_GET['search_users']) ? htmlspecialchars($_GET['search_users']) : '' ?>">
                        <button class="btn btn-outline-secondary" type="submit" id="button-search-users">Search</button>
                        <?php if (isset($_GET['search_users'])) : ?>
                            <a href="admin_panel.php" class="btn btn-outline-secondary">Clear</a>
                        <?php endif; ?>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped mt-4">
                        <thead>
                            <tr>
                                <th><a href="?user_sort=id&user_order=<?php echo ($user_sort == 'id' && $user_order == 'ASC') ? 'DESC' : 'ASC'; ?>">ID</a></th>
                                <th><a href="?user_sort=firstname&user_order=<?php echo ($user_sort == 'firstname' && $user_order == 'ASC') ? 'DESC' : 'ASC'; ?>">First Name</a></th>
                                <th><a href="?user_sort=lastname&user_order=<?php echo ($user_sort == 'lastname' && $user_order == 'ASC') ? 'DESC' : 'ASC'; ?>">Last Name</a></th>
                                <th>Date of Birth</th>
                                <th>Phone</th>
                                <th><a href="?user_sort=email&user_order=<?php echo ($user_sort == 'email' && $user_order == 'ASC') ? 'DESC' : 'ASC'; ?>">Email</a></th>
                                <th>Password</th>
                                <th><a href="?user_sort=role&user_order=<?php echo ($user_sort == 'role' && $user_order == 'ASC') ? 'DESC' : 'ASC'; ?>">Role</a></th>
                                <th><a href="?user_sort=registration_timestamp&user_order=<?php echo ($user_sort == 'registration_timestamp' && $user_order == 'ASC') ? 'DESC' : 'ASC'; ?>">Registration Time</a></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo $user['firstname']; ?></td>
                                    <td><?php echo $user['lastname']; ?></td>
                                    <td><?php echo $user['dob']; ?></td>
                                    <td><?php echo $user['phone']; ?></td>
                                    <td><?php echo $user['email']; ?></td>
                                    <td><?php echo $user['password']; ?></td>
                                    <td><?php echo $user['role']; ?></td>
                                    <td><?php echo $user['registration_timestamp']; ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm editUserBtn" data-id="<?php echo $user['id']; ?>" data-toggle="modal" data-target="#editUserModal"><i class="bi bi-pencil-fill"></i> Edit</button>
                                        <button class="btn btn-danger btn-sm deleteUserBtn" data-id="<?php echo $user['id']; ?>"><i class="bi bi-trash-fill"></i> Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addUserModal">Add User</button>
                    <a href="export_users.php" class="btn btn-primary ml-3">Export to CSV</a>
                </div>
            </div>
            <div id="teamTable" class="tab-pane fade">
                <h2>Team Information</h2>
                <!-- Search Form -->
                <form action="" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search Team" aria-label="Search Team" aria-describedby="button-search-team" name="search_team" value="<?php echo isset($_GET['search_team']) ? htmlspecialchars($_GET['search_team']) : '' ?>">
                        <button class="btn btn-outline-secondary" type="submit" id="button-search-team">Search</button>
                        <?php if (isset($_GET['search_team'])) : ?>
                            <a href="admin_panel.php" class="btn btn-outline-secondary">Clear</a>
                        <?php endif; ?>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped mt-4">
                        <thead>
                            <tr>
                                <th><a href="?team_sort=team_id&team_order=<?php echo ($team_sort == 'team_id' && $team_order == 'ASC') ? 'DESC' : 'ASC'; ?>">Team ID</a></th>
                                <th>Email</th>
                                <th>Password</th>
                                <th><a href="?team_sort=role&team_order=<?php echo ($team_sort == 'role' && $team_order == 'ASC') ? 'DESC' : 'ASC'; ?>">Role</a></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($team as $member) : ?>
                                <tr>
                                    <td><?php echo $member['team_id']; ?></td>
                                    <td><?php echo $member['email']; ?></td>
                                    <td><?php echo $member['password']; ?></td>
                                    <td><?php echo $member['role']; ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm editTeamBtn" data-id="<?php echo $member['team_id']; ?>" data-toggle="modal" data-target="#editTeamModal"><i class="bi bi-pencil-fill"></i> Edit</button>
                                        <button class="btn btn-danger btn-sm deleteTeamBtn" data-id="<?php echo $member['team_id']; ?>"><i class="bi bi-trash-fill"></i> Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addTeamModal">Add Team Member</button>
                    <a href="export_team.php" class="btn btn-primary ml-3">Export to CSV</a>
                </div>
            </div>
            <div id="loginAttemptsTable" class="tab-pane fade">
                <h2>Login Attempts</h2>
                <div class="table-responsive">
                    <table class="table table-striped mt-4">
                        <thead>
                            <tr>
                                <th>Login ID</th>
                                <th>Email</th>
                                <th>Login Status</th>
                                <th>Login Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($login_attempts as $attempt) : ?>
                                <tr>
                                    <td><?php echo $attempt['id']; ?></td>
                                    <td><?php echo $attempt['email']; ?></td>
                                    <td><?php echo $attempt['login_status']; ?></td>
                                    <td><?php echo $attempt['login_time']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <?php include 'add_user_modal.php'; ?>

    <!-- Edit User Modal -->
    <?php include('edit_user_modal.php'); ?>

    <!-- Delete User Modal -->
    <?php include('delete_user_modal.php'); ?>

    <!-- Add Team Member Modal -->
    <?php include 'add_team_modal.php'; ?>

    <!-- Edit Team Member Modal -->
    <?php include('edit_team_modal.php'); ?>

    <!-- Delete Team Member Modal -->
    <?php include('delete_team_modal.php'); ?>

    <!-- jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Script -->
    <script src="admin.js"></script>
</body>

</html>
