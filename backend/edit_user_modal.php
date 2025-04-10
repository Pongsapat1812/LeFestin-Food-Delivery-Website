<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="edit_user.php" method="post">
                    <input type="hidden" id="editUserId" name="editUserId">
                    <div class="mb-3">
                        <label for="editFirstname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="editFirstname" name="editFirstname" required>
                    </div>
                    <div class="mb-3">
                        <label for="editLastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="editLastname" name="editLastname" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="editDob" name="editDob" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPhone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="editPhone" name="editPhone" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="editEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="editPassword" name="editPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="editRole" class="form-label">Role</label>
                        <select class="form-select" id="editRole" name="editRole" required>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
